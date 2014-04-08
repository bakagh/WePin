<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$username = $_SESSION['sess_username'];
$get_request_uid = $_GET['get_request_uid'];
$status = 'processing';
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$get_my_uid = "SELECT * FROM Account WHERE username = '$username'";
$gmu_result = mysql_query($get_my_uid) or die("ERROR");
$gmu_row = mysql_fetch_array($gmu_result);
$my_uid = $gmu_row['uid'];
$update_friend_request = "INSERT INTO Friend_Request VALUES('$my_uid', '$get_request_uid', NOW(), '$status')";
$ufr_result = mysql_query($update_friend_request) or die("ERROR".mysql_error());
if ($ufr_result) {
  header("Location:user_profile.php?uid=".$get_request_uid);
}
?>