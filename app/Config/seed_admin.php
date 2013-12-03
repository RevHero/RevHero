<?php
$conn = mysql_connect("localhost","root","");
mysql_select_db("revhero", $conn);

$admin_email = 'test@admin.com';
$admin_pass  = 'test123';

$selectData = mysql_query("select * from `users` where `admin`=1");
$num = mysql_num_rows($selectData);

if($num == 0)
{
	$insertDefaultAdmin = mysql_query("INSERT INTO `users` SET `email`='".$admin_email."', `encrypted_password`='".md5($admin_pass)."', `admin`=1");
}	

?>