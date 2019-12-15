<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; // db 연결

// 인덱스 번호
$index = $_GET['idx'];
$sql = mysql_q("delete from gallery_board where idx='$index';");
?>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=used_item_board.php" />