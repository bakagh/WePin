<?php
include 'Random_String_Generator.php';
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$target_uid = $_GET['target_uid'];
$my_uid = $_GET['my_uid'];
$current_status = 'accepted';
$update_friend_request = "UPDATE Friend_Request SET request_date = NOW(), status = '$current_status' WHERE uid = '$target_uid' AND get_request_uid = '$my_uid'";
mysql_query($update_friend_request) or die("ERROR".mysql_error());
$add_friend_relation = "INSERT INTO Friend_Relation VALUES('$target_uid', '$my_uid', NOW())";
mysql_query($add_friend_relation) or die("ERROR".mysql_error());
header("location: friend_list.php");
?>