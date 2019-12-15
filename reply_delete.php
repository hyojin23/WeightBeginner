<script>console.log("reply_delete.php 파일 실행")</script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; // db에 연결
$reply_number = $_POST['reply_number']; // 댓글 인덱스 번호
$sql = mysql_q("select * from reply where idx='".$reply_number."'"); // 댓글 인덱스 번호를 조건으로 DB에 저장된 댓글 데이터를 불러옴
$reply = $sql->fetch_array(); // 불러온 데이터를 $reply에 배열로 저장

$index = $_POST['post_number']; // 게시글 인덱스 번호
$data = mysql_q("select * from board where idx='".$index."'"); // 게시글 인덱스 번호를 조건으로 DB에 저장된 게시글 데이터를 불러옴
$board = $data->fetch_array(); // 불러온 데이터를 $board에 배열로 저장

// 댓글 인덱스 번호로 댓글 찾아 삭제
$delete_sql = mysql_q("delete from reply where idx='".$reply_number."'"); ?>


<script>console.log("reply_delete.php 파일에서 댓글 목록 불러옴")</script>
<?php
//include $_SERVER['DOCUMENT_ROOT']."/reply_load.php"; // 댓글 목록을 불러옴
//?>
<script type="text/javascript" src="/js/common.js?ver=15"></script>









<?php
// 비밀번호 일치여부로 댓글 삭제하는 방법. 컨트롤+쉬프트+/ 로 주석해제
/*$delete_password = $_POST['delete_password']; // 댓글 삭제시 유저가 입력한 비밀번호
$reply_password = $reply['reply_password']; // 댓글 작성시 입력해 DB에 저장되어 있는 댓글 비밀번호

if(password_verify($delete_password, $reply_password)) // 유저가 입력한 비밀번호가 DB에 저장되어 있는 댓글 비밀번호와 같다면
	{
        // 댓글 인덱스 번호를 조건으로 댓글을 찾아 DB에서 댓글 삭제
		$sql = mysql_q("delete from reply where idx='".$reply_number."'"); */?><!--
	<script type="text/javascript">alert('댓글이 삭제되었습니다.'); location.replace("read.php?idx=<?php /*echo $board["idx"]; */?>");</script>
	<?php
/*	}else{ // 비밀번호가 틀릴 경우 메세지 출력 후 이전 페이지로 되돌아감 */?>
		<script type="text/javascript">alert('비밀번호가 틀립니다');history.back();</script>
	--><?php /*} */?>
