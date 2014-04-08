<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$username = $_SESSION['sess_username'];
$get_my_uid = "SELECT * FROM Account WHERE username = '$username'";
$gmu_result = mysql_query($get_my_uid) or die("ERROR1".mysql_error());
$gmu_row = mysql_fetch_array($gmu_result);
$my_uid = $gmu_row['uid'];
$pid = $_GET['pid'];
$new_like = "INSERT INTO Like_Picture VALUES('$my_uid', '$pid')";
mysql_query($new_like) or die("ERROR2".mysql_error());
header("location: My_main_page.php");
?>