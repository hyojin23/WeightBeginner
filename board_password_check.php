<!--게시판에서 비밀글을 클릭할 경우 실행되는 파일-->
<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; /* db load */
?>
<link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery-ui.js"></script>
<script type="text/javascript" src="/js/common.js?ver=1"></script>


<?php

$index = $_POST['index']; /* index 변수에 index값을 받아와 넣음*/
$sql = mysql_q("select * from board where idx='".$index."'"); /* 받아온 idx값을 조건으로 board 테이블의 데이터를 불러움 */
$board = $sql->fetch_array(); /* 데이터를 $board 변수에 배열로 저장 */

?>
<?php
$write_password = $board['write_password']; /* 게시글을 쓸때 저장했던 비밀번호를 $write_password 변수에 저장 */

if(isset($_POST['password_check'])) //만약 password_check의 POST값이 있다면(글을 보려고 눌렀을 때 비밀번호를 입력했다면)
{
    $password = $_POST['password_check']; // $password 변수에 POST값으로 받은 password_check(글을 보려고 눌렀을 때 입력한 비밀번호)를 넣음
    if(password_verify($password,$write_password)) //다시 if문으로 현재 입력한 비밀번호와 글의 비밀번호가 같은지 비교를 하고
    {
//        $password == $write_password; // 현재 입력한 비밀번호와 글의 비밀번호가 같으면
        ?>
        <script type="text/javascript">location.replace("read.php?idx=<?php echo $board["idx"]; ?>");</script><!-- password와 write_password값이 같으면 read.php로 보내고 -->
        <?php
    }else{ ?>
        <script type="text/javascript">alert('비밀번호가 틀립니다');</script><!--- 아니면 비밀번호가 틀리다는 메시지를 보여줌 -->
    <?php } } ?>
