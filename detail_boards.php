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
<title>detail_boards</title>
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
function draw_container($bid, $src, $dst, $board_name, $description, $update_date) {
  $get_board_owner = "SELECT * FROM Board B, Account A WHERE B.uid = A.uid AND B.bid = '$bid'";
  $gbo_result = mysql_query($get_board_owner) or die("ERROR".mysql_error());
  $gbo_row = mysql_fetch_array($gbo_result);
  $board_username = $gbo_row['username'];
  $board_uid = $gbo_row['uid'];
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="450" height="345" border="5" /></a><br>';
  echo $board_name.'<br>';
  echo $description.'<br>';
  echo $update_date.'<br>';
  if (strcmp($board_username, $_SESSION['sess_username']) != 0) {
    echo '<a href="user_profile.php?uid='.$board_uid.'"></a>';
	echo '&nbsp;&nbsp;';
	echo '<a href="follow_board_process.php?bid='.$bid.'"><br></td>';
  }
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function read_board($bid) {
  $get_board = "SELECT * FROM Board WHERE bid = '$bid'";
  $gb_result = mysql_query($get_board) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');
  $row = mysql_fetch_array($gb_result);
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  $current_uid = $row['uid'];
  $board_name = $row['bname'];
  $description = $row['description'];
  $update_date = $row['bDate'];
  $find_pic = "select * from Pin_Picture where bid = '$bid'";
  $fp_result = mysql_query($find_pic);
  if (mysql_num_rows($fp_result) == 0) {
    $src = "images/LovePic.jpg";	
  } else {
  $find_latest_pic = 'select * from Pin_Picture as P1 where bid = "'.$bid.'" and P1.pdate = ( select MAX(P2.pdate) from Pin_Picture as P2 where P1.bid = P2.bid)';
  $flp_result = mysql_query($find_latest_pic);
  $flp_row = mysql_fetch_array($flp_result);
  $src = $flp_row['pdata'];
  $src = 'data:image/jpeg;base64,'. base64_encode($src);
  #echo '<img src="data:image/jpeg;base64,'. base64_encode($src_parse). '"width="150" height="115" border="5" />';
  $get_current_username = "SELECT * FROM Account WHERE uid = '$current_uid'";
  $gcu_result = mysql_query($get_current_username);
  $gcu_row = mysql_fetch_array($gcu_result);
  $current_username = $gcu_row['username'];
  if (strcmp($current_username, $_SESSION['sess_username']) == 0) {
    $dst = 'board_pictures.php';
  } else {
	$dst = 'general_board_pictures.php';  
  }
  echo '<tr>';
  draw_container($bid, $src, $dst, $board_name, $description, $update_date);
  echo '</tr></table></p>';
  }
}
read_board($_GET['bid']);
?>
</body>
</html>