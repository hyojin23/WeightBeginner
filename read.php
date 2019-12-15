<!-- 게시판 목록에서 게시글을 클릭했을 경우 나타나는 페이지 -->

<?php
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />
    <link rel="stylesheet" type="text/css" href="read.css?ver=19" />
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/common.js?ver=32"></script>
    <script type="text/javascript" src="cookie.js?ver=1"></script>
    <link rel="stylesheet" href="header.css?ver=1" />
    <link rel="stylesheet" href="footer.css?ver=1">
    <!--jquery modal 사용을 위해 넣어야 하는 코드(윗 부분 jquery 코드와 중복되면 안됨-->
<!--     Remember to include jQuery :)-->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>-->

    <!-- jQuery Modal -->
<!--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.js"></script>-->
<!--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.2/jquery.modal.min.css" />-->
</head>
<body>
<?php
$index = $_GET['idx']; /* index변수에 게시글의 idx값을 받아와 넣음*/
$views = mysqli_fetch_array(mysql_q("select * from board where idx ='".$index."'")); /*board 테이블의 해당 index의 행을 가져와 views 변수에 넣음*/
//$views = $views['views'] + 1; /*'views'를 키값으로 정해 해당 글의 조회수를 가져오고 +1을 하여 조회될 때마다 조회수가 늘어나게 함(페이지가 열릴 때마다 코드가 실행되어)*/
//$fet = mysql_q("update board set views = '".$views."' where idx = '".$index."'"); /*UPDATE [테이블] SET [열] = '변경할값' WHERE [조건]*/
$sql = mysql_q("select * from board where idx='".$index."'"); /* 받아온 idx값을 조건으로 데이터를 가져옴 */
$board = $sql->fetch_array(); /* $sql 변수에 저장된 데이터를 배열로 가져옴 */

/* 게시글 옆에 댓글 숫자를 표시 */
$data = mysql_q("select * from reply where post_number='".$board['idx']."'"); //reply 테이블에서 post_number가 board의 idx와 같은 것을 선택하여 $data에 저장
$reply_count = mysqli_num_rows($data); // mysqli_num_rows 함수를 사용하여 댓글 숫자를 정수형태로 출력

$views = $views['views'] + 1; /*'views'를 키값으로 정해 해당 글의 조회수를 가져오고 +1을 하여 조회될 때마다 조회수가 늘어나게 함(페이지가 열릴 때마다 코드가 실행되어)*/
$fet = mysql_q("update board set views = '".$views."' where idx = '".$index."'"); /*UPDATE [테이블] SET [열] = '변경할값' WHERE [조건]*/

$a ="php를 사용할수 있다";
?>

<!--글을 읽으면 조회수 조작 방지를 위해 1시간 동안 유지되는 쿠키 생성-->
<script>setCookie("board_views", "stop_views"+<?php echo $index ?>, 1)</script>
<!--쿠키의 value 값을 구함-->
<script type="text/javascript"> var noticeCookie = getCookie("board_views");
//var value = "<?php //echo $a?>//";
// document.write(value);

<?php //if ($a == 1) {echo "헤이헤이헤이ㅋㅋㅋddd";}

?>
</script>
<?php
//
//$variables = "<script> document.write(noticeCookie); </script>";
//
////echo $variables;
////echo "stop_views". $index;
////echo date("Y-m-d H:i:s", time()); // 현재시각
//// strcmp("문자열1" , "문자열2") = 문자열을 비교하여 일치하면 0(true), 일치하지 않으면 false(1) 반환.
//$str = strcmp($variables, "stop_views". $index);
//
//// 쿠키의 value 값과 문자열이 일치하지 않으면(즉 쿠키가 존재하지 않으면) 조회수가 증가한다.
//if (!$str) {
//    echo "호호호";
////    echo $variables;
//    $views = $views['views'] + 1; /*'views'를 키값으로 정해 해당 글의 조회수를 가져오고 +1을 하여 조회될 때마다 조회수가 늘어나게 함(페이지가 열릴 때마다 코드가 실행되어)*/
//    $fet = mysql_q("update board set views = '".$views."' where idx = '".$index."'"); /*UPDATE [테이블] SET [열] = '변경할값' WHERE [조건]*/
//
//
//    // 쿠키의 value 값과 문자열이 일치하면(즉 쿠키가 존재하면) 조회수가 증가하지 않는다.
//} else {
//    echo "하하하";
//}
//
//?>

