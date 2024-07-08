<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="css\style.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css"> -->
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <script src="https://kit.fontawesome.com/ae61999827.js"></script>
    <title>Profile</title>
    
    <style>

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background: #f0f0f0;
  color: black;
}

header {
  background: #e56131;
  color: white;
  padding: 15px 20px;
  text-align: center;
}

.heading {
  text-align: center;
  margin-top: 6%;
  margin-bottom:4%
  overflow: hidden;
}

.heading span {
  font-size: 24px;
  font-weight: bold;
  color: black;
}

.profile {
  padding: 20px;
  background-color: #ecececdb;
}

.profile-container {
  
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 20px;
  border: 1px solid #ddd;
  border-radius: 10px;
  padding: 20px;
  margin: 20px auto;
  width: 80%;
}


.profile-img img {
  width: 100%;
  border-radius: 50%;
}

.about-text p {
  font-size: 16px;
  margin-bottom: 10px;
  color: black;
}

.about-text a.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  background: #e56131;
  color: white;
  padding: 10px 15px;
  border-radius: 5px;
  text-decoration: none;
  font-weight: bold;
}

.about-text a.btn i {
  margin-right: 5px;
}

.about-text a.btn:hover {
  background: #000;
}

    </style>
</head>
<body>
    <!--Header-->
    <?php
        include 'includes/header.php';
    ?>

<?php
    $u_id = $_GET['u_id'];
    $qry = "SELECT * FROM user_signup WHERE u_id = '$u_id'";
    include 'includes/config.php';
    $result = mysqli_query($con, $qry);
    $row = mysqli_fetch_assoc($result);
?>
    
    <!--About-->
    <section class="profile" id="profile">
        <div class="heading">
            <h1>Profile</h1>
            <h1><?php echo $row['u_name'];?></h1> 
        </div>  
        <div class="profile-container">
            <div class="profile-img">
                <img src="images\<?php echo $row['u_image'];?>" alt="">
            </div>
            <div class="about-text">
                <!-- <span>About Us</span> -->
                <!-- <p><b>Name:</b>&nbsp;<?php echo $row['u_name'];?></p> -->
                <p><b>Address:</b>&nbsp;<?php echo $row['u_address'];?></p>
                <p><b>Email:</b>&nbsp;<?php echo $row['u_email'];?></p>
                <p><b>Phone:</b>&nbsp;<?php echo $row['u_phone'];?></p>
                <p><b>Gender:</b>&nbsp;<?php echo $row['u_gender'];?></p>
                <p><b>Password:</b>&nbsp;******</p>

                <a href="edit-user-profile.php?u_id=<?php echo $row['u_id'];?>" class="btn"><i class="fa-solid fa-pen"></i> Edit</a>
                 
            </div>
        </div> 
    </section>
    
    <?php
        include 'includes/footer.php';
    ?>
</body>
</html>

