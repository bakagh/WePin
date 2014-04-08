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
<title>Edit_my_profile</title>
<h3><strong>Edit My Profile</strong></h3>
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
<?php
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$read_profile = 'SELECT * FROM User U, Account A WHERE U.uid = A.uid AND A.username = "'.$_SESSION['sess_username'].'"';
$result = mysql_query($read_profile) or die(mysql_error());
if (mysql_num_rows($result) == 0) {
  echo "no data";	
}
$profile_row = mysql_fetch_array($result);
echo '<form name="form1" method="post" action="Edit_profile_process.php">';
echo '<input name="uid" type="hidden" id="uid" value="'.$profile_row['uid'].'">';
echo '<table border="1">';
echo '<tr><td><strong>First Name</strong></td>';
echo '<td>:</td>';
echo '<td><input name="firstname" type="text" id="firstname" value="'.$profile_row['first_name'].'" /></td></tr>';
echo '<tr><td><strong>Last Name</strong></td>';
echo '<td>:</td>';
echo '<td><input name="lastname" type="text" id="lastname" value="'.$profile_row['last_name'].'" /></td></tr>';
echo '<tr><td><strong>Email</strong></td>';
echo '<td>:</td>';
echo '<td><input name="email" type="email" id="email" value="'.$profile_row['email'].'" /></td></tr>';
echo '<tr><td><strong>Gender<strong></td>';
echo '<td>:</td>';
if (strcmp($profile_row['gender'], "Male") == 0) {
  echo '<td><input name="gender" type="radio" id="gender" value="Male" checked="checked">Male<br>';
  echo '<input name="gender" type="radio" id="gender" value="Female" />Female</td></tr>';
} else {
  echo '<td><input name="gender" type="radio" id="gender" value="Male" />Male<br>';
  echo '<input name="gender" type="radio" id="gender" value="Female" checked="checked" />Female</td></tr>';
}
echo '<tr><td><strong>Country</strong></td>';
echo '<td>:</td>';
echo '<td><input name="country" type="country" id="country" value="'.$profile_row['country'].'" /></td></tr>';
echo '<tr><td>&nbsp;</td>';
echo '<td>&nbsp;</td>';
echo '<td><input type="submit" name="Submit" value="Okay"></td></tr>';
echo '</table>';
?>
</body>
</html>