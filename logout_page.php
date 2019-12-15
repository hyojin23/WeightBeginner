<?php
include "db/db.php";
session_destroy();
?>
<meta charset="utf-8">
<!--로그아웃되었다는 창 출력하고 이전 페이지로 돌아감-->
<!--<script>alert("로그아웃 되었습니다."); history.go(-1); </script>-->
<script>alert("로그아웃 되었습니다."); location.href="main_page.html"; </script>