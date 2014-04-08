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
<title>Edit_my_board</title>
<h3><strong>Edit My Board</strong></h3>
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
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  #echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo '<td><a href="board_pictures.php?bid='.$bid.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo $board_name.'<br>';
  echo $description.'<br>';
  echo $update_date.'<br>';
  echo '<a href="edit_current_board.php?bid='.$bid.'"><strong>Edit</strong></a>&nbsp;&nbsp;';
  echo '<a href="delete_current_board.php?bid='.$bid.'"><strong>Delete</strong></a></td>';
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
  echo '<th colspan="6" align=left><strong>My Board</strong></th>';
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
	  $dst = 'board_pictures.php';
	}	
	if ($count%6 == 0) {
      #echo '<font color="red">Hi</font>';
	  echo '<tr>';
	}
	draw_container($bid, $src, $dst, $board_name, $description, $update_date);
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

function draw_follow_container($bid, $fsid, $src, $dst, $board_name, $description, $update_date) {
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  #echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo '<td><a href="board_pictures.php?bid='.$bid.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo $board_name.'<br>';
  echo $description.'<br>';
  echo $update_date.'<br>';
  echo '<a href="edit_current_follow_stream.php?fsid='.$fsid.'"><strong>Edit</strong></a>&nbsp;&nbsp;';
  echo '<a href="delete_current_follow_stream.php?fsid='.$fsid.'"><strong>Delete</strong></a></td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}

function read_follow_stream($username) {
  $find_board = 'select F.fsid, F.fsname as fsname, F.fsdescription as fsdescription, F.fsDate as fsDate, B.bid as bid from Account as A, User as U, Follow_Stream as F, FS_Board as FS, Board as B where A.uid = U.uid and U.uid = FS.uid and FS.bid = B.bid and FS.fsid = F.fsid and A.username = "'.$username.'"';
  #$find_board = mysql_escape_string($find_board);
  $fb_result = mysql_query($find_board) or die('<th colspan="6" align=left><font color="blue" size="6"><strong>'.mysql_error().'</strong></font>');
  #if ($fb_result) {
    #echo '<th colspan="6" align=left><font color="blue" size="6"><strong>Hello</strong></font>';
  #}
  $count = 0;
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  echo '<th colspan="6" align=left><strong>My Follow Stream</strong></th>';
  #echo '&nbsp;&nbsp;&nbsp;&nbsp;><font color="#FF55FF" size="3"><strong><a href="Board_myboard_editor.php">Edit</a></strong></font></th>';
  while ($row = mysql_fetch_array($fb_result)) {
    $bid = $row['bid'];
	$fsid = $row['fsid'];
	$follow_stream_name = $row['fsname'];
	$follow_stream_description = $row['fsdescription'];
	$follow_stream_date = $row['fsDate'];
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
	  #echo '<img src="data:image/jpeg;base64,'. base64_encode($src). '"width="150" height="115" border="5" />';
	  #echo '<th colspan="6" align=left><font color="blue" size="6"><strong>'.$bid.'</strong></font>';
	  $dst = 'board_pictures.php';
	}	
	if ($count%6 == 0) {
      #echo '<font color="red">Hi</font>';
	  echo '<tr>';
	}
	draw_follow_container($bid, $fsid, $src, $dst, $follow_stream_name, $follow_stream_description, $follow_stream_date);
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

read_board($_SESSION['sess_username']);
read_follow_stream($_SESSION['sess_username']);
if (isset($_GET['operation'])) {
  if (strcmp($_GET['operation'], "edit_current_board_success") == 0) {
	echo '<p><strong>Board edit successfully!</strong></p>';  
  }
  if (strcmp($_GET['operation'], "delete_current_board_success") == 0) {
	echo '<p><strong>Board delete successfully!</strong></p>';
  }
  if (strcmp($_GET['operation'], "create_current_board_success") == 0) {
	echo  '<p><strong>Board creation successfully!</strong></p>'; 
  }
}
?>
</body>
</html>