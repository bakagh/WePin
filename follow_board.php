<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$get_my_uid = 'SELECT * FROM Account WHERE username = "'.$_SESSION['sess_username'].'"';
$gmu_result = mysql_query($get_my_uid);
$gmu_row = mysql_fetch_array($gmu_result);
$my_uid = $gmu_row['uid'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>view_my_board</title>
<p><a href="self_manager.php"><strong><?php echo $_SESSION['sess_username']?></strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user_profile.php?"><strong>Profile</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="view_my_board.php"><strong>Board</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="friend_list.php"><strong>My Friends</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="My_main_page.php"><strong>Return</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;</p>
</head>

<body>
<hr />
<?php
function add_current_follow_op($bid) {
  $select_query = "select * from Board where bid = '$bid'";
  $result = mysql_query($select_query);
  $row = mysql_fetch_array($result);
  echo '<p><table border=1 bordercolor="#F0F0FF" align=center>';
  echo '<th colspan="6" align=left><font color="blue" size="6"><strong>Follow Current Board</strong></font></th>';
  echo '<tr>';
  echo '<form name="form1" method="post" action="create_current_followstream_process.php" id="form1">';
  echo '</tr>';
  echo '<td colspan="3"><font color="purple" size="3"><strong>Follow info</strong></font></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td width="78">Follow_Stream_name</td>';
  echo '<td width="6">:</td>';
  echo '<td width="294"><input name="fsname" type="text" id="fsname"></td>';
  echo '</tr>';
  echo '<tr><input name="bid" type="hidden" id="bid" value="'.$bid.'"></tr>';
  echo '<tr>';
  echo '<td>Description</td>';
  echo '<td>:</td>';
  echo '<td><input name="description" type="text" id="description"></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>&nbsp;</td>';
  echo '<td>&nbsp;</td>';
  echo '<td><input type="submit" name="Submit" value="Okay"></td>';
  echo '</tr></form></table></p>';	
}
$bid = $_GET['bid'];
add_current_follow_op($bid);
?>
</body>
</html>