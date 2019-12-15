<?php
include "db/db.php";
// GET 방식으로 입력된 아이디를 받아옴
$id = $_GET["user_id"];
// DB의 userInfo 테이블에서 입력된 아이디를 검색해 그 행을 가져와 $sql 변수에 저장
$sql = mysql_q("select * from userInfo where id='$id'");
// DB의 데이터를 php에서 쓸 수 있는 배열로 가져옴
$is_id = $sql->fetch_array();

// DB에 아이디가 존재하지 않을 경우
if($is_id==0)
{
    ?>
    <div class = "text" id="id_confirm_text" style='font-family:"malgun gothic"; color: mediumblue'><?php echo $id; ?>는 사용가능한 아이디입니다.</div>
    <?php
    // DB에 아이디가 존재할 경우
}else{
?>
<div class = "text" style='font-family:"malgun gothic"; color:red;'><?php echo $id; ?>는 중복된 아이디입니다.<div>
        <?php
        }
        ?>
        <div id="quit"><button value="닫기" onclick="window.close()">닫기</button></div>
        <script>
        </script>
<style>

    .text {
        text-align: center;

    }
    #id_confirm_text {


    }
    #quit {
        text-align: center;
        margin-top: 20px;

    }
</style>