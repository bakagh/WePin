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
<a href="My_main_page.php?"><strong>Return</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;</p>
</head>

<body>
<hr />
<?php
if (isset($_GET['pid'])) {
  function draw_picture($pid, $bid, $src, $dst) {
    #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
    echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="225" height="175" border="1" /></a></td>';
    echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
  }
  function read_board_picture($pid) {
    $find_board_picture = "SELECT * FROM Pin_Picture WHERE pid = '$pid'";
    $fbp_result = mysql_query($find_board_picture) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');

    echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
    echo '<th colspan="6" align=left><strong>Edit description</strong></th><tr>';
    $row = mysql_fetch_array($fbp_result);
	$bid = $row['bid'];
	$src = $row['pdata'];
    $src = 'data:image/jpeg;base64,'. base64_encode($src);
	$dst = 'detail_boards.php';
	$description = $row['pdescription'];
    draw_picture($pid, $bid, $src, $dst);
    echo '<form name="form1" method="post" action="edit_current_picture_process.php" id="form1">';
	echo '<input name="pid" type="hidden" id="pid" value="'.$pid.'">';
	echo '<input name="bid" type="hidden" id="bid" value="'.$bid.'">';
	echo '<strong>Input new description</strong><br>';
    echo '<td><input name="description" type="text" id="descripiton" value="'.$description.'"><br>';
    echo '<input name="submit" type="Submit" value="Okay"></td></tr>';
    echo '</table></p>';
  }
  read_board_picture($_GET['pid']);
}
if (isset($_GET['rpid'])) {
  function draw_repin_picture($rpid, $src, $dst) {
    #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
    echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="225" height="175" border="1" /></a></td>';
    echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
  }
  function read_repin_picture($rpid) {
    $find_repin_picture = "SELECT * FROM Repin_Picture WHERE rpid = '$rpid'";
    $frp_result = mysql_query($find_repin_picture) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');

    echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
    echo '<th colspan="6" align=left><strong>Edit description</strong></th><tr>';
    $bid = $row['bid'];
	$from_pid = $row['from_pid'];
	$get_data = "SELECT * FROM Pin_Picture WHERE pid = '$from_pid'";
	$gd_result = mysql_query($get_data) or die("ERROR".mysql_error());
	$gd_row = mysql_fetch_array($gd_result);
	$src = $gd_row['pdata'];
	$src = 'data:image/jpeg;base64,'. base64_encode($src);
	$dst = 'detail_boards.php';
	$description = $row['rpdescription'];
    draw_picture($rpid, $bid, $src, $dst);
    echo '<form name="form1" method="post" action="edit_current_picture_process.php" id="form1">';
	echo '<input name="rpid" type="hidden" id="rpid" value="'.$rpid.'">';
	echo '<input name="bid" type="hidden" id="bid" value="'.$bid.'">';
	echo '<strong>Input new description</strong><br>';
    echo '<td><input name="description" type="text" id="descripiton" value="'.$description.'"><br>';
    echo '<input name="submit" type="Submit" value="Okay"></td></tr>';
    echo '</table></p>';
  }
  read_repin_picture($_GET['repid']);
}
?>
</body>
</html>