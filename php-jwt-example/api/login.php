
<?php

// 에러 내용 출력
error_reporting(E_ALL);
ini_set('display_errors', 1);

// db 연결, 라이브러리 사용
include_once './config/database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

// 헤더
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$email = '';
$password = '';

// db 사용
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();



$data = json_decode(file_get_contents("php://input"));

$email = $data->email;
$password = $data->password;

$table_name = 'Users';

// LIMIT 0,1 : 시작 인덱스: 0 표시할 행의 갯수: 1
$query = "SELECT id, first_name, last_name, password FROM " . $table_name . " WHERE email = ? LIMIT 0,1";

$stmt = $conn->prepare( $query );
$stmt->bindParam(1, $email);
$stmt->execute();
// 행의 갯수
$num = $stmt->rowCount();

// db에 행이 존재하면 (로그인시 입력한 아이디가 회원가입되어 있으면)
if($num > 0){
    // 배열 인덱스를 컬럼 이름으로 한 배열 생성
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // db에서 가져온 아이디
    $id = $row['id'];
    $firstname = $row['first_name'];
    $lastname = $row['last_name'];
    $password2 = $row['password'];

    // 입력된 비밀번호가 db에 저장된 비밀번호와 같다면
    if(password_verify($password, $password2))
    {
        // 토큰 비밀키. 비밀키를 인코딩하여 토큰을 만들고 디코딩한후 비밀키가 같은지 파악하여 토큰의 유효성 검사
        $secret_key = "dnqks1030@";
        $issuer_claim = "THE_ISSUER"; // this can be the servername 토큰 발급자
        $audience_claim = "THE_AUDIENCE"; // 토큰 대상자
        $issuedat_claim = time(); // issued at 토큰이 발급된 시간
        $notbefore_claim = $issuedat_claim + 10; //not before in seconds 토큰이 활성화되는 시간. 발행 후 10초 후 토른 활성화
        $expire_claim = $issuedat_claim + 600; // expire time in seconds 토큰이 만료되는 시간. 발행 후 600초 후 토큰 만료
        $token = array(
            "iss" => $issuer_claim,
            "aud" => $audience_claim,
            "iat" => $issuedat_claim,
            "nbf" => $notbefore_claim,
            "exp" => $expire_claim,
            "data" => array(
                "id" => $id,
                "firstname" => $firstname,
                "lastname" => $lastname,
                "email" => $email
            ));

        http_response_code(200);

        // 생성한 토큰과 비밀키를 인코딩한 후 jwt를 만들어 발급
        $jwt = JWT::encode($token, $secret_key);
        echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt,
                "email" => $email,
                "expireAt" => $expire_claim
            ));
    }
    else{

        http_response_code(401);
        echo json_encode(array("message" => "Login failed.", "password" => $password));
    }
}
?>