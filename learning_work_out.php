<?php
include "main_page.php"; // db와 연결. 세션 실행. 아이디 세션값이 존재할 경우 헤더에 환영문구와 로그아웃 글자를 표시하고 없을경우 로그인/회원가입 글자 표시
include "header.html";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>운동 배워봅시다</title>
    <script type="text/javascript" src="/crawling/crawling.js?ver=1"></script>
    <link rel="stylesheet" href="header.css?ver=1" />
    <link rel="stylesheet" href="footer.css?ver=1">
    <link rel="stylesheet" href="learning_work_out.css?ver=2" type="text/css">
</head>
<body>
<?php
// 현재 페이지인 http://localhost/learning_work_out.php(크롤링 데이터 있음)에 직접 url로 접근하려 할 경우 메인 페이지로 이동하게 만든다.
/*preg_match(): 이전 url($_SERVER['HTTP_REFERER'])에 현재 도메인($_SERVER['HTTP_HOST'], i는 대소문자 구분하지 않게 하는 옵션)이 포함되어 있는지 파악
ex) http://localhost/learning_work_out.php에 접속할 때 홈페이지 메인화면(http://localhost/main_page.html)을 거쳐 접속하면 이전 url인 http://localhost/main_page.html에
localhost가 포함되어 있어 !preg_match()는 false가 되어 조건문이 실행되지 않는다. 만약 메인 홈페이지 외 다른 곳에서 url을 직접 입력할 경우
!preg_match()는 true가 되어 조건문이 실행되고 main 페이지로 돌아간다.
*/
if(!preg_match("/".$_SERVER['HTTP_HOST']."/i",$_SERVER['HTTP_REFERER'])) {
    echo "<script>
window.location.replace('main_page.html');
</script>";
//exit('No direct access allowed');
}

if(isset($_GET['page'])){       // 처음 접속했을 경우 page는 1이고 나머지 경우 page는 선택한 페이지 값이다.
    $page = $_GET['page'];
}else{
    $page = 1;
}
$get_sql = mysql_q("select * from crawling_data"); // 크롤링 데이터를 가져옴
$row_num = mysqli_num_rows($get_sql); //크롤링 데이터 총 행의 수(=전체 크롤링 데이터 수)
$list = 10; //한 페이지에 보여줄 게시글 갯수
$block_ct = 10; //블록당 보여줄 페이지 개수( 한 블록당 보여줄 페이지 갯수를 5로 지정했으면 하단에 1 2 3 4 5 로 나오고 다음 블록이 되면 6 7 8 9 10 으로 나옴)

$block_num = ceil($page/$block_ct); // 현재 페이지가 몇 번째 블록인지 구함 , ceil = 소수점의 올림하는 함수
$block_start = (($block_num - 1) * $block_ct) + 1; // 블록의 시작번호 ex) 3블록이면 block_ct가 5일때 블록 시작번호는 11
$block_end = $block_start + $block_ct - 1; //블록 마지막 번호 ex) 3블록이면 block_ct가 5일때 블록 끝번호는 15

$total_page = ceil($row_num / $list); // 페이징한 페이지 수 구하기 ex) (총 게시글/한 페이지에 보여줄 게시글)의 소수점을 올림 = 페이징한 페이지수
if($block_end > $total_page) $block_end = $total_page; // 만약 블록의 마지막 번호가 페이지수보다 많다면 블록의 마지막 번호는 페이지 수랑 같게 함, 그렇지 않으면 게시글 없는 빈 페이지가 있을 수 있음
$total_block = ceil($total_page/$block_ct); // 블록 총 개수
$start_num = ($page-1) * $list; // DB에서 게시글을 구분하기 위한 게시글 시작번호. DB의 첫번째 게시글은 0번부터 시작함. (page-1)에서 $list를 곱한다.
?>


    <ul class="list_ul">
            <?php
            /* 한 페이지에 표시할 게시글의 수.
       인덱스 번호 기준 큰 수에서 작은 수로 내림차순 정렬하고 $start_num부터 $list 갯수만큼 데이터를 가져옴*/
$data = mysql_q("select * from crawling_data order by idx ASC limit $start_num, $list");
$count=0; // 이미지 파일명 구분을 위한 변수

while($board = $data->fetch_array()) // 한 행의 정보를 배열로 가져와 $board에 저장, 더 이상 가져올 데이터가 없을 때까지 계속 반복
{
    $title = $board["title"];
    $level = $board["level"];
    $title_url = $board["title_url"];
    $image = $board["image"];
  //  copy($image, "/tmp/local.jpg");]

    if (isset($image)) {
        // 이미지의 이름을 image0.jpg, image1.jpg 등으로 하여 웹서버에 저장한다.
        // 가상머신 localhost용 경로
//        copy($image, "/usr/local/apache24/htdocs/uploads/image".$count.".jpg");
        // weightbeginner.ga용 경로
        copy($image, "/var/www/html/uploads/image".$count.".jpg");
    }

    ?>

            <div class="list">
                <div class="image">
        <li><a href="https://terms.naver.com<?php echo $title_url ?>" target="_blank"> <!--클릭시 상세설명 페이지로 이동-->
            <img src="/uploads/image<?php echo $count ?>.jpg" width="200" height="200" alt="이미지 표시 불가"/></a></li> <!--이미지-->
                    <?php // echo $count ?>
        </div>
        <a href="https://terms.naver.com<?php echo $title_url ?>"><?php echo $title ?></a>
        </div>

<?php $count++; } ?>

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
    </ul>



</body>
</html>

<?php
include "footer.html";
?>

