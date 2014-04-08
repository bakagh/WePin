<?php
include 'Random_String_Generator.php';
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$username = $_SESSION['sess_username'];
$bid = generateRandomString();
$board_name = $_POST['bname'];
$description = $_POST['description'];
$privacy = $_POST['privacy'];
$category = $_POST['category'];
$get_uid = "SELECT uid FROM Account WHERE username = '$username'";
$gu_result = mysql_query($get_uid) or die("ERROR1".mysql_error());
$gu_row = mysql_fetch_array($gu_result);
$uid = $gu_row['uid'];
$create_new_board = "INSERT INTO Board VALUES('$bid', '$uid', '$board_name', '$description', NOW(), '$category', '$privacy')";
mysql_query($create_new_board) or die("ERROR2".mysql_error());
header("Location:Edit_my_board.php?operation=create_current_board_success");
?>