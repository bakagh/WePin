<?php
ob_start();
session_start();
$username = $_POST['username'];
$password = $_POST['password'];
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn);
$username = mysql_real_escape_string($username);
$query = 'SELECT * FROM Account WHERE username = "'.$username.'"';
$result = mysql_query($query);
if (mysql_num_rows($result) == 0) {
  header("location:User_login.php?loginFailed=true");
} else {
  $userData = mysql_fetch_array($result);
  #$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
  if ($password != $userData['password']) {
    header("location:User_login.php?loginFailed=true");
  } else { // Redirect to home page after successful login.
    session_regenerate_id();
    $_SESSION['sess_user_id'] = $userData['uid'];
    $_SESSION['sess_username'] = $userData['username'];
    session_write_close();
    header('Location:My_main_page.php');
  }
}
?>