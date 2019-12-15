<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>운동용품 중고거래</title>
    <link rel="stylesheet" href="used_item_board.css?ver=4"/>
    <link rel="stylesheet" href="header.css?ver=1"/>
    <link rel="stylesheet" href="footer.css?ver=1">
</head>

<body>

<?php
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html"; // 헤더 html 파일
?>

<div id="main">
    <div class="inner">
        <a href="used_item_write.php"><input type="button" id="write_button" value="글 등록"></a>


        <!-- Boxes -->
        <div class="thumbnails">
            <?php
            $one_page_data = mysql_q("select * from gallery_board order by idx desc");

            while ($board = $one_page_data->fetch_array()) // 한 행의 정보를 배열로 가져와 $board에 저장, 더 이상 가져올 데이터가 없을 때까지 계속 반복
            {
                $title = $board["title"]; // 제목
                $content = $board["content"]; // 내용
                $substr_content = iconv_substr($content, 0, 50, "utf-8"); // 내용이 50자 까지만 출력되게 함

                // 글 제목 글자수 조절
                if (strlen($title) > 100) // 제목이 20자 이상이면
                {
                    //글 내용이 50자를 넘어서면 ...표시
                    $title = str_replace($board["title"], iconv_substr($title, 0, 30, "utf-8") . "...", $board["title"]);

                } else {
                    $title = nl2br($title. "\n" . "\n"  ); // 20자 이내이면 내용이 적어 버튼이 올라가지 않도록 하기 위해 줄바꿈 공백을 넣는다.
                }
//                echo strlen($title);

                // 글 내용 글자수 조절
                if (strlen($content) > 50) // 내용이 50자 이상이면
                {
                    //글 내용이 50자를 넘어서면 ...표시
                    $content = str_replace($board["content"], $substr_content . "...", $board["content"]);
                } else {
                    $content = nl2br($content . "\n" . "\n" ); // 50자 이내이면 내용이 적어 버튼이 올라가지 않도록 하기 위해 줄바꿈 공백을 넣는다.
                }

                $name = $board["name"]; // 글쓴이
                $image_url = $board["image_url"]; // 이미지 파일 경로
                $index = $board["idx"];  // 인덱스 번호

                // 3가지 버튼 색깔을 골고루 가지도록 함
                $remainder = $index % 6;
                if ($remainder == 0 || $remainder == 2) {
                    $button_class = "button fit"; // 초록색 버튼

                } else if ($remainder == 1 || $remainder == 5) {
                    $button_class = "button style2 fit"; // 파란색 버튼

                } else {
                    $button_class = "button style3 fit"; // 보라색 버튼

                }
                ?>
                <div class="box">
                    <a href='used_item_read.php?idx=<?php echo $board["idx"]; ?>' class="image fit"><img src="<?php echo $image_url ?>" width="420" height="420" alt=""/></a>
                    <div class="inner">
                        <h3><?php echo $title ?></h3>
                        <p><?php echo $content ?></p>
                        <a href='used_item_read.php?idx=<?php echo $board["idx"]; ?>' class="<?php echo $button_class ?>" data-poptrox="youtube,800x400">글 확인하기</a>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>

</body>
</html>


<?php
include "footer.html";
?>
