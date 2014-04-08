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
if ((strcmp($password, $gp_row['password']) != 0)&&(isset($_POST['pid']))) {
  header("location: delete_current_picture.php?error=psd_error&pid=".$_POST['pid']);	
} else if ((strcmp($password, $gp_row['password']) != 0)&&(isset($_POST['rpid']))) {
  header("location: delete_current_picture.php?error=psd_error&rpid=".$_POST['rpid']);
} else {
  $description = $_POST['description'];
  $bid = $_POST['bid'];
  if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
	# First delete repin picture.
	$delete_repin_picture = "DELETE FROM Repin_Picture WHERE from_pid = '$pid'";
	mysql_query($delete_repin_picture) or die("EEROR0".mysql_error());
    $delete_picture = "DELETE FROM Pin_Picture WHERE pid = '$pid'";
    mysql_query($delete_picture) or die("ERROR1".mysql_error());
    header("location: edit_pictures.php?operation=delete_success&bid=".$bid);
  }
  if (isset($_POST['rpid'])) {
    $rpid = $_POST['rpid'];
    $delete_repin = "DELETE FROM Repin_Picture WHERE rpid = '$rpid'";
    mysql_query($delete_repin) or die("ERROR2".mysql_error());
    header("location: edit_pictures.php?operation=delete_success&bid=".$bid);
  }
}
?>