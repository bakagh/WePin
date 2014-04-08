<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$pid = $_POST['pid'];
$bid = $_POST['bid'];
$description = $_POST['description'];
$update_image = "UPDATE Pin_Picture SET pdescription = '$description', pdate = NOW() WHERE pid = '$pid'";
mysql_query($update_image);
header("location: board_pictures.php?bid=".$bid);
?>