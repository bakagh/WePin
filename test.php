<?php
#mysql_connect('127.0.0.1','lw1378','');
#mysql_select_db('test');
#$query = 'select * from Img_test where iid = 1';
#$result = mysql_query($query);
#$row = mysql_fetch_array($result);
#$data = $row['image'];
#$data = 'data:image/jpeg;base64,'. base64_encode($image);
?>
<html>
<head>
<h3><font size="3" color="blue"><strong>SB</strong><font></3>
</head>
<body>
<form name="form1" action="test.php" method="post" id="form1">
<input name="file" type="file" id="file">
<input name="submit" type="Submit" value="OK"></form>
<?php
include 'Random_String_generator.php';
include 'blobdemo.php';
if (isset($_POST['file'])) {
  $file = $_POST['file'];
  $blobObj = new BobDemo();
  $blobObj->insertBlob($file, "image/jpeg");
  header("location: test.php");
}
mysql_connect('127.0.0.1','lw1378','');
mysql_select_db('test');
$get_pic = "SELECT * FROM file";
$gp_result = mysql_result($get_pic);
while ($gp_row = mysql_fetch_array($gp_result)) {
  $data = $gp_row['image'];
  echo '<img src="'.$data.'" width="150" height="120" border="2" />';
}
?>
</body>
