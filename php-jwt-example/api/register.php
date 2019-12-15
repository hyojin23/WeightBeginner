<?php

// 에러 발생시 에러메세지 출력
error_reporting(E_ALL);
ini_set('display_errors', 1);

// db 연결
include_once './config/database.php';

header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$firstName = '';
$lastName = '';
$email = '';
$password = '';
$conn = null;

// db 사용
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

// PHP에서는 기본적으로 GET, POST 파라미터가 넘어오면 배열형태로 파싱하는데,
// 여기서는 넘어온 데이터를 배열로 파싱하기 전의 순수한 형태로 받아온다.
$data = json_decode(file_get_contents("php://input"));


$firstName = $data->first_name;
$lastName = $data->last_name;
$email = $data->email;
$password = $data->password;

$table_name = 'Users';

// insert문
$query = "INSERT INTO " . $table_name . "
                SET first_name = :firstname,
                    last_name = :lastname,
                    email = :email,
                    password = :password";

// 쿼리문 준비
$stmt = $conn->prepare($query);

// 변수를 파라미터와 연결
$stmt->bindParam(':firstname', $firstName);
$stmt->bindParam(':lastname', $lastName);
$stmt->bindParam(':email', $email);

$password_hash = password_hash($password, PASSWORD_BCRYPT);

$stmt->bindParam(':password', $password_hash);

// 실행되면
if($stmt->execute()){

    http_response_code(200);
    echo json_encode(array("message" => "User was successfully registered."));
}
else{
    http_response_code(400);

    echo json_encode(array("message" => "Unable to register the user."));
}
?>