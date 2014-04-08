<?php
session_start();
if(!isset($_SESSION['sess_user_id']) || (trim($_SESSION['sess_user_id']) == '')) {
  header("location: User_Login.php");
  exit();
}
$conn = mysql_connect('127.0.0.1', 'lw1378', '');
mysql_select_db('test', $conn) or die(mysql_error());
$password = $_POST['password'];
$username = $_SESSION['sess_username'];
$get_psd = "SELECT password FROM Account WHERE username = '$username'";
$gp_result = mysql_query($get_psd);
$gp_row = mysql_fetch_array($gp_result);
if (!isset($password)) {
  header("location: delete_current_board.php?error=psd_error");
}
if (strcmp($password, $gp_row['password']) != 0) {
  header("location: delete_current_board.php?error=psd_error");	
} else {
  $bid = $_POST['bid'];
  # To delete the board, need some extra steps.

  # First delete all repin pictures that related to current board.
  $delete_repin_pic = "DELETE FROM Repin_Picture WHERE from_pid in (SELECT pid FROM Pin_Picture WHERE bid = '$bid')";
  mysql_query($delete_repin_pic) or die("ERROR1".mysql_error());
  # Second delete all follow streams that related to current board.
  $get_fsid = "SELECT fsid FROM FS_Board WHERE bid = '$bid'";
  $gf_result = mysql_query($get_fsid) or die("ERROR2".mysql_error());
  while ($gf_row = mysql_fetch_array($gf_result)) {
    $fsid = $gf_row['fsid'];
    $delete_fs_board = "DELETE FROM FS_Board WHERE fsid = '$fsid'";
    mysql_query($delete_fs_board) or die("ERROR3".mysql_error());
    $delete_follow_stream = "DELETE FROM Follow_Stream WHERE fsid = '$fsid'";
    mysql_query($delete_follow_stream) or die("ERROR4".mysql_error());
  }
  # Third delete all pictures in current board.
  $delete_pictures = "DELETE FROM Pin_Picture WHERE bid = '$bid'";
  mysql_query($delete_pictures) or die("ERROR5".mysql_error());
  # Finally we delete current board.
  $delete_current_board = "DELETE FROM Board WHERE bid = '$bid'";
  mysql_query($delete_current_board) or die("ERROR6".mysql_error());
  header("location: Edit_my_board.php?operation=delete_current_board_success");
}
?>