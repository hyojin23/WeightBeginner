<meta charset="utf-8" />
<?php
include "db/db.php";
//include "password.php";

//POST로 받아온 아이다와 비밀번호가 비어있으면 알림창을 띄우고 전 페이지로 돌아감
if($_POST["login_id"] == "" || $_POST["login_password"] == ""){
    echo '<script> alert("아이디나 패스워드 입력하세요"); history.go(-1); </script>';
}else{

    //password변수에 POST로 받아온 값을 저장
    $password = $_POST['login_password']; // 로그인창에 입력한 패스워드
    $id = $_POST['login_id']; // 로그인창에 입력이 아이디
    // sql문으로 POST로 받아온 아이디값이 있는 데이터를 검색
    $sql = mysql_q("select * from userInfo where id='$id'");
    // fetch_array() 함수로 db에 있는 데이터를 php에서 쓸 수 있는 배열로 가져옴
    $login_id_info = $sql->fetch_array(); // 로그인한 아이디의 유저 정보

    $hash_password = $login_id_info['user_password']; //$hash_password에 로그인 시도한 아이디의 row에 있는 해쉬 비밀번호를 저장

    //    var_export($userInfo);
    //    echo $hash_pw;
    //    echo $password;

    //만약 password변수와 hash_password 변수가 같다면 세션값을 저장하고 알림창을 띄운후 main.php파일로 넘어감 (login_id_info['isAdmin'] == 1 이면 일반 유저)
    if(password_verify($password, $hash_password) && $login_id_info['isAdmin'] == 1 )
    {
        $_SESSION['session_id'] = $login_id_info["id"];
        $_SESSION['session_password'] = $login_id_info["user_password"];

        echo "<script>alert('로그인되었습니다.'); history.go(-2); </script>";
    } else if (password_verify($password, $hash_password) && $login_id_info['isAdmin'] == 0 ) { // login_id_info['isAdmin'] == 0 이면 관리자
        $_SESSION['admin_session_id'] = $login_id_info["id"];
        $_SESSION['admin_session_password'] = $login_id_info["user_password"];
        echo "<script>alert('관리자로 로그인되었습니다.'); history.go(-2); </script>";
    } else{
        // 비밀번호가 같지 않다면 알림창을 띄우고 로그인 페이지로 돌아감
        echo "<script>alert('아이디 혹은 비밀번호를 확인하세요.'); history.go(-1);</script>";
    }
}
?>

