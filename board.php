
<!doctype html>
<head>
    <meta charset="UTF-8">
    <title>게시판</title>
    <link rel="stylesheet" type="text/css" href="board.css?ver=4" />
    <script type="text/javascript" src="cookie.js?ver=1"></script>
    <link rel="stylesheet" href="header.css?ver=2">
    <link rel="stylesheet" href="footer.css?ver=1">
    <link rel="stylesheet" type="text/css" href="/css/jquery-ui.css" />
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/common.js?ver=2"></script>
</head>

<?php
//include  $_SERVER['DOCUMENT_ROOT']."db/db.php";
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html"; // 헤더 html 파일
?>

<body>

<div id="page-wrapper">
<div id="board_area">
    <h1>자유게시판 </h1>
    <h4>자유롭게 글을 쓸 수 있는 게시판입니다.</h4>
    <table class="list-table">
        <thead>
        <tr>
            <th width="70">번호</th>
            <th width="500">제목</th>
            <th width="120">글쓴이</th>
            <th width="100">작성일</th>
            <th width="100">조회수</th>
        </tr>
        </thead>
        <!--게시글 페이징을 위한 부분
        블록: 한 번에 표시되는 하단의 숫자 묶음(한 블록당 보여줄 페이지 갯수를 5로 지정했으면 하단의 숫자 1 2 3 4 5 가 첫번째 블록이고 6 7 8 9 10 이 두번째 블록-->
        <?php
        if(isset($_GET['page'])){       // 처음 접속했을 경우 page는 1이고 나머지 경우 page는 선택한 페이지 값이다.
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        $get_sql = mysql_q("select * from board"); // 게시판 데이터를 가져옴
        $row_num = mysqli_num_rows($get_sql); //게시판 총 행의 수(=게시글 수)
        $list = 10; //한 페이지에 보여줄 게시글 갯수
        $block_ct = 5; //블록당 보여줄 페이지 개수( 한 블록당 보여줄 페이지 갯수를 5로 지정했으면 하단에 1 2 3 4 5 로 나오고 다음 블록이 되면 6 7 8 9 10 으로 나옴)

        $block_num = ceil($page/$block_ct); // 현재 페이지가 몇 번째 블록인지 구함 , ceil = 소수점의 올림하는 함수
        $block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호 ex) 3블록이면 block_ct가 5일때 블록 시작번호는 11
        $block_end = $block_start + $block_ct - 1; //블록 마지막 번호 ex) 3블록이면 block_ct가 5일때 블록 끝번호는 15

        $total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기 ex) (총 게시글/한 페이지에 보여줄 게시글)의 소수점을 올림 = 페이징한 페이지수
        if($block_end > $total_page) $block_end = $total_page; // 만약 블록의 마지막 번호가 페이지수보다 많다면 블록의 마지막 번호는 페이지 수랑 같게 함, 그렇지 않으면 게시글 없는 빈 페이지가 있을 수 있음
        $total_block = ceil($total_page/$block_ct); // 블록 총 개수
        $start_num = ($page-1) * $list; // DB에서 게시글을 구분하기 위한 게시글 시작번호. DB의 첫번째 게시글은 0번부터 시작함. (page-1)에서 $list를 곱한다.

        /* 한 페이지에 표시할 게시글의 수.
        인덱스 번호 기준 큰 수에서 작은 수로 내림차순 정렬하고(최신글이 위에 오도록 하기 위해) $start_num부터 $list 갯수만큼 데이터를 가져옴*/
        $one_page_data = mysql_q("select * from board order by idx desc limit $start_num, $list");
        while($board = $one_page_data->fetch_array()) // 한 행의 정보를 배열로 가져와 $board에 저장, 더 이상 가져올 데이터가 없을 때까지 계속 반복
        {
            $title=$board["title"];
//            if(strlen($title)>30)
//            {
//                $title=str_replace($board["title"],mb_substr($board["title"],0,30,"utf-8")."...",$board["title"]); //글 제목이 30줄을 넘어서면 ...표시
//            }

            /* 게시글 옆에 댓글 숫자를 표시 */
            $data = mysql_q("select * from reply where post_number='".$board['idx']."'"); //reply 테이블에서 post_number가 board의 idx와 같은 것을 선택하여 $data에 저장
            $reply_count = mysqli_num_rows($data); // mysqli_num_rows 함수를 사용하여 댓글 숫자를 정수형태로 출력

           ?>

<!--페이지 인덱스 번호, 아이디, 날짜, 제목, 조회수 표시-->
            <tbody>
            <tr>
                <td width="70"><?php echo $board['idx']; ?></td>
                <!--글의 제목을 누르면 그 글의 인덱스 번호를 가져와 글을 읽을 수 있도록 링크를 걸어줌-->
           <!--    <td width="500"><a href="read.php?idx=--><?php /*//echo $board["idx"];*/?><!--">--><?php /*//echo $title;*/?></a></td> <!-- 글 잠금 구현 전 제목 표시할 때 쓰는 코드-->
                <td width="500"><?php
                $locking = "<img src='/images/lock.jpeg' alt='lock' title='lock' with='20' height='20' />"; // 자물쇠 아이콘 이미지
                if($board['lock_post']=="1") /*DB에 저장된 lock_post의 값이 1이면(게시글에 비밀번호가 있으면)*/
                { ?><a id="secret_post" href="javascript:void(0)" ><?php echo $title, $locking; /*글 제목과 자물쇠 아이콘 표시하고 글을 클릭할 경우 board_password_check.php로 이동하게 함*/
                    } else{  ?>
                    <a href='read.php?idx=<?php echo $board["idx"]; ?>'><?php echo $title; }?><span class="reply_count">[<?php echo $reply_count; ?>]</span>
                    </a></td> <!--아니라면(비밀번호가 없다면) 글을 읽을 수 있게 read.php로 이동하게 함-->

                    <td width="120"><?php echo $board['name']?></td> <!--아이디-->
                <td width="100"><?php echo $board['date']?></td> <!--글 쓴 날짜와 시간-->
                <td width="100"><?php echo $board['views']; ?></td> <!--조회수-->
            </tr>
            </tbody>
            <!--비밀글 클릭시 나타나는 패스워드 입력폼-->
            <div id='write_pass'>
                <form method="post"> <!-- action=""은 확인버튼을 누르면 현재페이지로 데이터가 전송되게 함-->
                    <input type="hidden" name="index" value="<?php echo $board['idx']; ?>">
                    <p>비밀번호<input type="password" name="password_check"> <input type="button" value="확인" onclick="passwordCheck()" /></p>
                </form>
            </div>

        <?php } ?>
    </table>
