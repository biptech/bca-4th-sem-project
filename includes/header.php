<?php
if (session_status() == PHP_SESSION_NONE) {
// Start the session if it's not already started
session_start();
}    include 'includes/config.php';
if(isset($_SESSION['username'])){
$u_username = $_SESSION['username'];
$qry = "SELECT * FROM user_signup WHERE u_email = '$u_username'";
$result = mysqli_query($con, $qry);
$row = mysqli_fetch_assoc($result);
$u_name = $row['u_name'];
$u_id = $row['u_id'];
$parts = explode(' ', $u_name);
$firstName = $parts[0];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Navbar</title>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Font Awesome CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Custom CSS -->

<style>
.navbar-nav .nav-link,
.btnn,
.header-btn {
color: black ;
margin:0 20px;
font-weight: 500;
text-decoration: none;

}

.navbar-nav .nav-link:hover,
.btnn:hover,
.btn-d:hover{
color: #e56131 !important;
}

.btn-d{
font-weight: 500;
}

.dropdown-item:hover{
color: #e56131 !important;
}
</style>

</head>
<body>
<nav class="navbar fixed-top navbar-expand-lg bg-white fixed-top">
<div class="container">
<a class="navbar-brand" href="index.php"><img src="images/logo.png" height="50"></a>
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse justify-content-center" id="navbarResponsive">
<ul class="navbar-nav">

<li class="nav-item">
<a class="nav-link" href="index.php"><i class="fa fa-home"></i> HOME</a>
</li>
<li class="nav-item">
<a class="nav-link" href="cources.php">

<i class="fa fa-server"></i>
</i>LEARN</a>
</li>
<li class="nav-item">
<a class="nav-link" href="view_products.php"> <i class="fa fa-book"></i>
</i>BUY BOOK</a>
</li>
<li class="nav-item">
<!-- <a class="nav-link" href="about-us.php"><i class="fa fa-info-circle"></i>ABOUT</a> -->
</li>
<li class="nav-item">
<!-- <a class="nav-link" href="contact-us.php"><i class="fa fa-phone"></i>CONTACT US</a> -->
</li>
</ul>

<div class="header-btn">
<?php if (isset($_SESSION['username'])) { ?>
<div class="dropdown">
<a class="btnn dropdown-toggle" href="#" role="button" id="profileDropdownMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
<i class="fa fa-user-circle-o"></i>
<?php echo $firstName; ?>
</a>

<div class="dropdown-menu" aria-labelledby="profileDropdownMenu">
<a class="dropdown-item btn-d" href="user-profile.php?u_id=<?php echo $row['u_id'];?>"> <i class="fa fa-user-secret"></i>
PROFILE</a>
<a class="dropdown-item btn-d" href="log-out.php" onclick="return confirm('Are you sure to log out?')"><i class="fa fa-sign-out"></i>
LOG OUT</a>
</div>
</div>
<?php } else { ?>
<div class="profile-menu">
<a class="btnn" href="login.php"><i class="fa fa-sign-in"></i> LOG IN </a>
</div>
<?php } ?>
</div>

</div>
</div>
</div>
</nav>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
// Toggle dropdown submenu
$('.dropdown-toggle').click(function(){
$(this).next('.dropdown-menu').toggle();
});

// Close dropdown submenu when clicked outside
$(document).on('click', function(e) {
if (!$(e.target).closest('.dropdown').length) {
$('.dropdown-menu').hide();
}
});
});
</script>

<script>

// Add active class to the current button (highlight it)
var header = document.getElementById("myDIV");
var btns = header.getElementsByClassName("btn");
for (var i = 0; i < btns.length; i++) {
btns[i].addEventListener("click", function() {
var current = document.getElementsByClassName("active");
if (current.length > 0) {
current[0].className = current[0].className.replace(" active", "");
}
this.className += " active";
});
}
</script>
<!-- Bootstrap JS and jQuery (required for Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>