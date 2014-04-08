<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Edit_my_password</title>
<h3><strong>Edit My Password</strong></h3>
<p><a href="self_manager.php"><strong><?php echo $_SESSION['sess_username']?></strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user_profile.php?"><strong>Profile</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="view_my_board.php"><strong>Board</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="friend_list.php"><strong>My Friends</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="My_main_page.php?"><strong>Return</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;</p>
</head>

<body>
<hr />
<form name="form1" method="post" action="Edit_password_process.php">
<table border="1">
<tr><td><strong>Current Password</strong></td>
<td>:</td>
<td><input name="current_password" type="password" id="current_password"></td></tr>
<tr><td><strong>New Password</strong></td>
<td>:</td>
<td><input name="new_password" type="password" id="new_password"></td></tr>
<tr><td><strong>Re-enter Password</strong></td>
<td>:</td>
<td><input name="re_password" type="password" id="re_password"></td></tr>
<tr><td><input type="submit" name="Submit" value="Okay"></td></tr>
<td colspan="3">
<?php 
if (strcmp($_GET['edit_psd_error'], "currentPsdError") == 0) { 
  echo 'Incorrect original password.';
}
if (strcmp($_GET['edit_psd_error'], "psddifferent") == 0) {
  echo 'Password and re-enter password are different.';	
}
?>
</td>
</table>
</body>
</html>