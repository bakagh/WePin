<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$description = $_POST['description'];
$bid = $_POST['bid'];
if (isset($_POST['pid'])) {
  $pid = $_POST['pid']; 
  $update_picture = "UPDATE Pin_Picture SET pdescription = '$description', pdate = NOW() WHERE pid = '$pid'";
  mysql_query($update_picture) or die("ERROR1".mysql_error());
  header("location: edit_pictures.php?operation=edit_success&bid=".$bid);
}
if (isset($_POST['rpid'])) {
  $rpid = $_POST['rpid'];
  $update_picture = "UPDATE Repin_Picture SET rpdescription = '$description', rpdate = NOW() WHERE rpid = '$rpid'";
  mysql_query($update_picture) or die("ERROR2".mysql_error());
  header("location: edit_pictures.php?operation=edit_success&bid=".$bid);
}
?>