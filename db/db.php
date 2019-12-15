<script>console.log("db.php 실행")</script>
<?php
session_start(); // 세션 실행
header('Content-Type: text/html; charset=utf-8');
$db = new mysqli("localhost","root","rlagywlsmyDB1030!","myDB"); // DB 객체 생성 호스트, 아이디, 비밀번호, DB이름 입력
$db->set_charset("utf8");

function mysql_q($sql){ // DB 연결후 쿼리문을 날리는 함수
    global $db;
    return $db->query($sql);
}
if ($db->connect_error) { // 연결 실패시 에러메세지 출력
    die("Connection failed: " . $db->connect_error);
}
?>