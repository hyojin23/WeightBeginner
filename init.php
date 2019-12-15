<?php

$host = 'www.weightbeginner.ga';
$user_name = 'hyojin'; # MySQL 계정 아이디
$user_password = 'rlagywlsmyDB1030!'; # MySQL 계정 패스워드
$dbname = 'androidDB';  # DATABASE 이름

$con = mysqli_connect($host, $user_name, $user_password, $dbname);

if ($con) {
    echo "db 연결 성공!";
} else  {
    echo "db 연결 실패";
}

