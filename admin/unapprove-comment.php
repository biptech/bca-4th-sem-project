<?php
session_start();
include('includes/config.php');

// Redirect to login if not logged in
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
    exit();
}

$msg = '';
$delmsg = '';

// Process unapproval of comments
if (isset($_GET['disid'])) {
    $id = intval($_GET['disid']);
    $query = mysqli_query($con, "UPDATE tblcomments SET status='0' WHERE id='$id'");
    if ($query) {
        $msg = "Comment unapproved successfully.";
    } else {
        $msg = "Error: " . mysqli_error($con);
    }
}

// Process approval of comments
if (isset($_GET['appid'])) {
    $id = intval($_GET['appid']);
    $query = mysqli_query($con, "UPDATE tblcomments SET status='1' WHERE id='$id'");
    if ($query) {
        $msg = "Comment approved successfully.";
    } else {
        $msg = "Error: " . mysqli_error($con);
    }
}

// Process deletion of comments
if (isset($_GET['action']) && $_GET['action'] == 'del' && isset($_GET['rid'])) {
    $id = intval($_GET['rid']);
    $query = mysqli_query($con, "DELETE FROM tblcomments WHERE id='$id'");
    if ($query) {
        $delmsg = "Comment deleted successfully.";
    } else {
        $delmsg = "Error: " . mysqli_error($con);
    }
}
?>

<!-- HTML structure to display comments -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Unapproved Comments</title>
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <style>
        .badge-secondary {
            background-color: #6c757d;
        }
    </style>
</head>
<body>

<?php include('includes/topheader.php'); ?>
<?php include('includes/leftsidebar.php'); ?>

<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Manage Unapproved Comments</h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li><a href="#">Admin</a></li>
                            <li><a href="#">Comments</a></li>
                            <li class="active">Unapprove Comments</li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <?php if (!empty($msg)) : ?>
                        <div class="alert alert-success" role="alert">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($delmsg)) : ?>
                        <div class="alert alert-danger" role="alert">
                            <strong>Error!</strong> <?php echo htmlentities($delmsg); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="demo-box m-t-20">
                        <div class="table-responsive">
                            <table class="table m-0 table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email Id</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Post/Course</th>
                                        <th>Posting Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($con, "SELECT tblcomments.id, tblcomments.name, tblcomments.email, tblcomments.comment, tblcomments.postingDate, tblposts.id as postid, tblposts.PostTitle 
                                    FROM tblcomments JOIN tblposts ON tblposts.id = tblcomments.postId WHERE tblcomments.status = 0");
                                    $cnt = 1;
                                    while ($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row['name']); ?></td>
                                        <td><?php echo htmlentities($row['email']); ?></td>
                                        <td><?php echo htmlentities($row['comment']); ?></td>
                                        <td><span class="badge badge-secondary">Waiting for approval</span></td>
                                        <td><a href="edit-post.php?pid=<?php echo htmlentities($row['postid']); ?>"><?php echo htmlentities($row['PostTitle']); ?></a></td>
                                        <td><?php echo htmlentities($row['postingDate']); ?></td>
                                        <td width="100px">
                                            <a class="btn btn-primary btn-sm" href="unapprove-comment.php?appid=<?php echo htmlentities($row['id']); ?>" title="Approve this comment"><i class="ion-arrow-return-right"></i></a>
                                            <a class="btn btn-danger btn-sm" href="unapprove-comment.php?rid=<?php echo htmlentities($row['id']); ?>&action=del"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                        $cnt++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('includes/footer.php'); ?>
</div>

</body>
</html>
