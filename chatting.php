<!--채팅 파일-->

<?php
//include  $_SERVER['DOCUMENT_ROOT']."db/db.php";
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html"; // 헤더 html 파일
//include "chatting/client.html";
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>채팅방</title>
        <link rel="stylesheet" href="header.css?ver=1">
        <link rel="stylesheet" href="footer.css?ver=1">
        <link rel="stylesheet" href="chatting.css?ver=4">
        <link rel="stylesheet" href="chatting/server.js?ver=1">
        <script src="/socket.io/socket.io.js"></script> <!-- socket.io를 사용하기 위해 socket.io.js를 가져옴 -->
        <script src="//code.jquery.com/jquery-1.11.1.js"></script>
        <!--jquery 사용을 위해 연결-->
        <!--    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>-->
        <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="/js/jquery-ui.js"></script>
        <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />
    </head>
    <body>
    <div id="frame">
<!--<p align="middle"><iframe id="chatting_frame" width="700" height="450" src="http://localhost:3000/" frameborder="1" ></iframe></p>-->
<p align="middle"><iframe id="chatting_frame" width="700" height="450" src="https://weightbeginner.ga:8000/" frameborder="0" ></iframe></p>
    </div>
    </body>
    </html>


<?php
include "footer.html";
?>