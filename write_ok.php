<?php

// db와 연결
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";
$date = date("Y-m-d H:i:s", time()); // 현재시각
// 날짜를 변수로 저장. 시간으로 기록하고 싶으면 Y-m-d H:i:s
// $date = date('Y-m-d H:i:s'); 이 코드를 써서 시간을 넣으면 시간이 현재시간과 다르게 나옴. 그래서 DB에서 date의 기본값을 CURRENT TIMESTAMP로 바꿔 해결 -> aws서버에서는 현재시간보다 9시간 전으로 나옴
// 서버 설정 바꿔도 그대로여서 $date 사용

// POST로 받아온 비밀번호를 암호화하여 변수에 저장
$write_password = password_hash($_POST['write_password'], PASSWORD_DEFAULT);

if(isset($_POST['lock'])){ // wirte.php에서 name=lock인 폼에 값이 존재하면(해당글을 잠급니다 체크할 경우) $lock_post 변수에 1 저장, 그렇지 않으면 0 저장
    $lock_post = '1';
}else{
    $lock_post = '0';
}

$initilize_idx = mysql_q("alter table board auto_increment =1"); //auto_increment 값 초기화
// insert into로 DB에 저장
// column에 default 값이 없을 경우 column을 적어주지 않으면 DB에 데이터가 들어가지 않으므로 주의. 터미널에서 직접 명령어 쳐봐서 에러메세지 확인할것
$sql = mysql_q("insert into board(name,write_password,title,content,lock_post,date) /* board 테이블에 글쓴이, 비밀번호, 제목, 내용, 글 잠금 여부를 저장함 */
values('".$_POST['write_name']."','".$write_password."','".$_POST['write_title']."','".$_POST['write_content']."','".$lock_post."','" . $date . "')");
?>

<script type="text/javascript">alert("등록되었습니다.");</script>
<!--글을 작성하면 글 목록 페이지로 이동-->
<meta http-equiv="refresh" content="0 url=board.php" />

