<script type="text/javascript" src="/js/common.js?ver=34"></script>
<?php

include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; // DB에 연결
// 오늘의 추천운동 부분에 들어갈 제목, 유튜브 url, 링크를 걸 웹사이트 주소, 내용을 입력
mysql_q("insert into today_workout(title, youtube_url, website_src, content) values 
('" . $_POST['title'] . "', '" . $_POST['youtube_url'] . "', '" . $_POST['website_src'] . "', '" . $_POST['content'] . "')");

?>

<!--today_workout 테이블에서 인덱스 번호 기준으로 내림차순 정렬하여 가장 최근에 입력된 데이터(인덱스 번호가 가장 큰 것) 1개만 가져와 배열에 넣는다.-->
<?php $work_out = "select * from today_workout order by idx DESC limit 1";
$data = mysql_q($work_out);
$board = $data->fetch_array(); ?>

<div id="page" class="container">
    <div id="content"> <!--추천운동 탭-->
        <div class="title">
            <h2>오늘의 추천 운동 </h2><br>
            <h3> : <?php echo $board['title']; ?> </h3>
        </div>
        <p>
            <?php echo $board['content']; ?>
        </p>
        <!--누르면 네이버 운동설명으로 감-->
        <!--            <a href="https://terms.naver.com/entry.nhn?docId=938862&cid=51030&categoryId=51030" target="_blank" class="button icon icon-arrow-right">Learn More</a>-->
        <a href= "<?php echo $board['website_src']; ?>" target="_blank" class="button icon icon-arrow-right">Learn More</a>
    </div>
    <div id="iframe"> <!--유튜브 영상을 넣기 위한 iframe-->
        <!--            <iframe width="588" height="350" src="https://www.youtube.com/embed/o6jUa3sQQFw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>-->
        <iframe width="588" height="350" src="<?php echo $board['youtube_url']; ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>

    <!--        <script>-->
    <!--            $(".modify").click(function () {-->
    <!--                console.log("hey");-->
    <!--                alert("hey");-->
    <!--                var obj = $(".today_workout_modify");-->
    <!--                obj.dialog({-->
    <!--                    modal: false,-->
    <!--                    position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정-->
    <!--                });-->

    <!--            });-->
    <!--        </script>-->

    <!--관리자 세션 아이디가 있으면 수정하기 버튼이 보임-->
    <?php
    if(isset($_SESSION['admin_session_id'])) { ?>
        <!--수정 버튼-->
        <div id="modify_button">
            <a class="modify" href="javascript:void(0)" onclick="" >[수정하기]</a>
        </div>
    <?php  } ?>

    <div class="today_workout_modify">

        <form method="post">
            제목: <input type="text" name="title" id="today_title" >
            동영상 URL: <input type="text" name="youtube_url" id="youtube_url">
            연결 웹사이트 주소: <input type="text" name="website_src" id="website_src">
            내용: <textarea name="content" id="today_content"></textarea> <!--내용 입력란-->
        </form>

    </div>
    <!--        <div id="sidebar"><a href="#"><img src="images/pic05.jpg" width="588" height="250" alt="" /></a></div>-->
</div>