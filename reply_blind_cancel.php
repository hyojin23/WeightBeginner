
<script>console.log('reply_blind.php 파일 실행')</script>
<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; // DB에 연결
$reply_number = $_POST['reply_number']; // read.php 댓글 수정폼에서 POST로 보낸 댓글의 인덱스 번호
$sql = mysql_q("select * from reply where idx='".$reply_number."'"); // 댓글 인덱스 번호를 조건으로 DB에서 데이터 불러옴

$reply = $sql->fetch_array(); // 불러온 데이터를 $reply 변수에 배열로 저장

$index = $_POST['index']; // read.php 에서 POST로 보낸 게시글의 인덱스 번호
$data = mysql_q("select * from board where idx='".$index."'"); // 게시글 인덱스 번호를 조건으로 DB에서 데이터 불러옴
$board = $data->fetch_array(); // 불러온 데이터를 $board 변수에 배열로 저장

mysql_q("update reply set is_blind='0' where idx = '".$reply_number."'"); ?><!-- 해당 댓글의 내용을 DB에서 수정하게 함-->



<?php
include $_SERVER['DOCUMENT_ROOT']."/reply_load.php"; // 댓글 목록을 불러옴
?>
<script type="text/javascript" src="/js/common.js?ver=14"></script>
