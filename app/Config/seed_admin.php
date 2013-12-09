<?php
$admin_email = 'test@admin.com';
$admin_pass  = 'test123';
$host_name = "localhost";
$DB_user_name = "root";
$DB_user_password = "";
$db_name = "rev_final";

$conn = mysqli_connect($host_name, $DB_user_name, $DB_user_password, $db_name);

$selectData = mysqli_query($conn, "select * from `users` where `admin`=1");
$num = mysqli_num_rows($selectData);

if($num == 0)
{
	$insertDefaultAdmin = mysqli_query($conn, "INSERT INTO `users` SET `email`='".$admin_email."', `encrypted_password`='".md5($admin_pass)."', `admin`=1, `is_active`=1" );
}

if($insertDefaultAdmin && $insertDefaultAdmin != '')
{
	echo "Successfully added a Admin Record.";
}
else
{
	echo "Admin Record already exist!";
}
?>