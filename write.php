<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="write.css?ver=2" />
    <link rel="stylesheet" href="header.css?ver=1" />
    <link rel="stylesheet" href="footer.css?ver=1">
</head>

<?php
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html";
?>

<body>
<?php
/*글쓰기 버튼을 눌렀을 때 로그인이 되어있는지 검사*/
if(!isset($_SESSION['session_id']) && !isset($_SESSION['admin_session_id']) ) { // 일반유저나 관리자 세션 아이디가 존재하는지 검사
    ?>

    <script>
        alert("로그인이 필요합니다"); // 아이디가 존재하지 않으면(로그인이 안되어 있으면) 로그인을 요청하고 로그인 화면으로 돌아감
        location.replace('login_page.html');
    </script>
    <?php
}
?>

<div id="board_write">
    <h1>자유게시판</h1>
    <h4>자유롭게 글을 쓸 수 있는 게시판입니다.</h4> <!--게시글 목록-->
    <div id="write_area">
        <form action="write_ok.php" method="post">
            <div id="in_title"> <!--제목 입력-->
                제목: <textarea name="write_title" id="write_title" rows="1" cols="55" placeholder="게시글 제목을 입력하세요" maxlength="100" required></textarea>
            </div>
            <div class="wi_line"></div>
            <div id="in_name"> <!--글쓴이 입력-->
           <!--     <textarea name="write_name" id="write_name" rows="1" cols="55" placeholder="글쓴이" maxlength="100" required></textarea>-->
                <?php if (isset($_SESSION['session_id'])) { ?>
                    글쓴이: <input type="hidden" name="write_name" id="write_name" value="<?php echo $_SESSION['session_id']?>"><?php echo $_SESSION['session_id']?>
               <?php } else {?>
                    글쓴이: <input type="hidden" name="write_name" id="write_name" value="<?php echo $_SESSION['admin_session_id']?>"><?php echo $_SESSION['admin_session_id']?>
                <?php } ?>
            </div>
            <div class="wi_line"></div>
            <div id="in_content"> <!--내용 입력-->
                <textarea name="write_content" id="write_content" placeholder="내용을 입력하세요" required></textarea>
            </div>

<!--            <div id="in_pw"> <!-비밀번호 입력-->
<!--                <input type="password" name="write_password" id="write_password"  placeholder="비밀번호" />-->
<!--            </div>-->
<!--            <div id="in_lock">-->
<!--                <input type="checkbox" value="1" name="lock" />해당글을 잠급니다.-->
<!--            </div>-->

            <div class="bt_se"> <!--하단 글 등록 버튼-->
                <button type="submit">등록</button>
            </div>
        </form>
    </div>
</div>
</body>
</html>
<?php
include "footer.html";
?>