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
<title>board_pictures</title>
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
$bid = $_GET['bid'];
$username = $_GET['username'];
function draw_picture($pid, $src, $dst) {
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  echo '<td><a href="'.$dst.'?pid='.$pid.'"><img src="'.$src. '"width="225" height="175" border="1" /></a></td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function read_board_picture($bid) {
  $find_board_picture = "SELECT * FROM Pin_Picture WHERE bid = '$bid'";
  $fbp_result = mysql_query($find_board_picture) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');

  $count = 0;
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  echo '<th colspan="6" align=left><strong>'.$username.' Pictures</strong></th>';
  while ($row = mysql_fetch_array($fbp_result)) {
    $pid = $row['pid'];
	$src = $row['pdata'];
	$src = 'data:image/jpeg;base64,'. base64_encode($src);
	$dst = 'detail_pictures.php';
	$description = $row['pdescription'];
	$update_date = $row['pdate'];
	
	if ($count%5 == 0) {
	  echo '<tr>';
	}
	draw_picture($pid, $src, $dst);
	if ($count%5 == 4) {
	  echo "</tr>";
	}
	$count ++;
  }
  if (($count-1)%5 != 4) {
    echo "</tr";
  }
  echo '</table></p>';
}

read_board_picture($bid);
?>
</body>
</html>