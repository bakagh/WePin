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
$uid = $_POST['uid'];
$comment = $_POST['comment'];
$comment = mysql_escape_string($comment);
if (isset($_POST['pid'])) {
  $pid = $_POST['pid'];
  $comment_id = generateRandomString();
  $insert_new_comment = "INSERT INTO Comment_Picture VALUES('$comment_id', '$uid', '$pid', '$comment', NOW())";
  mysql_query($insert_new_comment) or die("ERROR1".mysql_error());
  header("location: detail_pictures.php?pid=".$pid);
} else {
  $rpid = $_POST['rpid'];
  $comment_rid = generateRandomString();
  $insert_new_comment = "INSERT INTO Comment_Repin VALUES('$comment_rid', '$uid', '$rpid', '$comment', NOW())";
  mysql_query($insert_new_comment) or die("ERROR2".mysql_error());
  header("location: detail_pictures.php?rpid=".$rpid);
}
?>