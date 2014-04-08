<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$uid = $_POST['uid'];
$first_name = $_POST['firstname'];
$last_name = $_POST['lastname'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$country = $_POST['country'];
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$update_profile = "UPDATE User SET first_name = '$first_name', last_name = '$last_name', gender = '$gender', email = '$email', country = '$country' WHERE uid = '$uid'";
mysql_query($update_profile) or die(mysql_error());
header("Location:My_main_page.php?edit_profile=true");
?>