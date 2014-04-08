<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Main_Register_Page</title>
</head>

<body>
<table width="300" border="0" align="left" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
<tr>
<form name="form2" method="post" action="checkregister.php">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
<tr>
<td colspan="3"><strong>Member Register </strong></td>
</tr>
<tr>
<td width="78">Username</td>
<td width="6">:</td>
<td width="294"><input name="username" type="text" id="username"></td>
</tr>
<tr>
<td>First Name</td>
<td>:</td>
<td><input name="first_name" type="text" id="first_name"></td>
</tr>
<tr>
<td>Last Name</td>
<td>:</td>
<td><input name="last_name" type="text" id="last_name"></td>
</tr>
<tr>
<td>Email</td>
<td>:</td>
<td><input name="user_email" type="email" id="user_email"></td>
</tr>
<tr>
<td>Gender</td>
<td>:</td>
<td><input name="gender" type="radio" id="gender" value="Male">Male<br>
<input name="gender" type="radio" id="gender" value="Female">Female</td>
</tr>
<tr>
<td>Country</td>
<td>:</td>
<td><input name="country" type="text" id="country"></td>
</tr>
<tr>
<td>Password</td>
<td>:</td>
<td><input name="password" type="password" id="password"></td>
</tr>
<tr>
<td>Confirm</td>
<td>:</td>
<td><input name="re_password" type="password" id="re_password"></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="Submit" value="Register"></td>
</tr>
<tr>
<td colspan="3">
<?php
$registerFailed = $_GET['registerFailed'];
$reason = $_GET['reason'];
if ($registerFailed) {
  if ($reason == "short_password") {
    echo '<font color="red">Password length must be larger than 4!</font>';
  }
  if ($reason == "re_password") {
    echo '<font color="red">re-type password is different!</font>';
  }
  if ($reason == "user_exist") {
    echo '<font color="red">Username exists!</font>';
  }
}
?>
</td>
</tr>
</table>
</td>
</form>
</tr>
</table>

</body>
</html>