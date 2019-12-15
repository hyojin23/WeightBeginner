<?php

$servername = "localhost";
$username = "root";
$password = "rlagywlsmyDB1030!";
$dbname = "myDB";

$name = $_POST['name']; // 이름
$id = $_POST['id']; // 아이디
$user_password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 비밀번호
$password_hint_value = $_POST['password_hint']; // 비밀번호 질문
$answer = $_POST['answer']; // 비밀번호 질문 답
$email = $_POST['email']; // email
$phone_number = $_POST['tel_first'].'-'.$_POST['tel_middle'].'-'.$_POST['tel_last']; // 전화번호
$check_email_value = $_POST['check_email']; // email 확인
$interest_value = $_POST['interest']; // 관심 분야
$how_long_work_out_value = $_POST['how_long_work_out']; // 운동 경력

// 입력된 값 확인
//echo $name;
//echo "<br>";
//echo $id;
//echo "<br>";
//echo $user_password;
//echo "<br>";
//echo $password_hint_value;
//echo "<br>";
//echo $answer;
//echo "<br>";
//echo $email;
//echo "<br>";
//echo $phone_number;
//echo "<br>";
//echo $check_email_value;
//echo "<br>";
//echo $interest_value;
//echo "<br>";
//echo $how_long_work_out_value;
//echo "<br>";

// 비밀번호 힌트 질문의 value값을 문자로 변환하는 함수
function password_hint_to_string($password_hint_value)
{
    switch ($password_hint_value) {
        case 30:
            $password_hint_char = "졸업한 초등학교 이름은?";
            return $password_hint_char;

        case 31 :
            $password_hint_char = "제일 친한 친구의 핸드폰 번호는?";
            return $password_hint_char;

        case 32 :
            $password_hint_char = "아버지 성함은?";
            return $password_hint_char;

        case 33 :
            $password_hint_char = "어머니 성함은?";
            return $password_hint_char;

        case 34 :
            $password_hint_char = "어릴 적 내 별명은?";
            return $password_hint_char;

        case 35 :
            $password_hint_char = "가장 아끼는 물건은?";
            return $password_hint_char;

        case 36 :
            $password_hint_char = "좋아하는 동물은?";
            return $password_hint_char;

        case 37 :
            $password_hint_char = "좋아하는 색깔은?";
            return $password_hint_char;


        case 38 :
            $password_hint_char = "좋아하는 음식은?";
            return $password_hint_char;

    }
}
$password_hint = password_hint_to_string($password_hint_value);

// 이메일/문자 수신 여부를 문자로 변환하는 함수
function check_email_receive($check_email_value)
{
    switch ($check_email_value) {
        case 0:
            $email_receive = "수신";
            return $email_receive;

        case 1 :
            $email_receive = "수신거부";
            return $email_receive;

    }
}
    $email_receive = check_email_receive($check_email_value);

    // 관심분야로 체크된 value를 문자로 변환하는 함수
    function interest_to_string($interest_value)
    {
        switch ($interest_value) {
            case 17:
                $interest = "운동 방법";
                return $interest;

            case 18 :
                $interest = "보충제 추천";
                return $interest;

            case 19 :
                $interest = "다이어트";
                return $interest;

            case 20 :
                $interest = "근육량 증가";
                return $interest;

        }
    }
    $interest = interest_to_string($interest_value);

// 운동기간을 물어보는 질문에 대한 value를 문자로 변환하는 함수
    function how_long_work_out_to_string($how_long_work_out_value)
    {
        switch ($how_long_work_out_value) {
            case 17:
                $work_out_experience = "운동 시작 전";
                return $work_out_experience;

            case 18 :
                $work_out_experience = "1~3개월";
                return $work_out_experience;

            case 19 :
                $work_out_experience = "3~6개월";
                return $work_out_experience;

            case 20 :
                $work_out_experience = "6~12개월";
                return $work_out_experience;
            case 21 :
                $work_out_experience = " 1년 이상";
                return $work_out_experience;

        }
    }
$work_out_experience = how_long_work_out_to_string($how_long_work_out_value);


// mysqli와 연결하는 객체
$conn = new mysqli($servername, $username, $password, $dbname);
// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO userInfo (name, id, user_password, password_hint, answer, email, phone_number, email_receive, interest, work_out_experience )
VALUES ('$name', '$id', '$user_password', '$password_hint', '$answer', '$email', '$phone_number', '$email_receive', '$interest', '$work_out_experience' )";

$conn->query($sql);

//// 연결 성공시와 실패시 메세지 출력
//if ($conn->query($sql) === TRUE) {
//    echo "New record created successfully";
//} else {
//    echo "Error: " . $sql . "<br>" . $conn->error;
//}

$conn->close();
?>
<!-- 회원가입 완료 메세지-->
<script>alert("회원가입이 완료되었습니다."); location.href="main_page.html"; </script>
