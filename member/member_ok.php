<?php
	include "db/db.php";
	include "../password.php";

	$userid = $_POST['userid'];
	$userpw = password_hash($_POST['userpw'], PASSWORD_DEFAULT);
	$username = $_POST['name'];
	$adress = $_POST['adress'];
	$sex = $_POST['sex'];
	$email = $_POST['email'].'@'.$_POST['emadress'];
	echo $userid;
	echo $userpw;
	echo $username;
	echo $adress;
	echo $sex;
	echo $email;
$sql = "insert into member (idx,id,pw,name,adress,sex,email) values('1','kimhj92','1234','효진','경기도','남',''emaildd')";
mq($sql);
echo $sql;
//$sql = mq("insert into member (id,pw,name,adress,sex,email) values('".$userid."','".$userpw."','".$username."','".$adress."','".$sex."','".$email."')");

//echo '.$userid.','".$userpw."','".$username."','".$adress."','".$sex."','".$email."';
?>
<meta charset="utf-8" />
<script type="text/javascript">alert('회원가입이 완료되었습니다.');</script>
<!--<meta http-equiv="refresh" content="0 url=/">-->