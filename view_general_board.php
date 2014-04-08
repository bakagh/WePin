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
function draw_container($username, $bid, $src, $dst, $board_name, $description, $update_date) {
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  #echo '<td><a href="'.$dst.'?bid='.$bid.'&username='.$username.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo '<td><a href="general_board_pictures.php?bid='.$bid.'&username='.$username.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo $board_name.'<br>';
  echo $description.'<br>';
  echo $update_date.'<br>';
  if (strcmp($username, $_SESSION['sess_username']) == 0) {
    echo '</td>';
  } else {
    echo '<a href="follow_board.php?bid='.$bid.'"><font color="blue">Follow Board</font></a></td>';
  }
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function read_board($username) {
  $find_board = 'select * from Account as A, User as U, Board as B where A.uid = U.uid and B.uid = U.uid and A.username = "'.$username.'"';
  #$find_board = mysql_escape_string($find_board);
  $fb_result = mysql_query($find_board) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');
  #if ($fb_result) {
    #echo '<th colspan="6" align=left><font color="blue" size="6"><strong>Hello</strong></font>';
  #}

  $count = 0;
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  echo '<th colspan="6" align=left><strong>'.$username.' Board</strong></th>';
  #echo '&nbsp;&nbsp;&nbsp;&nbsp;><strong><a href="Board_myboard_editor.php">delete</a></strong></font></th>';
  #echo '<th colspan="6" align=left><font color="blue" size="15"><strong>'.mysql_num_rows($fb_result).'</strong></font>';
  while ($row = mysql_fetch_array($fb_result)) {
    $bid = $row['bid'];
	$board_name = $row['bname'];
	$description = $row['description'];
	$update_date = $row['bDate'];
	$find_pic = "select * from Pin_Picture where bid = '$bid'";
	#$find_pic = mysql_escape_string($find_pic);
	$fp_result = mysql_query($find_pic);
	if (mysql_num_rows($fp_result) == 0) {
	  $src = "images/LovePic.jpg";	
	} else {
	  $find_latest_pic = 'select * from Pin_Picture as P1 where bid = "'.$bid.'" and P1.pdate = ( select MAX(P2.pdate) from Pin_Picture as P2 where P1.bid = P2.bid)';
	  #$find_latest_pic = mysql_escape_string($find_latest_pic);
	  $flp_result = mysql_query($find_latest_pic);
	  $flp_row = mysql_fetch_array($flp_result);
	  $src = $flp_row['pdata'];
	  $src = 'data:image/jpeg;base64,'. base64_encode($src);
	  #echo '<img src="data:image/jpeg;base64,'. base64_encode($src_parse). '"width="150" height="115" border="5" />';
	  $dst = 'general_board_pictures.php';
	}	
	if ($count%6 == 0) {
      #echo '<font color="red">Hi</font>';
	  echo '<tr>';
	}
	draw_container($username, $bid, $src, $dst, $board_name, $description, $update_date);
	if ($count%6 == 5) {
	  echo "</tr>";
	}
	$count ++;
  }
  if (($count-1)%6 != 5) {
    echo "</tr";
  }
  echo '</table></p>';
}
read_board($_GET['username']);
?>
</body>
</html>