<!--<script type="text/javascript">
    var noticeCookie = getCookie("board_views");  // getCookie함수에 name값을 넣어 쿠키의 value값 가져옴
    if (noticeCookie !== "stop_views"){ // 쿠키의 value값이 "views" 가 아니면 (즉, 쿠키가 없으면)
        alert("hey");
<?php
/*
        */?>
    }</script>-->
<div id="read_body">
<!-- 글 불러오기 -->
<div id="board_read">
    <h2><?php echo $board['title']; ?></h2> <!--제목-->
    <div id="user_info">
        글쓴이: <?php echo $board['name']; ?> <?php echo "<br />"; ?>
        <div id="date">
        <?php echo $board['date']; ?> 조회수: <?php echo $board['views']; ?> <!--이름, 날짜, 조회수-->
        </div>
        <div id="bo_line"></div> <!-- 제목과 내용을 구분짓는 선-->
    </div>
    <div id="bo_content">
        <?php echo nl2br("$board[content]"); ?> <!--글 내용-->
    </div>
    <?php
    /*글을 읽을 때 로그인이 되어있지 않다면 목록만, 로그인 되어 있다면 아이디가 글 작성자와 같은지 파악하여 목록, 수정, 삭제를 보여준다.*/
    if(!isset($_SESSION['session_id']) && !isset($_SESSION['admin_session_id'])) { // 세션 아이디가 존재하지 않는다면(로그인 안된 상태). if
        ?>
        <div id="bo_ser">
            <ul>
                <li><a href="board.php">[목록으로]</a></li> <!--목록 메뉴만 보여준다.-->
            </ul>
        </div>
        <?php
        /*글을 쓴 아이디와 로그인한 아이다가 같다면 목록, 수정, 삭제 메뉴를 보여주고 다르다면 목록 메뉴만 보여준다.*/
        // 로그인한 세션 아이디와 글 작성자가 같다면. else if
    } else if(isset($_SESSION['session_id']) && $_SESSION['session_id'] == $board['name'] ) {
        ?>
        <!-- 목록, 수정, 삭제 -->
        <div id="bo_ser">
            <ul>
                <li><a href="board.php">[목록으로]</a></li>
                <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
                <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
                <!--jquery modal 사용 연습 코드-->
                <!-- <li><a href="#modal" rel="modal:open">Open Modal</a></li>-->
            </ul>
        </div>

        <?php
        // 관리자 세션 아이디가 있다면 else if
        } else if (isset($_SESSION['admin_session_id'])) {
            ?>
                    <div id="bo_ser">
            <ul>
                <li><a href="board.php">[목록으로]</a></li>
                <li><a href="modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
                <li><a href="delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
                <!--jquery modal 사용 연습 코드-->
                <!-- <li><a href="#modal" rel="modal:open">Open Modal</a></li>-->
            </ul>
        </div>
        <?php } else { // 로그인한 세션 아이디와 글 작성자가 다르다면. else
    ?>
    <div id="bo_ser">
        <ul>
            <li><a href="board.php">[목록으로]</a></li>
        </ul>
    </div>
<?php } ?> <!--else문 괄호 닫음-->

</div>
<!--모달 창 연습문구-->
<!--<div id="ex1" class="modal">-->
<!--    <p>Thanks for clicking. That felt good.</p>-->
<!--    <a href="#" rel="modal:close" style="color: red;">Close</a>-->
<!--</div>-->


<?php //include $_SERVER['DOCUMENT_ROOT'] . "/reply_load.php"; // 댓글 목록을 불러옴 ?>



