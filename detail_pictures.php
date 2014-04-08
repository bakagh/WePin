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
<title>detail_pictures</title>
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
$is_repin = false;
$pid = $_GET['pid'];
if (isset($_GET['rpid'])) {
  $is_repin = true;
}
$rpid = $_GET['rpid'];
function get_like_num($pid) {
  $like_pid = "SELECT pid, count(distinct uid) as pid_num FROM Like_Picture GROUP BY pid HAVING pid = '$pid'";
  $lp_result = mysql_query($like_pid);
  $lp_row = mysql_fetch_array($lp_result);
  if ($lp_row) {
    return $lp_row['pid_num'];
  } else {
	return 0;  
  }
}
if (!$is_repin) {
  $get_image = "SELECT * FROM Pin_Picture WHERE pid = '$pid'";
  $gi_result = mysql_query($get_image) or die("ERROR".mysql_error());
  $gi_row = mysql_fetch_array($gi_result);
  $bid = $gi_row['bid'];
  $date = $gi_row['pdate'];
  $data = $gi_row['pdata'];
  $get_pic_uid = "SELECT * FROM Board WHERE bid = '$bid'";
  $gpu_result = mysql_query($get_pic_uid);
  $gpu_row = mysql_fetch_array($gpu_result);
  $pic_uid = $gpu_row['uid'];
  $image_src = 'data:image/jpeg;base64,'. base64_encode($data);
  list($image_width, $image_height) = getimagesize($image_src);
  if (($image_width > 1000)||($image_height > 1000)) {
    $image_width = $image_width/2;
    $image_height = $image_height/2;	
  }
  $description = $gi_row['pdescription'];
  $get_source_board_name = "SELECT bname FROM Board WHERE bid = '$bid'";
  $gsbn_result = mysql_query($get_source_board_name);
  $gsbn_row = mysql_fetch_array($gsbn_result);
  $bname = $gsbn_row['bname'];
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  echo '<th><a href="detail_boards.php?bid='.$bid.'"><font color="blue" size="5"><strong>'.$bname.'</strong></font></a></th>';
  echo '<tr><td><img src="'.$image_src. '"width="'.$image_width.'" height="'.$image_height.'" border="1" /><br>';
  echo '<font size="3"><strong>'.$description.'</strong></font><br>';
  echo '<strong>Like:'.get_like_num($pid).'</strong><br>';
  echo '<font size="3"><strong>'.$date.'</strong></font></td>';
  $get_current_pic_comment = "SELECT * FROM Comment_Picture WHERE pid = '$pid'";
  $gcc_result = mysql_query($get_current_pic_comment);
  echo '<td>';
  if (strcmp($pic_uid, $my_uid) != 0) {
    echo '<a href="repin_picture.php?pid='.$pid.'"><font color="blue" size="4"><strong>Repin to my board</strong></font></a><br>';
  }
  while ($gcc_row = mysql_fetch_array($gcc_result)) {
	$comment_uid = $gcc_row['uid'];
	$get_comment_username = "SELECT * FROM Account WHERE uid = '$comment_uid'";
	$gcu_result = mysql_query($get_comment_username);
	$gcu_row = mysql_fetch_array($gcu_result);
	$comment_username = $gcu_row['username'];
	$comment = $gcc_row['comment'];
	$comment_date = $gcc_row['cdate'];
	if (strcmp($comment_username, $_SESSION['sess_username']) == 0) {
	  echo '<strong>'.$comment_username.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$comment_date.'<br>';	
	} else {
	  echo '<a href="user_profile.php?uid='.$comment_uid.'"><strong>'.$comment_username.'</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;'.$comment_date.'<br>';
	}
	echo '<strong>[</strong>'.$comment.'<strong>]</strong><br>';
  }
  echo '<form name="form1" action="comment_process.php" method="post" id="form1">';
  echo '<input name="uid" type="hidden" id="uid" value="'.$my_uid.'">';
  echo '<input name="pid" type="hidden" id="pid" value="'.$pid.'">';
  echo '<strong>Comment:</strong><br>';
  echo '<input name="comment" type="text" id="comment"><br>';
  echo '<input name="submit" type="Submit" value="Send"></tr></table></p>';
} else {
  $get_repin_picture = "SELECT * FROM Repin_Picture WHERE rpid = '$rpid'";
  $grp_result = mysql_query($get_repin_picture) or die("ERROR1".mysql_error());
  $grp_row = mysql_fetch_array($grp_result);
  $from_pid = $grp_row['from_pid'];
  $repin_bid = $grp_row['bid'];
  $rpdescription = $grp_row['rpdescription'];
  $rpdate = $grp_row['rpdate'];
  $source_picture = "SELECT * FROM Pin_Picture WHERE pid = '$from_pid'";
  $sp_result = mysql_query($source_picture) or die("ERROR2".mysql_error());
  $sp_row = mysql_fetch_array($sp_result);
  $sp_image_src = $sp_row['pdata'];
  $sp_image_src = 'data:image/jpeg;base64,'. base64_encode($sp_image_src);
  $get_pic_uid = "SELECT * FROM Board WHERE bid = '$repin_bid'";
  $gpu_result = mysql_query($get_pic_uid) or die("ERROR3".mysql_error());
  $gpu_row = mysql_fetch_array($gpu_result);
  $pic_uid = $gpu_row['uid'];
  list($image_width, $image_height) = getimagesize($sp_image_src);
  if (($image_width > 1000)||($image_height > 1000)) {
    $image_width = $image_width/2;
    $image_height = $image_height/2;	
  }
  $sp_image_bid = $sp_row['bid'];
  $repin_get_bname = "SELECT bname FROM Board WHERE bid = '$repin_bid'";
  $rgb_result = mysql_query($repin_get_bname) or die("ERROR4".mysql_error());
  $rgb_row = mysql_fetch_array($rgb_result);
  $repin_bname = $rgb_row['bname'];
  $source_get_bname = "SELECT bname FROM Board WHERE bid = '$sp_image_bid'";
  $sgb_result = mysql_query($source_get_bname) or die("ERROR5".mysql_error());
  $sgb_row = mysql_fetch_array($sgb_result);
  $source_bname = $sgb_row['bname'];
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  echo '<th><font color="blue" size="5"><strong><a href="detail_boards.php?bid='.$repin_bid.'">'.$repin_bname.'</a> repined from <a href="detail_boards.php?bid='.$sp_image_bid.'">'.$source_bname.'</a></strong></font></th>';
  echo '<tr><td><img src="'.$sp_image_src. '"width="'.$image_width.'" height="'.$image_height.'" border="1" /><br>';
  echo '<font size="3"><strong>'.$rpdescription.'</strong></font><br>';
  echo '<strong>Like:'.get_like_num($from_pid).'</strong><br>';
  echo '<font size="3"><strong>'.$rpdate.'</strong></font></td></tr></table></p>';
  $get_current_pic_comment = "SELECT * FROM Comment_Repin WHERE rpid = '$rpid'";
  $gcc_result = mysql_query($get_current_pic_comment);
  echo '<td>';
  if (strcmp($pic_uid, $my_uid) != 0) {
    echo '<a href="repin_picture.php?rpid='.$rpid.'"><font color="blue" size="4"><strong>Repin to my board</strong></font></a><br>';
  }
  while ($gcc_row = mysql_fetch_array($gcc_result)) {
	$comment_uid = $gcc_row['uid'];
	$get_comment_username = "SELECT * FROM Account WHERE uid = '$comment_uid'";
	$gcu_result = mysql_query($get_comment_username);
	$gcu_row = mysql_fetch_array($gcu_result);
	$comment_username = $gcu_row['username'];
	$comment = $gcc_row['rcomment'];
	$comment_date = $gcc_row['rcdate'];
	if (strcmp($comment_username, $_SESSION['sess_username']) == 0) {
	  echo '<strong>'.$comment_username.'</strong>&nbsp;&nbsp;&nbsp;&nbsp;'.$comment_date.'<br>';	
	} else {
	  echo '<a href="user_profile.php?'.$comment_uid.'"><strong>'.$comment_username.'</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;'.$comment_date.'<br>';
	}
	echo '<strong>[</strong>'.$comment.'<strong>]</strong><br>';
  }
  echo '<form name="form1" action="comment_process.php" method="post" id="form1">';
  echo '<input name="uid" type="hidden" id="uid" value="'.$my_uid.'">';
  echo '<input name="rpid" type="hidden" id="rpid" value="'.$rpid.'">';
  echo '<strong>Comment:</strong><br>';
  echo '<input name="comment" type="text" id="comment"><br>';
  echo '<input name="submit" type="Submit" value="Send"></tr></table></p>';
}
?>
</body>
</html>