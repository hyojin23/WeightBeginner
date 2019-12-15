<!--- 게시글 수정 -->
<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";

$index = $_GET['idx']; // 인덱스 번호
$sql = mysql_q("select * from gallery_board where idx='$index';"); // 인덱스 번호를 조건으로 board 테이블의 데이터를 불러옴
$board = $sql->fetch_array(); // 불러온 데이터
?>
<!doctype html>
<?php
include "header.html";
?>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" href="modify.css?ver=1" />
    <link rel="stylesheet" href="header.css?ver=1" />
    <link rel="stylesheet" href="footer.css?ver=1">
</head>
<body>
<div id="board_write">
    <h1><a href="/">운동용품 중고거래</a></h1>
    <h4>글을 수정합니다.</h4>
    <div id="write_area">
        <form action="used_item_modify_ok.php" method="post" enctype="multipart/form-data"> <!--수정한 글의 데이터를 modify_ok.php로 보냄-->
            <input type="hidden" name="idx" value="<?=$index?>" /> <!--유저에게 보이지 않게 hidden 속성으로 인덱스 번호를 input 태그에 입력. 글을 작성하면 인덱스 번호도 modify_ok.php로 넘어감-->
            <div id="in_title">
                제목: <textarea name="title" id="utitle" rows="1" cols="55" placeholder="제목" maxlength="100" required><?php echo $board['title']; ?></textarea> <!--글 제목-->
            </div>
            <div class="wi_line"></div>
            <div id="in_name">
                글쓴이: <input type="hidden" name="name" id="modify_name" value="<?php echo $_SESSION['session_id']?>"><?php echo $_SESSION['session_id']?> <!--글쓴이-->
            </div>
            <div class="wi_line"></div>
            <div id="in_content">
                <textarea name="content" id="ucontent" placeholder="내용" required><?php echo $board['content']; ?></textarea> <!--글 내용-->
            </div>
            <div style="width: 200px; margin:0 auto; margin-left: 720px; margin-top: 20px">
                <input type="file" name="file_to_upload" id="file_to_upload"> <!--파일 선택 버튼-->
            </div>

            <!--비밀번호-->
            <!--            <div id="in_pw">-->
            <!--                <input type="password" name="user_password" id="upw"  placeholder="비밀번호" /> -->
            <!--            </div>-->

            <div class="bt_se">
                <button type="submit">수정</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
include "footer.html";
?>

