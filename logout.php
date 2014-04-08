<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
exit();
}
session_destroy();
echo 'You have been logged out. <a href="User_login.php">Go back</a>';
?>
