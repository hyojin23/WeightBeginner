<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="Generator" content="EditPlus®">
    <meta name="Author" content="">
    <meta name="Keywords" content="">
    <meta name="Description" content="">
    <title>Document</title>
</head>
<body>
<div style="width: 300px; margin:0 auto;">
    <h3>이미지 파일 업로드 연습</h3>

    <form action="upload.php" method="post" enctype="multipart/form-data">
        <div>
            <input type="file" name="fileToUpload" id="fileToUpload">
        </div>
        <input type="submit" value="업로드" name="submit" style="margin: .9em">
    </form>
</div>

<!-- database에서 이미지 목록을 가져 온다. -->
<ul>
    <?php
    include $_SERVER['DOCUMENT_ROOT']."/db/db.php"; // db와 연결
//    include_once 'config.php';
//    $conn = mysqli_connect(localhost, root, rlagywlsmyDB123!, myDB);
    if(mysqli_connect_errno()){
        echo "연결실패! ".mysqli_connect_error();
    }
    $query = "SELECT * FROM images"; // images 테이블에 저장된 이미지 정보를 불러오는 쿼리문
    $result = mysql_q($query); // 쿼리문 실행

    // images 테이블에 저장된 정보를 한 행씩 불러와 배열로 저장, 더 이상 불러올 행이 없으면 반복문 종료
    while($data = mysqli_fetch_array($result)){

        echo '<li style=\'float:left; margin: 2px;\'>';
        echo '<img src='.$data['imgurl'].' width=200><br>'; // 이미지 파일 경로를 통해 이미지를 보여줌
        echo ($data['filename']); // 이미지 파일 이름 출력
        echo '</li>';
    }

//    mysqli_close($conn);
    ?>

</ul>


</body>
</html>
