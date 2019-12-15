<?php
include "db/db.php"; // db 연결


// 로그인시 환영문구
        // 세션값이 있으면 환영문구와 로그아웃 글씨가 보이고 로그아웃을 누르면 logout_page.php에 의해 세션이 종료되고 메인페이지가 호출된다.
    if (isset($_SESSION['session_id'])) {
        echo "<div id='login'><a href='logout_page.php'> 로그아웃 </a> </div>";
//        echo "<div id='login'><a href='logout_page.php'> 로그아웃 </a> <a href='chatting.php'>/ 채팅방 입장</a> </div>";
        echo "<div id='login_greeting'>{$_SESSION['session_id']} 님 환영합니다!</div>";
    } else if (isset($_SESSION['admin_session_id'])) {
        echo "<div id='login'><a href='logout_page.php'> 로그아웃 </a> </div>";
//        echo "<div id='login'><a href='logout_page.php'> 로그아웃 </a> <a href='chatting.php'>/ 채팅방 입장</a> </div>";
        echo "<div id='login_greeting'>관리자 {$_SESSION['admin_session_id']} 님 환영합니다!</div>";
    } else {
        // 세션값이 없을 경우
//        echo "<div id='login'><a href='login_page.html'>로그인 </a><a href='sign_up_page.html'>/ 회원가입</a></div>";
    }

?>
