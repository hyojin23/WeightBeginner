<?php

include $_SERVER['DOCUMENT_ROOT']."/db/dbd.php"; // db와 연결

$target_dir = "/usr/local/apache24/htdocs/uploads/"; // 이미지를 업로드할 파일 경로

// 경로 + 업로드한 이미지의 이름 ex) /usr/local/apache24/htdocs/uploads/Syntha_6_isolate.png
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// 업로드 하려고 올린 이미지 파일이 실제 이미지 파일인지 아닌지 검사한다.
if (isset($_POST["submit"])) { //
    // $_FILES["fileToUpload"]["tmp_name"] = tmp 폴더에 저장되는 이미지 파일의 임시 이름 getimagesize() : 이미지의 정보 출력하는 함수
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . "."; // $check["mime"] : 이미지의 확장자 ex) image/jpeg
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
//if (file_exists($target_file)) {
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
//}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
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
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

        /*database에 업로드 정보를 기록하자.
    - 파일이름(혹은 url)
    - 파일사이즈
    - 파일형식
    */
        $filename = $_FILES["fileToUpload"]["name"];
        $imgurl = "http://localhost/uploads/" . $_FILES["fileToUpload"]["name"];
        $size = $_FILES["fileToUpload"]["size"];

   //     include_once 'config.php';
//        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        //images 테이블에 이미지정보를 저장하자.
        $sql = mysql_q("insert into images(filename, imgurl, size) values('$filename','$imgurl','$size')");
//        mysqli_query($conn, $sql);
//        mysqli_close($conn);


        echo "<p>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.</p>";
        echo "<br><img src=/uploads/" . basename($_FILES["fileToUpload"]["name"]) . ">";
        echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
        echo $target_file;
    } else {
        echo "<p>Sorry, there was an error uploading your file.</p>";
        echo "<br><button type='button' onclick='history.back()'>돌아가기</button>";
        echo $_FILES["fileToUpload"]["tmp_name"];
        echo "안녕";
        echo $target_file;
    }
}
?>
