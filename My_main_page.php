<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>My_Main_Page</title>
<h3>My Main Page</h3>
<p><a href="self_manager.php"><strong><?php echo $_SESSION['sess_username']?></strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="user_profile.php?"><strong>Profile</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="view_my_board.php"><strong>Board</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="friend_list.php"><strong>My Friends</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
<a href="My_main_page.php"><strong>Return</strong></a>
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
<form name="search" method="get" action="My_main_page.php" id="search">
<input name="serach_input" type="text" id="search_input">
<input name="submit" type="Submit" value="Search"></form>
</p>
</head>

<body>
<hr />
<?php
$edit_profile = $_GET['edit_profile'];
if ($edit_profile) {
  echo '<p><strong>Profile edit successfully!</strong></p>';	
}
if ($edit_password) {
  echo '<p><strong>Password edit successfully!</strong></p>';	
}
function draw_picture($pid, $bid, $src, $dst, $current_uid, $current_username, $like_num, $description, $date) {
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="225" height="175" border="1" /></a><br>';
  echo '<a href="user_profile.php?uid='.$current_uid.'"><strong>'.$current_username.'</strong></a>';
  if (strcmp($current_username, $_SESSION['sess_username']) == 0) {
    echo '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Like:'.$like_num.'</strong><br>';
  } else {
	$myusername = $_SESSION['sess_username'];
	$is_liked = "SELECT * FROM Like_Picture L, Account A WHERE L.pid = '$pid' AND L.uid = A.uid AND A.username = '$myusername'";
	$il_result = mysql_query($is_liked) or die("ERROR".mysql_error());
	$il_row = mysql_fetch_array($il_result);
	if ($il_row) {
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Liked:'.$like_num.'</strong><br>';
	} else {
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="like_pic_process.php?pid='.$pid.'"><strong>Like:'.$like_num.'</strong></a><br>';	
	}
  }
  echo $description.'<br>';
  echo $date.'</td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function read_rank_picture() {
  $rank_pid = "SELECT pid, count(distinct uid) as pid_num FROM Like_Picture GROUP BY pid ORDER BY pid_num DESC";
  $rp_result = mysql_query($rank_pid) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');
  $get_current_picture = "SELECT * FROM Pin_Picture";
  $gcp_result = mysql_query($get_current_picture);
  $count = 0;
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  #echo '<th colspan="6" align=left><strong>My Pictures</strong></th>';
  while (($rp_row = mysql_fetch_array($rp_result)) && ($count < 20)) {
	$pid = $rp_row['pid'];
	$like_num = $rp_row['pid_num'];
	$get_current_picture = "SELECT * FROM Pin_Picture WHERE pid = '$pid'";
	$gcp_result = mysql_query($get_current_picture);
	$gcp_row = mysql_fetch_array($gcp_result);
	$src = $gcp_row['pdata'];
	$src = 'data:image/jpeg;base64,'. base64_encode($src);
	$dst = 'general_board_pictures.php';
	$description = $gcp_row['pdescription'];
	$update_date = $gcp_row['pdate'];
	$bid = $gcp_row['bid'];
	$get_current_username = "SELECT * FROM Board B, Account A WHERE B.uid = A.uid AND B.bid = '$bid'";
	$gcu_result = mysql_query($get_current_username);
	$gcu_row = mysql_fetch_array($gcu_result);
	$current_username = $gcu_row['username'];
	$current_uid = $gcu_row['uid'];
	if ($count%5 == 0) {
	  echo '<tr>';
	}
	draw_picture($pid, $bid, $src, $dst, $current_uid, $current_username, $like_num, $description, $update_date);
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
function draw_0_picture($pid, $bid, $src, $dst, $current_uid, $current_username, $like_num, $description, $date) {
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="225" height="175" border="1" /></a><br>';
  if (strcmp($current_username, $_SESSION['sess_username']) == 0) {
    echo '<strong>'.$current_username.'</strong>'; 
  } else {
	echo '<a href="user_profile.php?uid='.$current_uid.'"><strong>'.$current_username.'</strong></a>';  
  }
  if (strcmp($current_username, $_SESSION['sess_username']) != 0) {
	$myusername = $_SESSION['sess_username'];
	$is_liked = "SELECT * FROM Like_Picture L, Account A WHERE L.pid = '$pid' AND L.uid = A.uid AND A.username = '$myusername'";
	$il_result = mysql_query($is_liked) or die("ERROR".mysql_error());
	$il_row = mysql_fetch_array($il_result);
	if ($il_row) {
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Liked</strong><br>';
	} else {
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="like_pic_process.php?pid='.$pid.'"><strong>Like</strong></a>';	
	}
  }
  echo "<br>".$description.'<br>';
  echo $date.'</td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function read_0_rank_picture() {
  $get_current_picture = "SELECT * FROM Pin_Picture";
  $gcp_result = mysql_query($get_current_picture) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');
  $count = 0;
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  #echo '<th colspan="6" align=left><strong>My Pictures</strong></th>';
  while (($gcp_row = mysql_fetch_array($gcp_result)) && ($count < 20)) {
	$pid = $gcp_row['pid'];
	$like_num = 0;
	$src = $gcp_row['pdata'];
	$src = 'data:image/jpeg;base64,'. base64_encode($src);
	$dst = 'general_board_pictures.php';
	$description = $gcp_row['pdescription'];
	$update_date = $gcp_row['pdate'];
	$bid = $gcp_row['bid'];
	$get_current_username = "SELECT * FROM Board B, Account A WHERE B.uid = A.uid AND B.bid = '$bid'";
	$gcu_result = mysql_query($get_current_username);
	$gcu_row = mysql_fetch_array($gcu_result);
	$current_username = $gcu_row['username'];
	$current_uid = $gcu_row['uid'];
	if ($count%5 == 0) {
	  echo '<tr>';
	}
	draw_0_picture($pid, $bid, $src, $dst, $current_uid, $current_username, $like_num, $description, $update_date);
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
function draw_search_picture($pid, $bid, $src, $dst, $current_uid, $current_username, $like_num, $description, $date) {
  #echo '<td><a href="'.$dst.'"><img src="'.$src.'" width='.$WIDTH.' height='.$HEIGHT.' longdesc="'.$desc.'" border="5" bordercolor="#000000"></a></td>';
  echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="225" height="175" border="1" /></a><br>';
  if (strcmp($current_username, $_SESSION['sess_username']) == 0) {
    echo '<strong>'.$current_username.'</strong>'; 
  } else {
	echo '<a href="user_profile.php?uid='.$current_uid.'"><strong>'.$current_username.'</strong></a>';  
  }
  if (strcmp($current_username, $_SESSION['sess_username']) != 0) {
	$myusername = $_SESSION['sess_username'];
	$is_liked = "SELECT * FROM Like_Picture L, Account A WHERE L.pid = '$pid' AND L.uid = A.uid AND A.username = '$myusername'";
	$il_result = mysql_query($is_liked) or die("ERROR".mysql_error());
	$il_row = mysql_fetch_array($il_result);
	if ($il_row) {
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<strong>Liked</strong><br>';
	} else {
	  echo '&nbsp;&nbsp;&nbsp;&nbsp;<a href="like_pic_process.php?pid='.$pid.'"><strong>Like</strong></a>';	
	}
  }
  echo "<br>".$description.'<br>';
  echo $date.'</td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function read_search_picture($search_condition) {
  $get_current_picture = "SELECT * FROM Pin_Picture P, Board B WHERE P.bid = B.bid AND B.bname like '%".$search_condition."%'";
  $gcp_result = mysql_query($get_current_picture) or die('<th colspan="6" align=left><strong>'.mysql_error().'</strong>');
  $count = 0;
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left>';
  #echo '<th colspan="6" align=left><strong>My Pictures</strong></th>';
  while (($gcp_row = mysql_fetch_array($gcp_result)) && ($count < 20)) {
	$pid = $gcp_row['pid'];
	$like_num = 0;
	$src = $gcp_row['pdata'];
	$src = 'data:image/jpeg;base64,'. base64_encode($src);
	$dst = 'general_board_pictures.php';
	$description = $gcp_row['pdescription'];
	$update_date = $gcp_row['pdate'];
	$bid = $gcp_row['bid'];
	$get_current_username = "SELECT * FROM Board B, Account A WHERE B.uid = A.uid AND B.bid = '$bid'";
	$gcu_result = mysql_query($get_current_username);
	$gcu_row = mysql_fetch_array($gcu_result);
	$current_username = $gcu_row['username'];
	$current_uid = $gcu_row['uid'];
	if ($count%5 == 0) {
	  echo '<tr>';
	}
	draw_0_picture($pid, $bid, $src, $dst, $current_uid, $current_username, $like_num, $description, $update_date);
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
if (isset($_GET['serach_input'])) {
  echo "search";
  read_search_picture($_GET['serach_input']);	
}
read_rank_picture();
read_0_rank_picture();
?>
</body>
</html>