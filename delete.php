<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$bno = $_GET['idx'];
$sql = mysql_q("delete from board where idx='$bno';");
?>
<script type="text/javascript">alert("삭제되었습니다.");</script>
<meta http-equiv="refresh" content="0 url=board.php" />
