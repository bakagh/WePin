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
$pid = $_GET['pid'];
$bid = $_GET['bid'];
echo '<p><table color="#FFFFFF" border="1">';
$get_info = "SELECT * FROM Pin_Picture WHERE pid = '$pid'";
$gi_result = mysql_query($get_info);
$gi_row = mysql_fetch_array($gi_result);
$pdescription = $gi_row['pdescription'];
$pdata = $gi_row['pdata'];
$pdata = 'data:image/jpeg;base64,'. base64_encode($pdata);
$dst = 'detail_boards.php';
echo '<tr><td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$pdata. '"width="225" height="175" border="1" /></a></td>';
echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
echo '<td><form name="form1" action="upload_image_edit_process.php" method="post" id="form1">';
echo '<input name="pid" type="hidden" id="pid" value="'.$pid.'">';
echo '<input name="bid" type="hidden" id="bid" value="'.$bid.'">';
echo '<strong>Input current pictures description</strong><br>';
echo '<input name="description" type="text" id="description"><br>';
echo '<input name="submit" type="Submit" value="Okay"></form></td></tr></table>';
?>
</body>
</html>