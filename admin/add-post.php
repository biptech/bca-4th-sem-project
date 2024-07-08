<?php
session_start();
include('includes/config.php');
error_reporting(0);

// Session timeout handling
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
} elseif (time() - $_SESSION['last_activity'] > 900) { // 900 seconds = 15 minutes
    session_unset();
    session_destroy();
    header('location:index.php?timeout=true'); // Indicate session timeout
    exit;
}
$_SESSION['last_activity'] = time(); // Update last activity time

// Check if user is logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit;
}

$msg = "";
$error = "";

if (isset($_POST['submit'])) {
    $posttitle = htmlspecialchars($_POST['posttitle'], ENT_QUOTES); // Sanitize input
    $catid = (int)$_POST['category']; // Cast to integer
    $subcatid = (int)$_POST['subcategory']; // Cast to integer
    $postdetails = htmlspecialchars($_POST['postdescription'], ENT_QUOTES); // Sanitize input
    $postedby = $_SESSION['login'];

    // Generate a URL-friendly slug from the title
    $url = implode("-", explode(" ", $posttitle));

    // Handle file uploads securely
    if (isset($_FILES["postimage"]) && $_FILES["postimage"]["error"] == 0) {
        $imgfile = $_FILES["postimage"]["name"];
        $extension = strtolower(pathinfo($imgfile, PATHINFO_EXTENSION)); // Get file extension
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");

        // Validate file extension
        if (!in_array($extension, $allowed_extensions)) {
            $error = "Invalid format. Only jpg / jpeg / png / gif allowed.";
        } else {
            // Rename the image to avoid conflicts and security issues
            $imgnewfile = md5(time() . $imgfile) . "." . $extension;
            move_uploaded_file($_FILES["postimage"]["tmp_name"], "postimages/" . $imgnewfile);

            // Insert post into database using prepared statements
            $stmt = $con->prepare("INSERT INTO tblposts (PostTitle, CategoryId, SubCategoryId, PostDetails, PostUrl, Is_Active, PostImage, postedBy) VALUES (?, ?, ?, ?, ?, 1, ?, ?)");
            $stmt->bind_param("siissss", $posttitle, $catid, $subcatid, $postdetails, $url, $imgnewfile, $postedby);

            if ($stmt->execute()) {
                $msg = "Post successfully added";
            } else {
                $error = "Something went wrong. Please try again. Error: " . $stmt->error;
            }
        }
    } else {
        $error = "Please select an image file to upload.";
    }
}
?>

<!-- Top Bar Start -->
<?php include('includes/topheader.php'); ?>

<script>
function getSubCat(val) {
    $.ajax({
        type: "POST",
        url: "get_subcategory.php",
        data: { catid: val }, // Use JSON-like format for data
        success: function(data) {
            $("#subcategory").html(data);
        },
        error: function() {
            alert("Error fetching subcategories");
        }
    });
}
</script>

<!-- Left Sidebar -->
<?php include('includes/leftsidebar.php');?>

<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Add Post</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li><a href="#">Post</a></li>
                            <li><a href="#">Add Post</a></li>
                            <li class="active">Add Post</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <!-- Success Message -->
                    <?php if (!empty($msg)) { ?>
                        <div class="alert alert-success" role="alert">
                            <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php } ?>
                    <!-- Error Message -->
                    <?php if (!empty($error)) { ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <form name="addpost" method="post" class="row" enctype="multipart/form-data">
                <div class="form-group col-md-6">
                    <label for="posttitle">Post Title</label>
                    <input type="text" class="form-control" id="posttitle" name="posttitle" placeholder="Enter title" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="category">Category</label>
                    <select class="form-control" name="category" id="category" onChange="getSubCat(this.value);" required>
                        <option value="">Select Category</option>
                        <?php
                        $ret = mysqli_query($con, "SELECT id, CategoryName FROM tblcategory WHERE Is_Active = 1");
                        while ($result = mysqli_fetch_array($ret)) {
                            ?>
                            <option value="<?php echo htmlentities($result['id']); ?>"><?php echo htmlentities($result['CategoryName']); ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="subcategory">Sub Category</label>
                    <select class="form-control" name="subcategory" id="subcategory" >
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="header-title"><b>Post Details</b></h4>
                            <textarea class="summernote" name="postdescription" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box">
                            <h4 class="header-title"><b>Feature Image</b></h4>
                            <input type="file" class="form-control" id="postimage" name="postimage" required>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" name="submit" class="btn btn-custom waves-effect waves-light btn-md">Save and Post</button>
                    <button type="button" class="btn btn-danger waves-effect waves-light" onclick="window.location.href='discard.php';">Discard</button>
                </div>
            </form>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</div>
