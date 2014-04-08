<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$username = $_SESSION['sess_username'];
$bid = $_POST['bid'];
$bname = $_POST['bname'];
$description = $_POST['description'];
$category = $_POST['category'];
$privacy = $_POST['privacy'];
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$update_board = "UPDATE Board SET bname = '$bname', description = '$description', category = '$category', comControl = '$privacy', bDate = NOW() where bid = '$bid'";
mysql_query($update_board) or die("ERROR");
header("Location:Edit_my_board.php?operation=edit_current_board_success");
?>