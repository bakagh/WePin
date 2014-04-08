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
<title>delete_current_board</title>
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
  echo '<td><a href="'.$dst.'?bid='.$bid.'"><img src="'.$src. '"width="150" height="115" border="5" /></a><br>';
  echo $board_name.'<br>';
  echo $description.'<br>';
  echo $update_date.'<br></td>';
  echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
}
function show_board($bid) {
  $find_pic = "select * from Pin_Picture where bid = '$bid'";
  $fp_result = mysql_query($find_pic);
  $fp_row = mysql_fetch_array($fp_result);
  $board_name = $fp_row['bname'];
  $description = $fp_row['description'];
  $update_date = $fp_row['bDate'];
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
  echo '<p><table border=1 bordercolor="#FFFFFF" align=left><tr>';
  draw_container($bid, $src, $dst, $board_name, $description, $update_date);
  echo '<td><strong>Are you sure you want to delete current board including all pictures?</strong><br>';
  echo '<strong>Input password to process.</strong><br>';
  echo '<form name="form1" method="post" action="delete_current_board_process.php" id="form1">';
  echo '<input name="bid" type="hidden" id="bid" value="'.$bid.'">';
  echo '<input name="password" type="password" id="password">';
  echo '<input name="submit" type="Submit" value="Okay"></td></p>';
}
$bid = $_GET['bid'];
show_board($bid);
if (isset($_GET['error'])&&(strcmp($_GET['error'], "psd_error") == 0)) {
  echo '<p><font color="red"><strong>Password incorrect!</strong></font></p>';	
}
?>
</body>
</html>