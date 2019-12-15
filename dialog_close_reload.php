
<!--댓글 다이얼로그에서 x 버튼을 눌러 다이얼로그를 종료시켰을 경우 댓글 부분이 초기화 되도록 하기 위해 만든 파일.
댓글 부분이 초기화되지 않으면 처음 수정 버튼을 눌렀을 때는 다이얼로그가 뜨지만 두번째 수정 버튼을 눌렀을 때는 다이얼로그가 뜨지 않는 문제가 발생함.
 이를 해결하기 위해 이 파일을 ajax로 요청하여 댓글 부분만 초기화되게 함 -->



<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";
//$index = $_POST['index']; // 게시글의 번호를 POST로 받아 $index에 저장
$index = $_POST['index']; /* index변수에 게시글의 index값을 받아와 넣음*/
?>
<script>console.log("dialog_close_reload.php 파일이 실행되었습니다.")</script>
<?php
include $_SERVER['DOCUMENT_ROOT']."/reply_load.php"; // 댓글 목록을 불러옴
?>
<script type="text/javascript" src="/js/common.js?ver=6"></script>