<div class="reply_view">
    <h3>댓글<?php echo " ".$reply_count ?></h3>
    <?php
    // 게시글의 인덱스 번호를 조건으로 댓글을 불러온 후 댓글의 인덱스번호를 기준으로 오름차순 정렬(큰 수에서 작은수로 떨어짐. 나중에 쓴 댓글이 밑으로 가도록 함)
    $reply_data = mysql_q("select * from reply where post_number='".$index."' order by idx asc");
    while($reply = $reply_data->fetch_array()){ // 한 행의 정보를 배열로 가져와 $reply에 저장, 더 이상 가져올 데이터가 없을 때까지 계속 반복
        ?>

        <!--댓글 보여주기-->
        <div class="dap_lo">

            <?php
            // 블라인드 되지 않은 글일 경우
            if ($reply['is_blind'] == 0) {

                // 일반 유저가 쓴 글이면
            if ($reply['is_admin'] == 1) { ?>
                <div id="reply_id"><b><?php echo $reply['name'];?></b></div>  <!--댓글 쓴 아이디를 댓글창에 표시-->
                <div class="dap_to comt_edit" id="reply_content"><?php echo nl2br("$reply[content]"); ?></div> <!--댓글 내용 표시(글자색 검정)-->
                <?php }

                // 관리자가 쓴 글이면
            if ($reply['is_admin'] == 0) { ?>
                <div id="reply_id"><b><?php echo $reply['name'];?></b></div>
                <div class="admin_reply_content" id="admin_reply_content"><?php echo nl2br("$reply[content]"); ?></div> <!--관리자 댓글 내용 표시(글자색 변경됨)-->
            <?php } ?>

            <div class="rep_me dap_to" id="reply_time"><?php echo $reply['create_date']; ?></div> <!--댓글 쓴 날짜와 시간 표시-->

            <?php }
            // 관리자가 블라인드를 눌러 블라인드된 글일 경우 ( $reply['is_blind'] == 1 일때)
            else { ?>
            <div class="dap_to comt_edit" id="reply_content">관리자에 의해 블라인드 처리된 댓글입니다.</div> <!--댓글 내용 표시-->
            <div class="rep_me dap_to" id="reply_time"><?php echo $reply['create_date']; ?></div> <!--댓글 쓴 날짜와 시간 표시-->
            <?php } ?>


            <div class="rep_me rep_menu" id="edit_delete_bt">
                <?php
                /* 로그인한 아이디와 댓글 작성자가 일치하면 수정, 삭제를 보여준다. */
                // 관리자 세션, 일반 유저 세션 아이디가 존재하지 않는다면(로그인 안된 상태). if
                if(!isset($_SESSION['session_id']) && !isset($_SESSION['admin_session_id'])) {
                    ?>
                    <?php
                    /*댓글을 쓴 아이디와 로그인한 아이다가 같다면 수정, 삭제 버튼을 보여주고 다르다면 보여주지 않는다..*/
                    // 세션 아이디가 존재하고 로그인한 세션 아이디와 글 작성자가 같다면. else if
                } else if(isset($_SESSION['session_id']) && $_SESSION['session_id'] == $reply['name'] ) {
                    ?>
                    <!-- 댓글 수정과 삭제 버튼-->
                    <a class="dat_edit_bt" href="javascript:void(0)" >수정</a>
                    <a class="dat_delete_bt" href="javascript:void(0)" >| 삭제</a>
                    <?php
                     // 관리자 세션 아이디가 존재한다면
                } else if(isset($_SESSION['admin_session_id'])) {
                    // 그 중에서 블라인드 되지 않은 글이면
                    if ($reply['is_blind'] == 0 && $_SESSION['admin_session_id'] != $reply['name']) {
                    ?>
                    <!-- 댓글 블라인드와 삭제 버튼-->
                    <a class="reply_blind" href="javascript:void(0)" onclick="" >블라인드</a>
                    <a class="dat_delete_bt" href="javascript:void(0)" >| 삭제</a>
                    <?php } else if ($reply['is_blind'] == 0 && $_SESSION['admin_session_id'] == $reply['name']) { ?>
                              <!-- 댓글 수정과 삭제 버튼-->
                    <a class="dat_edit_bt" href="javascript:void(0)" >수정</a>
                    <a class="dat_delete_bt" href="javascript:void(0)" >| 삭제</a>
                    <?php } else { ?>
                        <!-- 댓글 블라인드 해제와 삭제 버튼-->
                        <a class="reply_blind_cancel" href="javascript:void(0)" onclick="" >블라인드 해제</a>
                        <a class="dat_delete_bt" href="javascript:void(0)" >| 삭제</a>
                    <?php } ?>

                    <?php
                    // 관리자 세션도 없고 로그인한 세션 아이디와 글 작성자가 다르다면. else
                } else {
                  } ?> <!--else문 괄호 닫음-->
            </div>

            <!-- 댓글 수정 폼 dialog -->
            <div class="dat_edit" id="reply_edit">
                <script>console.log("댓글 수정 폼 실행")</script>
                <form method="post" > <!--POST 방식. ajax로 데이터 전달-->
                    <!-- 유저에게 보이지 않는 hidden 방식으로 댓글 인덱스번호($reply['idx'])와 게시글 인덱스 번호($index)를 전달 -->
                    <input type="hidden" name="reply_number" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="index" value="<?php echo $index; ?>">

                    <!--비밀번호 입력란-->
<!--                    <input type="password" name="pw" class="dap_sm" placeholder="비밀번호"/> -->


                    <textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea> <!--내용 입력란-->
                    <!--수정 버튼. submit으로 하면 페이지가 초기화되어 스크롤이 위로 올라간다. 댓글 수정을 ajax로 처리하였으므로 페이지의 움직임이 없게 하기 위해 type = button으로 한다 -->
<!--                    <input type="button" value="수정하기" class="reply_modify_button" onclick=""> <!수정 버튼-->
                </form>
            </div>

            <!-- 댓글 삭제시 게시글, 댓글 인덱스 번호와 댓글 삭제를 위해 입력한 비밀번호를 전달 -->
            <div class='dat_delete'>
                <form id="delete_form" method="post">
                    <div class="delete_warning">정말 삭제하시겠습니까?</div>
                    <!-- 유저에게 보이지 않는 hidden 방식으로 댓글 인덱스번호($reply['idx'])와 게시글 인덱스 번호($index)를 전달 -->
                    <input type="hidden" name="reply_number" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="post_number" value="<?php echo $index; ?>">
<!--                    <p>비밀번호<input type="password" name="delete_password" /> <input type="submit" value="확인"></p>-->
                </form>
            </div>

            <!-- 관리자가 댓글 블라인드 처리시 댓글 인덱스 번호 전달-->
            <div class='dat_blind'>
                <form id="blind_form" method="post" >
                    <?php  if ($reply['is_blind'] == 0) {
                        ?>
                        <div class="blind_warning">블라인드 완료</div>
                    <?php } else {  ?>
                        <div class="blind_warning">블라인드 해제</div>
                    <?php  } ?>
                    <!-- 유저에게 보이지 않는 hidden 방식으로 댓글 인덱스번호($reply['idx'])와 게시글 인덱스 번호($index)를 전달 -->
                    <input type="hidden" id="number" name="reply_number" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="post_number" value="<?php echo $index; ?>">
                </form>
            </div>

        </div>
    <?php } ?>


    <!--- 댓글 입력 폼 -->
    <div class="dap_ins">
        <form method="post" class="reply_form">
            <input type="hidden" name="index" value="<?php echo $index; ?>"> <!--유저에게 안 보이게 게시글 인덱스 번호 전송-->

            <!--아이디와 비밀번호 입력란-->
