<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$re_password = $_POST['re_password'];
$conn = mysql_connect("127.0.0.1", "lw1378", "");
mysql_select_db('test', $conn) or die(mysql_error());
$username = $_SESSION['sess_username'];
$get_current_password = "SELECT password FROM Account WHERE username = '$username'";
$gcp_result = mysql_query($get_current_password);
$gcp_row = mysql_fetch_array($gcp_result) or die(mysql_error());
if (strcmp($current_password, $gcp_row['password']) != 0) {
  header("Location:Edit_my_password.php?edit_psd_error=currentPsdError");	
}
if (strcmp($new_password, $re_password) != 0) {
  header("Location:Edit_my_password.php?edit_psd_error=psddifferent");	
}
$update_password = "UPDATE Account SET password = '$new_password' WHERE username = '$username'";
mysql_query($update_profile) or die(mysql_error());
header("Location:My_main_page.php?edit_password=true");
?>