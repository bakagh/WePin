<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$password = $_POST['password'];
$username = $_SESSION['sess_username'];
$get_psd = "SELECT password FROM Account WHERE username = '$username'";
$gp_result = mysql_query($get_psd);
$gp_row = mysql_fetch_array($gp_result);
if (!isset($password)) {
  header("location: delete_current_follow_stream.php?error=psd_error");
}
if (strcmp($password, $gp_row['password']) != 0) {
  header("location: delete_current_follow_stream.php?error=psd_error");	
} else {
  $fsid = $_POST['fsid'];
  $delete_fs = "DELETE FROM FS_Board WHERE fsid = '$fsid'";
  $delete_f = "DELETE FROM Follow_Stream WHERE fsid = '$fsid'";
  mysql_query($delete_fs) or die("ERROR".mysql_error());
  mysql_query($delete_f) or die("ERROR".mysql_error());
  header("location: Edit_my_board.php");
}
?>