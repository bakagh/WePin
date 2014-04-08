<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>edit_current_board</title>
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
function modify_current_board_op($bid) {
  $select_query = "select * from Board where bid = '$bid'";
  $result = mysql_query($select_query);
  $row = mysql_fetch_array($result);
  echo '<p><table border=1 bordercolor="#F0F0FF" align=center>';
  echo '<th colspan="6" align=left><font color="blue" size="6"><strong>Modify Current Board</strong></font></th>';
  echo '<tr>';
  echo '<form name="form1" method="post" action="edit_current_board_process.php" id="form1">';
  echo '</tr>';
  echo '<td colspan="3"><font color="purple" size="3"><strong>Board info</strong></font></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td width="78">Board_name</td>';
  echo '<td width="6">:</td>';
  echo '<td width="294"><input name="bname" type="text" id="bname" value="'.$row['bname'].'"></td>';
  echo '</tr>';
  echo '<tr><input name="bid" type="hidden" id="bid" value="'.$bid.'"></tr>';
  echo '<tr>';
  echo '<td>Description</td>';
  echo '<td>:</td>';
  echo '<td><input name="description" type="text" id="description" value="'.$row['description'].'"></td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>Privacy</td>';
  echo '<td>:</td>';
  if (strcmp($row['comControl'], "public") == 0) {
    echo '<td><input name="privacy" type="radio" value="public" checked="checked">public<br>';
    echo '<input name="privacy" type="radio" value="friend only">friend only<br>';
    echo '<input name="privacy" type="radio" value="private">private</td></tr>';
  } else if (strcmp($row['comControl'], "friend only") == 0) {
    echo '<td><input name="privacy" type="radio" value="public">public<br>';
    echo '<input name="privacy" type="radio" value="friend only" checked="checked">friend only<br>';
    echo '<input name="privacy" type="radio" value="private">private</td></tr>';
  } else if (strcmp($row['comControl'], "private") == 0) {
    echo '<td><input name="privacy" type="radio" value="public">public<br>';
    echo '<input name="privacy" type="radio" value="friend only">friend only<br>';
    echo '<input name="privacy" type="radio" value="private" checked="checked">private</td></tr>';
  }
  echo '<tr><td>Category</td>';
  echo '<td>:</td>';
  echo '<td><select name="category" form="form1">';
  if ($row['category'] == 1) {
    echo '<option value="1" selected="selected">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';
  } else if ($row['category'] == 2) {
	echo '<option value="1">Star</option>';
    echo '<option value="2" selected="selected">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';
  } else if ($row['category'] == 3) {
	echo '<option value="1">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3" selected="selected">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';  
  } else if ($row['category'] == 4) {
	echo '<option value="1">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4" selected="selected">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';   
  } else if ($row['category'] == 5) {
	echo '<option value="1">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5" selected="selected">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';   
  } else if ($row['category'] == 6) {
	echo '<option value="1">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6" selected="selected">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';   
  } else if ($row['category'] == 7) {
	echo '<option value="1">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7" selected="selected">Travel</option>';
    echo '<option value="8">Star</option></select></td></tr>';   
  } else if ($row['category'] == 8) {
	echo '<option value="1">Star</option>';
    echo '<option value="2">Universe</option>';
    echo '<option value="3">Sports</option>';
    echo '<option value="4">Climbing</option>';
    echo '<option value="5">Rock</option>';
    echo '<option value="6">Education</option>';
    echo '<option value="7">Travel</option>';
    echo '<option value="8" selected="selected">Star</option></select></td></tr>';   
  }
  echo '<tr>';
  echo '<td>&nbsp;</td>';
  echo '<td>&nbsp;</td>';
  echo '<td><input type="submit" name="Submit" value="Okay"></td>';
  echo '</tr></form></table></p>';	
}
$bid = $_GET['bid'];
modify_current_board_op($bid);
?>
</body>
</html>