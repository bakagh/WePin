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
<title>My editor</title>
<h3>My Editor</h3>
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
<p>
<table border="1">
<tr><td><a href="Edit_my_password.php"><strong>Edit My Password</strong></a></td></tr>
<tr><td><a href="Edit_my_profile.php"><strong>Edit My Profile</strong></a></td></tr>
<tr><td><a href="Edit_my_board.php"><strong>Edit My Board</strong></a></td></tr>
<tr><td><a href="Create_my_board.php"><strong>Create My new Board</strong></a></td></tr>
</table></p>
<p><a href="logout.php"><strong>Logout</strong></a></p>
</body>
</html>