<!--            <input type="text" name="reply_user_name" id="dat_user" size="15" placeholder="아이디"> -->
<!--            <input type="password" name="reply_password" id="dat_pw" size="15" placeholder="비밀번호"> -->

            <div class="reply_form" style="margin-top:10px; ">
                <!--댓글 내용 입력란(수정 폼과 name이 동일하면 수정 클릭 후 다시 댓글을 작성할 때 수정 폼에 있던 내용이 입력되므로 주의 -> content를 write_content로 고쳐 해결)-->
                <textarea name="write_content" class="reply_content" id="re_content" ></textarea>
                <!--댓글 전송 버튼(type이 submit이 아니라 button임 submit으로 할 경우 페이지를 초기화시켜 스크롤이 위로 올라가게함)-->
                <button type="button" id="rep_bt" class="reply_button" onclick=
                "console.log('read.php의 댓글 버튼을 누름');">등록</button>
            </div>
        </form>
    </div>
</div><!--- 댓글 불러오기 끝 -->
</div> <!--read_body 끝-->
<div id="foot_box"></div>

<?php
/*댓글 입력창을 눌렀을 때 로그인이 되어있는지 검사*/
// 세션 아이디가 존재하지 않으면 로그인체크함수 실행
if(!isset($_SESSION['session_id']) && !isset($_SESSION['admin_session_id']) ) {
    ?>
    <!--댓글 입력 창 클릭시 로그인되었는지 체크-->
    <script>replyLoginCheck();</script>
    <script>replyLoginCheckBtn();</script>

    <?php
}
?>

</body>

<!--자바스크립트 파일과 연결-->
<!--<script src="http://code.jquery.com/jquery-latest.js"></script>-->
<!--<script  type="text/javascript"src = delete.js?ver=1></script>-->
</html>
<?php
include "footer.html";
?>
