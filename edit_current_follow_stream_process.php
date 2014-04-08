<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$fsid = $_POST['fsid'];
$fsname = $_POST['fsname'];
$fsdescription = $_POST['description'];
$update = "UPDATE Follow_Stream SET fsname = '$fsname', fsdescription = '$fsdescription', fsDate = NOW() WHERE fsid = '$fsid'";
mysql_query($update) or die("ERROR".mysql_error());
header("location: Edit_my_board.php");
?>