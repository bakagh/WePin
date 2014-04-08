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
<title>user_profile</title>
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
if (!isset($_GET['uid'])) {
  $get_uid = 'SELECT uid FROM Account WHERE username = "'.$_SESSION['sess_username'].'"';
  $gu_result = mysql_query($get_uid) or die("ERROR1".mysql_error());
  $gu_row = mysql_fetch_array($gu_result);
  $uid = $gu_row['uid'];
  $get_usr_profile = "SELECT * FROM User WHERE uid = '$uid'";
  $gup_result = mysql_query($get_usr_profile) or die("ERROR2".mysql_error());
  $gup_row = mysql_fetch_array($gup_result);
  echo '<table border="1">';
  echo '<tr><td><strong>First Name</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['first_name'].'</td></tr>';
  echo '<tr><td><strong>Last Name</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['last_name'].'</td></tr>';
  echo '<tr><td><strong>Email</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['email'].'</td></tr>';
  echo '<tr><td><strong>Gender<strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['gender'].'</td></tr>';
  echo '<tr><td><strong>Country</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['country'].'</td></tr>';
  echo '</table>';
} else {
  $uid = $_GET['uid'];
  $get_uid = 'SELECT username FROM Account WHERE uid = "'.$uid.'"';
  $gu_result = mysql_query($get_uid) or die("ERROR3".mysql_error());
  $gu_row = mysql_fetch_array($gu_result);
  $get_usr_profile = "SELECT * FROM User WHERE uid = '$uid'";
  $gup_result = mysql_query($get_usr_profile) or die("ERROR4".mysql_error());
  $gup_row = mysql_fetch_array($gup_result);
  echo '<p><table border="1">';
  echo '<tr><td><strong>Username</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gu_row['username'].'</td></tr>';
  echo '<tr><td><strong>First Name</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['first_name'].'</td></tr>';
  echo '<tr><td><strong>Last Name</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['last_name'].'</td></tr>';
  echo '<tr><td><strong>Email</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['email'].'</td></tr>';
  echo '<tr><td><strong>Gender<strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['gender'].'</td></tr>';
  echo '<tr><td><strong>Country</strong></td>';
  echo '<td>:</td>';
  echo '<td>'.$gup_row['country'].'</td></tr>';
  echo '</table></p>';
  echo '<p><a href="view_general_board.php?username='.$gu_row['username'].'"><font color="blue" size="4"><strong>Board</strong></font></a></p>';
  $get_friend_relation = 'SELECT * FROM Friend_Relation F, Account A WHERE F.friend_A = "'.$uid.'" AND F.friend_B = A.uid AND A.username = "'.$_SESSION['sess_username'].'"';
  $get_friend_relation2 = 'SELECT * FROM Friend_Relation F, Account A WHERE F.friend_B = "'.$uid.'" AND F.friend_A = A.uid AND A.username = "'.$_SESSION['sess_username'].'"';
  $gfr_relation_result = mysql_query($get_friend_relation);
  $gfr_relation_result2 = mysql_query($get_friend_relation2);
  $gfr_relation_row = mysql_fetch_array($gfr_relation_result);
  $gfr_relation_row2 = mysql_fetch_array($gfr_relation_result2);
  if ($gfr_relation_row || $gfr_relation_row2) {
	 echo '<p><font color="blue" size="3"><strong>Friend</strong></font></p>'; 
  } else {
    $get_friend_request = 'SELECT * FROM Friend_Request F, Account A WHERE F.uid = A.uid AND A.username = "'.$_SESSION['sess_username'].'" AND F.get_request_uid = "'.$uid.'"';
    $gfr_result = mysql_query($get_friend_request);
    $gfr_row = mysql_fetch_array($gfr_result);
    if (!$gfr_row) {
      echo '<p><a href="friend_request_process.php?get_request_uid='.$uid.'"><font color="blue" size="3"><strong>Request_Friend</strong></font></a></p>';
    } else {
	  $status = $gfr_row['status'];
	  if (strcmp($status, "processing") == 0) {
	    echo '<p><font color="blue" size="3"><strong>Requested to be Friend, wait for reply.</strong></font></p>'; 
	  } else if (strcmp($status, "accepted") == 0) {
	    echo '<p><font color="blue" size="3"><strong>Friend</strong></font></p>';
	  } else if (strcmp($status, "denied") == 0) {
	    echo '<p><a href="friend_request_process.php?get_request_uid='.$uid.'"><font color="blue" size="3"><strong>Oops...Refused, try again!</strong></font></a></p>';	
	  }
    }
  }
}
?>
</body>
</html>