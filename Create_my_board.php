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
<title>Create_my_board</title>
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
<p><table border=1 bordercolor="#F0F0FF" align=center>
<th colspan="6" align=left><font color="blue" size="6"><strong>Create New Board</strong></font></th>
<tr><form name="form1" method="post" action="create_current_board_process.php" id="form1"></tr>
<td colspan="3"><font color="purple" size="3"><strong>Board info</strong></font></td></tr>
<tr><td width="78">Board_name</td><td width="6">:</td>
<td width="294"><input name="bname" type="text" id="bname" ></td></tr>
<tr><td>Description</td>
<td>:</td>
<td><input name="description" type="text" id="description" ></td></tr>
<tr><td>Privacy</td>
<td>:</td>
<td><input name="privacy" type="radio" value="public" checked="checked">public<br>
<input name="privacy" type="radio" value="friend only">friend only<br>
<input name="privacy" type="radio" value="private">private</td></tr>
<tr><td>Category</td>
<td>:</td>
<td><select name="category" form="form1">
<option value="1" selected="selected">Star</option>
<option value="2">Universe</option>
<option value="3">Sports</option>
<option value="4">Climbing</option>
<option value="5">Rock</option>
<option value="6">Education</option>
<option value="7">Travel</option>
<option value="8">Star</option></select></td></tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Okay"></td>
</tr></form></p>
</body>
</html>