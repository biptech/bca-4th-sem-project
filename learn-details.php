<?php
session_start();
include('includes/config.php');

// Generate CSRF Token if not already set
if (empty($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

// Handle form submission
if (isset($_POST['submit'])) {
    // Verify CSRF Token
    if (!empty($_POST['csrftoken']) && hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
        // Validate full name (only letters and spaces)
        if (!preg_match("/^[a-zA-Z ]+$/", $_POST['name'])) {
            echo "<script>alert('Full name must contain only letters and spaces.');</script>";
        }
        // Validate email (starts with a letter, contains letters and numbers before @)
        elseif (!preg_match("/^[a-zA-Z]+[a-zA-Z0-9._-]*@gmail\.com$/", $_POST['email'])) {
            echo "<script>alert('Invalid email format');</script>";
        }
        else {
            // Escape user inputs to prevent SQL Injection
            $name = mysqli_real_escape_string($con, $_POST['name']);
            $email = mysqli_real_escape_string($con, $_POST['email']);
            $comment = mysqli_real_escape_string($con, $_POST['comment']);
            $postid = intval($_GET['nid']);
            $status = 0; // Assuming '0' means unapproved

            // Insert comment into database
            $query = "INSERT INTO tblcomments(postId, name, email, comment, postingDate, status) VALUES ('$postid', '$name', '$email', '$comment', current_timestamp(), '$status')";

            if (mysqli_query($con, $query)) {
                echo "<script>alert('Comment successfully submitted. Comment will be displayed after admin review.');</script>";
                unset($_SESSION['token']);
                echo "<script>location.href='learn-details.php?nid=$postid'</script>";
                exit;
            } else {
                echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('CSRF token validation failed.');</script>";
    }
}

// Increment view count for the post
$postid = intval($_GET['nid']);
$sql = "UPDATE tblposts SET viewCounter = viewCounter + 1 WHERE id ='$postid'";
$con->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Online Education & Learning System | Home Page</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <!-- Bootstrap core CSS -->
    <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <!-- Custom styles -->
    <!-- <link href="css/modern-business.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="css/icons.css">
    <style>
     .containers, .card-body   {
  background-color: #ecececdb;
}
        .post-details-container {
            display: flex;
            margin-top: 20px; /* Adjust as needed */
        }

        .post-details-container .image-container {
            flex: 1;
            margin-right: 20px; /* Adjust as needed */
        }

        .post-details-container .details-container {
            flex: 2;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    <!-- Page Content -->
    <div class="containers">
    <div class="container">
        <div class="row" style="margin-top: 2%">
            <div class="col-md-12 mt-5">
                <?php
                $pid = intval($_GET['nid']);
                $currenturl = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $query = mysqli_query($con, "SELECT tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url,tblposts.postedBy,tblposts.lastUpdatedBy,tblposts.UpdationDate from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <div class="card border-0">
                        <div class="card-body">
                            <a class="badge bg-success text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid']) ?>" style="color:#fff"><?php echo htmlentities($row['category']); ?></a>
                            <a class="badge bg-warning text-decoration-none link-light" style="color:#fff"><?php echo htmlentities($row['subcategory']); ?></a>
                            <h1 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h1>
                            <p>
                                by <?php echo htmlentities($row['postedBy']); ?> on | <?php echo htmlentities($row['postingdate']); ?>
                                <?php if ($row['lastUpdatedBy'] != '') : ?>
                                    Last Updated by <?php echo htmlentities($row['lastUpdatedBy']); ?> on <?php echo htmlentities($row['UpdationDate']); ?>
                                <?php endif; ?>
                            </p>
                            <hr>
                            <div class="post-details-container">
                                <div class="image-container">
                                    <img class="img-fluid" style="max-width: 555px;" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                                </div>
                                <div class="details-container">
                                    <p class="card-text"><?php
                                                        $pt = $row['postdetails'];
                                                        echo  (substr($pt, 0)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-8">
            <?php
            $sts = 1;
            $query = mysqli_query($con, "select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
            while ($row = mysqli_fetch_array($query)) {
            ?>
                <div class="media mb-4">
                    <img class="d-flex mr-3 rounded-circle" src="images/usericon.png" alt="">
                    <div class="media-body">
                        <h5 class="mt-0"><?php echo htmlentities($row['name']); ?> <br />
                            <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']); ?></span>
                        </h5>
                        <?php echo htmlentities($row['comment']); ?>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="col-md-8">
            <hr>
            <div class="card my-4 bg-transparent border-0">
                <h5 class="card-header bg-transparent border-0">Leave a Comment</h5>
                <div class="card-body">
                    <form name="Comment" method="post">
                        <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                        <div class="form-group">
                            <input type="text" name="name" class="form-control rounded-0" placeholder="Enter your fullname" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control rounded-0" placeholder="Enter your Valid email" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control rounded-0" name="comment" rows="3" placeholder="Comment" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-danger" name="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div>
</body>
<?php include('includes/footer.php'); ?>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</html>
