<?php
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html";
?>
    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>중고거래 게시글</title>
        <link rel="stylesheet" type="text/css" href="used_item_read.css?ver=2" />
        <link rel="stylesheet" href="header.css?ver=1"/>
        <link rel="stylesheet" href="footer.css?ver=1">
    </head>
    <body>
    <?php
    $index = $_GET['idx']; /* index변수에 게시글의 idx값을 받아와 넣음*/
    $views = mysqli_fetch_array(mysql_q("select * from gallery_board where idx ='".$index."'")); /*board 테이블의 해당 index의 행을 가져와 views 변수에 넣음*/
    $views = $views['views'] + 1; /*'views'를 키값으로 정해 해당 글의 조회수를 가져오고 +1을 하여 조회될 때마다 조회수가 늘어나게 함(페이지가 열릴 때마다 코드가 실행되어)*/
    $fet = mysql_q("update gallery_board set views = '".$views."' where idx = '".$index."'"); /*UPDATE [테이블] SET [열] = '변경할값' WHERE [조건]*/
    $sql = mysql_q("select * from gallery_board where idx='".$index."'"); /* 받아온 idx값을 조건으로 데이터를 가져옴 */
    $board = $sql->fetch_array(); /* $sql 변수에 저장된 데이터를 배열로 가져옴 */
    ?>

    <!-- 글 불러오기 -->
    <div id="board_read">
        <h2><?php echo $board['title']; ?></h2> <!--제목-->
        <div id="user_info">
            글쓴이: <?php echo $board['name']; ?> <?php echo "<br />"; ?>
            <div id="date">
                <?php echo $board['create_date']; ?> 조회수: <?php echo $board['views']; ?> <!--이름, 날짜, 조회수-->
            </div>
            <div id="bo_line"></div> <!-- 제목과 내용을 구분짓는 선-->
        </div>
        <div id="bo_content">
            <a href="#" class="image"><img src="<?php echo $board["image_url"] ?>" width="350" height="300" alt=""/></a>
            <?php echo nl2br("$board[content]"); ?> <!--글 내용-->
        </div>
        <?php
        /*글을 읽을 때 로그인이 되어있지 않다면 목록만, 로그인 되어 있다면 아이디가 글 작성자와 같은지 파악하여 목록, 수정, 삭제를 보여준다.*/
        if(!isset($_SESSION['session_id']) && !isset($_SESSION['admin_session_id'])) { // 세션 아이디가 존재하지 않는다면(로그인 안된 상태). if
            ?>
            <div id="bo_ser">
                <ul>
                    <li><a href="used_item_board.php">[목록으로]</a></li> <!--목록 메뉴만 보여준다.-->
                </ul>
            </div>
            <?php
            /*글을 쓴 아이디와 로그인한 아이다가 같다면 목록, 수정, 삭제 메뉴를 보여주고 다르다면 목록 메뉴만 보여준다.*/
        } else if(isset($_SESSION['admin_session_id']) || $_SESSION['session_id'] == $board['name'] ) { // 로그인한 세션 아이디와 글 작성자가 같다면. else if
            ?>
            <!-- 목록, 수정, 삭제 -->
            <div id="bo_ser">
                <ul>
                    <li><a href="used_item_board.php">[목록으로]</a></li>
                    <li><a href="used_item_modify.php?idx=<?php echo $board['idx']; ?>">[수정]</a></li>
                    <li><a href="used_item_delete.php?idx=<?php echo $board['idx']; ?>">[삭제]</a></li>
                    <!--jquery modal 사용 연습 코드-->
                    <!-- <li><a href="#modal" rel="modal:open">Open Modal</a></li>-->
                </ul>
            </div>
            <?php
        } else { // 로그인한 세션 아이디와 글 작성자가 다르다면. else
            ?>
            <div id="bo_ser">
                <ul>
                    <li><a href="used_item_board.php">[목록으로]</a></li>
                </ul>
            </div>
        <?php } ?> <!--else문 괄호 닫음-->
    </div>


    </body>

    </html>
<?php
include "footer.html";
?>