<script>console.log("reply_ok 파일 실행")</script>

<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; // db 파일과 연결
$date = date("Y-m-d H:i:s", time()); // 현재시각
?>
<!--게시글의 번호를 POST로 받아 $index에 저장. reply_load.php로 목록을 불러올 때 인덱스번호가 필요함-->
<?php   $index = $_POST['index']; ?>

<!--로그인 된 상태에서 댓글을 입력하려고 할 경우-->
<?php if (isset($_SESSION['session_id']) || isset($_SESSION['admin_session_id']) ) { // 1번 if문 시작
   // 댓글 내용이 없으면 댓글 내용을 입력하라는 경고창을 띄움
if (!$_POST['write_content'] ) { ?>

<script> alert("댓글 내용을 입력해주세요."); </script>
    echo date("Y-m-d H:i:s", time());

<?php } else if (isset($_SESSION['session_id'])) { // 댓글 내용이 존재하고 세션 아이디가 존재하면 db에 댓글 저장
  //  $userpw = password_hash($_POST['reply_password'], PASSWORD_DEFAULT); // 댓글 패스워드 암호화해 저장
    // 게시글 인덱스번호, 세션 아이디, 댓글 내용 저장
    $sql = mysql_q("insert into reply(post_number,name,content,create_date,update_date) values('" . $index . "','" . $_SESSION['session_id'] . "','" . $_POST['write_content'] . "','" . $date . "','" . $date . "')");
} else if (isset($_SESSION['admin_session_id'])) {
    $sql = mysql_q("insert into reply(post_number,name,content,is_admin,create_date,update_date) values('" . $index . "','" . $_SESSION['admin_session_id'] . "','" . $_POST['write_content'] . "','0','" . $date . "','" . $date . "')");
}
} // 1번 if문 끝 ?>


<?php
include $_SERVER['DOCUMENT_ROOT'] . "/reply_load.php"; // 댓글 목록을 불러옴
?>
<script type="text/javascript" src="/js/common.js?ver=5"></script>
<script>console.log("zzzzz")</script>

