<?php 
   session_start();
   include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>Online Education & Learning System</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

   <link href="css/modern-business.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
   
    <style>
        .card {
            height: auto; /* Set height to auto */
        }

        .image-container {
            position: relative;
            width: calc(100% - 20px); /* Adjusting width to account for padding */
            height: 0;
            padding-top: calc(9/16 * 100%); /* Aspect ratio of 9:16 */
            overflow: hidden; /* Hide overflowing parts of the image */
            margin: 10px; /* 10px padding around the image */
        }

        .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .margin{
            margin: 0 0 50px 0;
            background-color: #ecececdb;
        }

        .blog-margin{
            margin: 0 0 50px 0;

        }

        .cat {
           text-align: center;
           margin-top: 40px;
        }

        .swipers-wrap {
           display: flex;
           flex-wrap: wrap;
           justify-content: center;
        }

        .box {
           width: 100%; 
           border: 2px solid #ccc; 
           margin: 10px; 
           text-align: center; 
           display: flex; 
           flex-direction: column; 
           justify-content: center; 
        }

        .box:hover {
           border-color: #333; 
           transform: scale(1.1); 
        }

        .swiper-slides img {
           width: 60px; 
           height: 60px; 
           margin: 0 auto 5px; 
        }

        .swiper-slides h3 {
           margin: 0; 
        }

        .badge:hover{
            color: #fff !important;
            background-color: #e56131 !important;
        }
    </style>
</head>

<body>
    <?php include('includes/header.php');?>
  
    <div class="margin">
        <div class="container">
            <div class="row">
                <div class="col-md-16">
                    <h1 class="widget-title mb-4" id="ourcources" style="text-align: center; margin-top: 40px;"><span>LEARN MORE <br> &darr;</span></h1>

                    <div class="row">
                        <?php 
                         if (isset($_GET['pageno'])) {
                                $pageno = $_GET['pageno'];
                            } else {
                                $pageno = 1;
                            }
                            $no_of_records_per_page = 8;
                            $offset = ($pageno-1) * $no_of_records_per_page;

                            $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
                            $result = mysqli_query($con,$total_pages_sql);
                            $total_rows = mysqli_fetch_array($result)[0];
                            $total_pages = ceil($total_rows / $no_of_records_per_page);

                            $query=mysqli_query($con,"select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page");
                         while ($row=mysqli_fetch_array($query)) {
                         ?>
                        <div class="col-md-4 blog-margin">
                            <div class="card mb-4 border-0 w-100">
                                <div class="image-container">
                                    <img class="card-img-top" src="admin/postimages/<?php echo htmlentities($row['PostImage']);?>" alt="<?php echo htmlentities($row['posttitle']);?>" >
                                </div>
                                <div class="card-body">
                                    <p class="m-0">
                                        <!--category-->
                                        <a class="badge bg-success text-decoration-none link-light" href="category.php?catid=<?php echo htmlentities($row['cid'])?>" style="color:#fff"><?php echo htmlentities($row['category']);?></a>
                                        <!--Subcategory--->
                                        <a class="badge bg-warning text-decoration-none link-light" style="color:#fff"><?php echo htmlentities($row['subcategory']);?></a>
                                    </p>
                                    <p class="m-0"><small> Posted on <?php echo htmlentities($row['postingdate']);?></small></p>
                                  
                                    <?php 
                                    if(isset($_SESSION['username'])){
                                        echo '<a href="learn-details.php?nid=' . htmlentities($row['pid']) . '" class="card-title text-decoration-none text-dark">';
                                        echo '<h5 class="card-title">' . htmlentities($row['posttitle']) . ' <br> Read More</h5>';
                                        echo '</a>';
                                    }
                                    else{
                                        echo '<a href="login.php" class="card-title text-decoration-none text-dark">';
                                        echo '<h5 class="card-title">' . htmlentities($row['posttitle']) . ' <br> Read More </h5>';
                                        echo '</a>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <?php include('includes/footer.php');?>
</body>

</html>
