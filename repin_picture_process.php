<?php
include 'Random_String_generator.php';
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$username = $_SESSION['sess_username'];
$pid = $_POST['pid'];
$bid = $_POST['bid'];
$description = $_POST['description'];
$description = mysql_escape_string($description);
$rpid = generateRandomString();
$insert_new_repin = "INSERT INTO Repin_Picture VALUES('$rpid', '$pid', '$bid', '$description', NOW())";
mysql_query($insert_new_repin) or die("ERROR".mysql_error());
header("location: view_my_board.php");
?>