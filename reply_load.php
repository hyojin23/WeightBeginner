<!-- 댓글 목록을 불러오기 위한 파일-->
<!---->
<!--<!doctype html>-->
<!--<html lang="en">-->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <title>게시판</title>-->

<!--</head>-->
<!--<body>-->
<div class="reply_view">
<?php
// 게시글의 인덱스 번호를 조건으로 댓글을 불러온 후 댓글의 인덱스번호를 기준으로 오름차순 정렬(큰 수에서 작은수로 떨어짐. 나중에 쓴 댓글이 밑으로 가도록 함)
$reply_data = mysql_q("select * from reply where post_number='".$index."' order by idx asc");
// 게시글의 댓글 갯수
$reply_count = mysqli_num_rows($reply_data); ?>
<!--<div class="reply_view">-->
    <h3>댓글<?php echo " ".$reply_count ?></h3>

  <?php
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
                <script>console.log("reply_load.php 파일 실행")</script>
                <form method="post" > <!--POST 방식. ajax로 데이터 전달-->
                    <!-- 유저에게 보이지 않는 hidden 방식으로 댓글 인덱스번호($reply['idx'])와 게시글 인덱스 번호($index)를 전달 -->
                    <input type="hidden" name="reply_number" value="<?php echo $reply['idx']; ?>" /><input type="hidden" name="index" value="<?php echo $index; ?>">

                    <!--비밀번호 입력란-->
<!--                    <input type="password" name="pw" class="dap_sm" placeholder="비밀번호"/> -->

                    <textarea name="content" class="dap_edit_t"><?php echo $reply['content']; ?></textarea> <!--내용 입력란-->

                    <!--수정 버튼. submit으로 하면 페이지가 초기화되어 스크롤이 위로 올라간다. 댓글 수정을 ajax로 처리하였으므로 페이지의 움직임이 없게 하기 위해 type = button으로 한다 -->
                    <!--                    <input type="button" value="수정하기" class="reply_modify_button"> -->

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

            <!--아이디와 비밀번호 입력란 -->
<!--            <input type="text" name="reply_user_name" id="dat_user" size="15" placeholder="아이디"> -->
<!--            <input type="password" name="reply_password" id="dat_pw" size="15" placeholder="비밀번호"> -->

            <div class="reply_form" style="margin-top:10px; ">
                <!--댓글 내용 입력란(수정 폼과 name이 동일하면 수정 클릭 후 다시 댓글을 작성할 때 수정 폼에 있던 내용이 입력되므로 주의 -> content를 write_content로 고쳐 해결)-->
                <textarea name="write_content" class="reply_content" id="re_content" ></textarea>
                <!--댓글 전송 버튼(type이 submit이 아니라 button임 submit으로 할 경우 페이지를 초기화시켜 스크롤이 위로 올라가게함)-->
                <button type="button" id="rep_bt" class="reply_button" onclick="
                  console.log('reply_load.php의 댓글 버튼을 누름');">등록</button>
            </div>
        </form>
    </div>
</div>
<!--- 댓글 불러오기 끝 -->
<!--</div>-->

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

<!--</body>-->
<!--</html>-->