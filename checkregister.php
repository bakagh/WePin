<?php
include 'Random_String_generator.php';
ob_start();
session_start();
$username = $_POST['username'];
$firstname = $_POST['first_name'];
$lastname = $_POST['last_name'];
$email = $_POST['user_email'];
$gender = $_POST['gender'];
$country = $_POST['country'];
$password = $_POST['password'];
$re_password = $_POST['re_password'];   
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn);
$username = mysql_real_escape_string($username);
$password = mysql_real_escape_string($password);
$re_password = mysql_real_escape_string($re_password); 
if (strlen($password) < 4) {
  header("location:register_page.php?registerFailed=true&reason=short_password");
} else if ($password != $re_password) {
  header("location:register_page.php?registerFailed=true&reason=re_password");
} else {
  $query = 'SELECT username FROM Account WHERE username = "'.$username.'"';       
  $result = mysql_query($query);
  if (mysql_num_rows($result) != 0) {
    header("location:register_page.php?registerFailed=true&reason=user_exist");
  } else {
    $uid = generateRandomString();
	$insert_user = "INSERT User VALUES ('$uid', '$firstname', '$lastname', '$email', '$gender', '$country')";     
    mysql_query($insert_user);
	$insert_account = "INSERT Account VALUES ('$username', '$uid', '$password')";     
    mysql_query($insert_account);
    session_regenerate_id();
    $_SESSION['sess_user_id'] = rand(0, 100);
    $_SESSION['sess_username'] = $username;
    session_write_close();
    header('Location:My_main_page.php');
  }
}
?>
