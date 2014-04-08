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
<title>friend_list</title>
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
$my_username = $_SESSION['sess_username'];
$get_my_uid = "SELECT uid FROM Account WHERE username = '$my_username'";
$gmu_result = mysql_query($get_my_uid) or die("ERROR1".mysql_error());
$gmu_row = mysql_fetch_array($gmu_result);
$my_uid = $gmu_row['uid'];
$find_friend_left = "SELECT * FROM Friend_Relation WHERE friend_B = '$my_uid'";
$ffl_result = mysql_query($find_friend_left) or die("ERROR2".mysql_error());
$find_friend_right = "SELECT * FROM Friend_Relation WHERE friend_A = '$my_uid'";
$ffr_result = mysql_query($find_friend_right) or die("ERROR3".mysql_error());
$new_friend_request = "SELECT * FROM Friend_Request WHERE get_request_uid = '$my_uid' AND status = 'processing'";
$nfr_result = mysql_query($new_friend_request) or die("ERROR".mysql_error());
echo '<p><table border="1">';
echo '<th><font color="blue" size="5"><strong>New Friend Request</strong></font></th>';
while ($nfr_row = mysql_fetch_array($nfr_result)) {
  $target_uid = $nfr_row['uid'];
  $request_date = $nfr_row['request_date'];
  $get_target_username = "SELECT * FROM Account WHERE uid = '$target_uid'";
  $gtu_result = mysql_query($get_target_username) or die("ERROR".mysql_error());
  $gtu_row = mysql_fetch_array($gtu_result);
  $target_username = $gtu_row['username'];
  echo '<tr><td><a href="user_profile.php?"><strong>'.$target_username.'</strong></a><br>';
  echo '<td><strong>'.$request_date.'</td>';
  echo '<td><a href="accept_friend_request_process.php?target_uid='.$target_uid.'&my_uid='.$my_uid.'"><strong>Accept</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;';
  echo '<a href="accept_friend_request_process.php?target_uid='.$target_uid.'&my_uid='.$my_uid.'"><strong>Deny</strong></a></td></tr>';	
}
echo '</table></p>';
echo '<p>&nbsp;&nbsp;</p>';
echo '<p><table border="1">';
echo '<th><font color="blue" size="5"><strong>Friend List</strong></font></th>';
if (mysql_num_rows($ffl_result) != 0) {
  while ($ffl_row = mysql_fetch_array($ffl_result)) {
    $friend_A = $ffl_row['friend_A'];
    $date = $ffl_row['fDate'];
    $get_friend_username = "SELECT * FROM Account WHERE uid = '$friend_A'";
    $gfu_result = mysql_query($get_friend_username) or die("ERROR4".mysql_error());
	$gfu_row = mysql_fetch_array($gfu_result);
    echo '<tr><td><a href="user_profile.php?uid='.$friend_A.'">'.$gfu_row['username'].'</td>';
    echo '<td>'.$date.'</td></tr>';
  }
}
if (mysql_num_rows($ffr_result) != 0) {
  while ($ffr_row = mysql_fetch_array($ffr_result)) {
    $friend_B = $ffr_row['friend_B'];
    $date = $ffr_row['fDate'];
    $get_friend_username = "SELECT * FROM Account WHERE uid = '$friend_B'";
    $gfu_result = mysql_query($get_friend_username) or die("ERROR5".mysql_error());
	$gfu_row = mysql_fetch_array($gfu_result);
    echo '<tr><td><a href="user_profile.php?uid='.$friend_B.'">'.$gfu_row['username'].'</td>';
    echo '<td>'.$date.'</td></tr>';
  }
}
echo '</table>';
if ((mysql_num_rows($ffl_result) == 0) && (mysql_num_rows($ffr_result) == 0)) {
  echo '<font color="red" size="4">You don\'t have friends, why not add some?</font>';	
}
?>
</body>
</html>