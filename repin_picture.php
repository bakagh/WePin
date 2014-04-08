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
<title>edit_pictures</title>
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
if (isset($_GET['pid'])) {
  $pid = $_GET['pid'];
  echo '<p><table color="#FFFFFF" border="1">';
  $get_info = "SELECT * FROM Pin_Picture WHERE pid = '$pid'";
  $gi_result = mysql_query($get_info);
  $gi_row = mysql_fetch_array($gi_result);
  $pdata = $gi_row['pdata'];
  $pdata = 'data:image/jpeg;base64,'. base64_encode($pdata);
  $get_my_board = "SELECT * FROM Board WHERE uid = '$my_uid'";
  $gmb_result = mysql_query($get_my_board);
  echo '<tr><td><img src="'.$pdata. '"width="225" height="175" border="1" /></td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
  echo '<td><form name="form1" action="repin_picture_process.php" method="post" id="form1">';
  echo '<input name="pid" type="hidden" id="pid" value="'.$pid.'">';
  echo '<strong>Choose board to repin</strong><br>';
  while ($gmb_row = mysql_fetch_array($gmb_result)) {
    $bid = $gmb_row['bid'];
    $bname = $gmb_row['bname'];
    echo '<input name="bid" type="radio" id="bid" value="'.$bid.'">'.$bname.'<br>';
  }
  echo '<strong>Input current pictures description</strong><br>';
  echo '<input name="description" type="text" id="description"><br>';
  echo '<input name="submit" type="Submit" value="Okay"></form></td></tr></table>';
} else {
  $rpid = $_GET['rpid'];
  echo '<p><table color="#FFFFFF" border="1">';
  $get_info = "SELECT * FROM Repin_Picture WHERE rpid = '$rpid'";
  $gi_result = mysql_query($get_info);
  $gi_row = mysql_fetch_array($gi_result);
  $pid = $gi_row['from_pid'];
  $get_pic = "SELECT * FROM Pin_Picture WHERE pid = '$pid'";
  $gc_result = mysql_query($get_pic);
  $gc_row = mysql_fetch_array($gc_result);
  $pdata = $gc_row['pdata'];
  $pdata = 'data:image/jpeg;base64,'. base64_encode($pdata);
  $dst = 'detail_boards.php';
  $get_my_board = "SELECT * FROM Board WHERE uid = '$my_uid'";
  $gmb_result = mysql_query($get_my_board);
  echo '<tr><td><img src="'.$pdata. '"width="225" height="175" border="1" /></td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
  echo '<td><form name="form1" action="repin_picture_process.php" method="post" id="form1">';
  echo '<input name="pid" type="hidden" id="pid" value="'.$pid.'">';
  echo '<strong>Choose board to repin</strong><br>';
  while ($gmb_row = mysql_fetch_array($gmb_result)) {
    $bid = $gmb_row['bid'];
    $bname = $gmb_row['bname'];
    echo '<input name="bid" type="radio" id="bid" value="'.$bid.'">'.$bname.'<br>';
  }
  echo '<strong>Input current pictures description</strong><br>';
  echo '<input name="description" type="text" id="description"><br>';
  echo '<input name="submit" type="Submit" value="Okay"></form></td></tr></table>';	
}
?>
</body>
</html>