<!--페이지 하단의 숫자-->
        <div id="page_num">
            <ul>
                <?php
                /*처음 버튼*/
                if($page <= 1)
                { //만약 page가 1보다 작거나 같다면
                    echo "<li class='fo_re'>처음</li>"; //처음이라는 글자에 빨간색 표시
                }else{
                    echo "<li><a href='?page=1'>처음</a></li>"; // 아니라면 처음 글자를 누르면 1번페이지로 갈 수있게 링크
                }
                /*이전 버튼을 누를 경우*/
                if($page <= 1)
                { //만약 page가 1보다 작거나 같다면 빈값

                }else{ // page가 2 이상이면
                    $pre = $page-1; // pre변수에 page-1을 해준다 만약 현재 페이지가 3인데 이전버튼을 누르면 2번페이지로 갈 수 있게 함
                    echo "<li><a href='?page=$pre'>이전</a></li>"; // 이전글자에 pre변수를 링크한다. 이러면 이전버튼을 누를때마다 현재 페이지에서 -1하게 된다.
                }
                /*반복문으로 하단 숫자에 링크를 걸어 다른 페이지로 이동할 수 있게 한다.*/
                for($i=$block_start; $i<=$block_end; $i++){
                    //for문 반복문을 사용하여, 초기값을 블록의 시작번호를 조건으로 블록시작번호가 마지막 블록보다 작거나 같을 때까지 $i를 반복시킨다
                    if($page == $i){ // 만약 현재 page가 $i와 같다면
                        echo "<li class='fo_re'>[$i]</li>"; // 현재 페이지에 해당하는 번호에 굵은 빨간색을 적용한다
                    }else{
                        echo "<li><a href='?page=$i'>[$i]</a></li>"; //아니라면 현재 페이지 이외의 다른 페이지에 링크를 걸어 숫자를 눌렀을 때 다른 페이지로 이동할 수 있게 한다.
                    }
                }
                if($page >= $total_page){ //만약 현재 페이지가 마지막 페이지보다 크거나 같은 값이면 빈값(현재 페이지가 마지막 페이지이면 '다음' 글자가 뜨지 않게 함)
                }else{
                    $next = $page + 1; //next변수에 page + 1을 해준다.
                    echo "<li><a href='?page=$next'>다음</a></li>"; //다음글자에 next변수를 링크한다. 현재 4페이지에 있다면 +1하여 5페이지로 이동하게 된다.
                }
                if($page >= $total_page){ //만약 현재 page가 페이지수보다 크거나 같다면
                    echo "<li class='fo_re'>마지막</li>"; //마지막 글자에 긁은 빨간색을 적용한다.
                }else{
                    echo "<li><a href='?page=$total_page'>마지막</a></li>"; //아니라면 마지막글자에 total_page를 링크한다.
                }
                ?>
            </ul>
        </div>

    <div id="write_btn">
        <a href="write.php"><button>글쓰기</button></a>



    </div>
</div>
</div>
</body>
</html>
<?php
include "footer.html";
?>