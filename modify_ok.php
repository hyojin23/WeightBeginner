<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$bno = $_POST['idx']; // modify.php에서 hidden으로 넘긴 인덱스 번호
$userpw = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
$sql = mysql_q("update board set name='".$_POST['name']."',write_password='".$userpw."',title='".$_POST['title']."',content='".$_POST['content']."' where idx='".$bno."'"); ?>

<!--DB에 수정된 내용을 반영-->
<script type="text/javascript">alert("수정되었습니다.");</script>
<meta http-equiv="refresh" content="0; url=board.php" />

