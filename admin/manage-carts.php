<?php 
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0) { 
    header('location:index.php');
} else {
    if(isset($_GET['action']) && $_GET['action'] == 'del') {
        $id = $_GET['id'];
        $query = mysqli_query($con,"DELETE FROM products WHERE id='$id'");
        if($query) {
            $msg = "Product deleted ";
        } else {
            $error = "Something went wrong. Please try again.";    
        } 
    }
}
?>

<!-- Top Bar Start -->
<?php include('includes/topheader.php');?>
<!-- ========== Left Sidebar Start ========== -->
<?php include('includes/leftsidebar.php');?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="content-page">
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Manage Carts </h4>
                        <ol class="breadcrumb p-0 m-0">
                            <li>
                                <a href="#">Admin</a>
                            </li>
                            <li>
                                <a href="#">Carts</a>
                            </li>
                            <li class="active">
                                Manage Carts
                            </li>
                        </ol>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($con, "SELECT * FROM products");
                                    $rowcount = mysqli_num_rows($query);
                                    if($rowcount == 0) {
                                    ?>
                                    <tr>
                                        <td colspan="4" align="center">
                                            <h3 style="color:red">No product found</h3>
                                        </td>
                                    </tr>
                                    <?php } else {
                                        while($row = mysqli_fetch_array($query)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlentities($row['id']);?></td>
                                        <td><?php echo htmlentities($row['name'])?></td>
                                        <td><?php echo htmlentities($row['price'])?></td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="edit-cart.php?id=<?php echo htmlentities($row['id']);?>"> <i class="fa fa-pencil"></i> Edit</a>
                                            <a class="btn btn-danger btn-sm" href="manage-carts.php?id=<?php echo htmlentities($row['id']);?>&action=del" onclick="return confirm('Do you really want to delete?')"> <i class="fa fa-trash-o"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php } }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </div>
    <!-- content -->
    <?php include('includes/footer.php');?>
</div>
<!-- End content-page -->
