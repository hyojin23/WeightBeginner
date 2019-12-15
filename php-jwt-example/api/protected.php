<?php
// 에러 내용 출력
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once './config/database.php';
require "../../vendor/autoload.php";
use \Firebase\JWT\JWT;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$secret_key = "dnqks1030@";
$jwt = null;

// db 사용
$databaseService = new DatabaseService();
$conn = $databaseService->getConnection();

// 넘어온 데이터를 배열로 파싱하기 전의 순수한 형태로 받아옴
$data = json_decode(file_get_contents("php://input"));


$authHeader = $_SERVER['HTTP_AUTHORIZATION'];

// 디버깅용. $_SERVER 관련 배열 출력
//print_r($_SERVER);
//echo $authHeader;
//echo $_SERVER['PATH'];

// explode(): delimiter는 기준. 공백을 기준으로 문자열을 분할하여 배열로 저장
$arr = explode(" ", $authHeader);


/*echo json_encode(array(
    "message" => "sd" .$arr[1]
));*/

$jwt = $arr[1];
//$jwt = $authHeader;


if($jwt){

    try {
        // jwt와 비밀키를 사용해 디코딩
        $decoded = JWT::decode($jwt, $secret_key, array('HS256'));

        // 디버깅
        print_r($decoded);
        // stdClass Object를 배열로 바꿈
        $decoded_array = (array) $decoded;
        $a = $decoded_array["data"];
        $b= (array) $a;

//        print_r($a);
        echo $b["email"];
        // Access is granted. Add code of the operation here

        echo json_encode(array(
            "message" => "Access granted:",
//            "error" => $e->getMessage()
        ));

    }catch (Exception $e){

        http_response_code(401);

        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }

}
?>
