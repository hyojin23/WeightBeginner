<?php

// db와 연결
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";
// 날짜를 변수로 저장. 시간으로 기록하고 싶으면 Y-m-d H:i:s
$date = date('Y-m-d H:i:s'); // 이 코드를 써서 시간을 넣으면 시간이 현재시간과 다르게 나옴. 그래서 DB에서 date의 기본값을 CURRENT TIMESTAMP로 바꿔 해결

// POST로 받아온 비밀번호를 암호화하여 변수에 저장
//$write_password = password_hash($_POST['write_password'], PASSWORD_DEFAULT);

//if(isset($_POST['lock'])){ // wirte.php에서 name=lock인 폼에 값이 존재하면(해당글을 잠급니다 체크할 경우) $lock_post 변수에 1 저장, 그렇지 않으면 0 저장
////    $lock_post = '1';
////}else{
////    $lock_post = '0';
////}

$initilize_idx = mysql_q("alter table gallery_board auto_increment =1"); //auto_increment 값 초기화

$target_dir = "/var/www/html/uploads/"; // 이미지를 업로드할 파일 경로

// 경로 + 업로드한 이미지의 이름 ex) /var/www/html/uploads/Syntha_6_isolate.png
$target_file = $target_dir . basename($_FILES["file_to_upload"]["name"]);
$uploadOk = 1;

echo $target_file;

// 해당 경로에 있는 파일의 확장자를 소문자로 치환한다.
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// 업로드 하려고 올린 이미지 파일이 실제 이미지 파일인지 아닌지 검사한다.
if (isset($_POST["submit"])) { //
    // $_FILES["file_to_upload"]["tmp_name"] = tmp 폴더에 저장되는 이미지 파일의 임시 이름 getimagesize() : 이미지의 정보 출력하는 함수
    $check = getimagesize($_FILES["file_to_upload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . "."; // $check["mime"] : 이미지의 확장자 ex) image/jpeg
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// 이미지가 업로드 되지 않는 이유를 출력해줌
// Check if file already exists
//if (file_exists($target_file)) {
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
//}
// Check file size
if ($_FILES["file_to_upload"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["file_to_upload"]["tmp_name"], $target_file)) {



        /*database에 업로드 정보를 기록
    - 파일이름(혹은 url)
    - 파일사이즈
    - 파일형식*/

        $file_name = $_FILES["file_to_upload"]["name"]; // 파일 이름
        $image_url = "http://weightbeginner.ga/uploads/" . $_FILES["file_to_upload"]["name"]; // url
        $image_size = $_FILES["file_to_upload"]["size"]; // 파일 크기

// insert into로 DB에 저장
// column에 default 값이 없을 경우 column을 적어주지 않으면 DB에 데이터가 들어가지 않으므로 주의. 터미널에서 직접 명령어 쳐봐서 에러메세지 확인할것
        $sql = mysql_q("insert into gallery_board(name, title, content, file_name, image_url, image_size,create_date,update_date) 
values('".$_POST['write_name']."','".$_POST['write_title']."','".$_POST['write_content']."','$file_name','$image_url','$image_size','" . $date . "','" . $date . "')");
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
    }
}
?>

<!--<script type="text/javascript">alert("등록되었습니다.");</script>-->
<!--글을 작성하면 글 목록 페이지로 이동-->
<!--<meta http-equiv="refresh" content="0 url=used_item_board.php" />-->