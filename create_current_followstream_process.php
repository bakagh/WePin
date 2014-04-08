<?php
include 'Random_String_generator.php';
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$get_my_uid = 'SELECT * FROM Account WHERE username = "'.$_SESSION['sess_username'].'"';
$gmu_result = mysql_query($get_my_uid);
$gmu_row = mysql_fetch_array($gmu_result);
$my_uid = $gmu_row['uid'];
$bid = $_POST['bid'];
$fsname = $_POST['fsname'];
$fsname = mysql_escape_string($fsname);
$description = $_POST['description'];
$description = mysql_escape_string($description);
$fsid = generateRandomString();
$new_fs = "INSERT INTO Follow_Stream VALUES('$fsid', '$fsname', '$description', NOW())";
mysql_query($new_fs) or die("ERROR".mysql_error());
$new_fs_board = "INSERT INTO FS_Board VALUES('$fsid', '$my_uid', '$bid')";
mysql_query($new_fs_board) or die("ERROR".mysql_error());
header("location: view_my_board.php");
?>