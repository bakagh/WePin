<?php
include 'upload_image_controller.php';
include 'Random_String_generator.php';
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$bid = $_POST['bid'];
$pid = generateRandomString();
$file = $_POST['file'];
$default_description = "";
$default_urlsource = "localhost/DB_Server/";
$blobObj = new BobDemo();
$blobObj->db_connection_established();
$blobObj->insertBlob($file, $pid, $bid, $default_description, $default_urlsource);
header("location: upload_image_edit.php?pid=".$pid."&bid=".$bid);
?>