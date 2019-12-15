<?php
include $_SERVER['DOCUMENT_ROOT']."/db/db.php";
$date = date('Y-m-d H:i:s'); // 현재시각

$target_dir = "/var/www/html/uploads/"; // 이미지를 업로드할 파일 경로

// 경로 + 업로드한 이미지의 이름 ex) /var/www/html/uploads/Syntha_6_isolate.png
$target_file = $target_dir . basename($_FILES["file_to_upload"]["name"]);
$uploadOk = 1;

echo $target_file;

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
        $image_url = "http://localhost/uploads/" . $_FILES["file_to_upload"]["name"]; // url
        $image_size = $_FILES["file_to_upload"]["size"]; // 파일 크기

        $index = $_POST['idx']; // modify.php에서 hidden으로 넘긴 인덱스 번호
        $userpw = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
        $sql = mysql_q("update gallery_board set name='" . $_POST['name'] . "',title='" . $_POST['title'] . "',content='" . $_POST['content'] . "',file_name='$file_name'
 ,image_url='$image_url',image_size='$image_size' where idx='" . $index . "'");


    }
}
?>


<!--DB에 수정된 내용을 반영-->
<script type="text/javascript">alert("수정되었습니다.");</script>
<meta http-equiv="refresh" content="0; url=used_item_board.php" />


