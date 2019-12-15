// var userName = document.querySelector("#name");
// if (userName.value.length === 3) {
//     alert("zz");
// }
// // var userName = document.getElementsByName('mbname')[0].value;
// console.log(userName);
// //console.log(userName.length);
// var jb = $( 'input#name' ).val('aa');
// console.log(jb);
//
// if($("#email_option option:selected").val() == ""){
//     $("#last_email").val("");
//     $("#last_email").focus();
// } else if () P{

// console.log($("#email_option option:selected").val());
//  switch ($("#email_option option:selected").val()) {
//
//     case "":
//         $("#last_email").val("");
//         break;
//     case daum.net :
//         $("#last_email").val("daum.net");
//         break;
// }
console.log("dd")
// 아이디 중복 검사 함수
function checkid(){
    // 입력값을 변수에 저장
    var user_id = document.getElementById("id").value;
    //typeof user_id;
    //console.log(typeof user_id);
    if(user_id)
    {
        url = "check_id.php?user_id="+user_id;
        // url주소의 팝업창을 띄움
        window.open(url,"chkid","width=300,height=100");
    } else {
        alert("아이디를 입력해주세요");
    }
}

function checkz() {console.log("1")
    // var getIntro = $("#intro").val().replace(/\s|/gi,'');
    var hobbyCheck = false;
    var getMail = RegExp(/^[A-Za-z0-9_\.\-]+@[A-Za-z0-9\-]+\.[A-Za-z0-9\-]+/);
    var getPwCheck = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,16}$/; // 8~16자리 영문 대소문자,특수문자, 숫자
    var getCheck= RegExp(/^[a-zA-Z0-9]{4,12}$/); // 아이디 체크, 4~12자리 숫자와 영문 대소문자
    var getName= RegExp(/^[가-힣]+$/);
    var fmt = RegExp(/^\d{6}[1234]\d{6}$/); //형식 설정
    // var buf = new Array(13); //주민등록번호 배열

    //이름 공백 확인
    if($("#name").val() == ""){
        alert("이름을 입력해주세요");
        $("#name").focus();
        return false;
    }

    //이름 유효성
    if (!getName.test($("#name").val())) {
        alert("올바른 이름을 입력해주세요");
        $("#name").val("");
        $("#name").focus();
        return false;
    }

    // //주민번호
    // if(($("#first_register_number").val() == "") || ($("#last_register_number").val() == "")){
    //     alert("주민등록번호를 입력해주세요");
    //     $("#first_register_number").focus();
    //     return false;
    // }
    //
    // if(check_jumin() ==false){
    //     return false;
    // }

    //아이디 공백 확인
    if($("#id").val() == ""){console.log("2")
        alert("아이디를 입력해주세요");
        $("#id").focus();
        return false;
    }

    //아이디의 유효성 검사
    if(!getCheck.test($("#id").val())){
        alert("아이디 형식에 맞게 입력해주세요");
        $("#id").val("");
        $("#id").focus();
        return false;
    }

    //비밀번호 입력 안했을 경우
    if($("#password").val() == "") {
        alert("비밀번호를 입력해주세요");
        $("#password").focus();
        return false;
        console.log(checkz())
    }

    //비밀번호 형식이 틀렸을 경우
    if(!getPwCheck.test($("#password").val())) {
        alert("형식에 맞춰 비밀번호를 입력하세요");
        $("#password").val("");
        $("#password").focus();
        return false;
    }

    //아이디랑 비밀번호랑 같은지
    if ($("#id").val()==($("#password_confirm").val())) {
        alert("비밀번호가 ID와 같으면 안됩니다");
        $("#password").val("");
        $("#password").focus();
    }

    //비밀번호 똑같은지
    if($("#password").val() != ($("#password_confirm").val())){
        alert("비밀번호와 비밀번호 확인이 다릅니다");
        $("#password").val("");
        $("#cpass").val("");
        $("#password").focus();
        return false;
    }

    // 비밀번호 힌트/답변을 선택 안했을 경우
    if($("#password_hint option:selected" ).val() == ''){
        console.log("비밀번호 힌트 질문")
        alert("비밀번호 힌트 질문을 선택하세요");
        $("#password_hint").focus();
        return false;
    }

    // 비밀번호 힌트/답변을 선택 안했을 경우
    if($("#answer").val() == ""){
        console.log("비밀번호 힌트/답변")
        alert("비밀번호 힌트 답변을 선택하세요");
        $("#answer").focus();
        return false;
    }

    //이메일 공백 확인
    if($("#first_email").val() == "" || $("#last_email").val() == "" ) {
        alert("이메일을 입력해주세요");
        $("#first_email").focus();
        return false;
    }

    //이메일 유효성 검사
    if(!getMail.test($("#email").val())){
        alert("이메일형식에 맞게 입력해주세요")
        $("#email").val("");
        $("#email").focus();
        return false;
    }



    // //관심분야
    // for(var i=0;i<$('[name="hobby[]"]').length;i++){
    //     if($('input:checkbox[name="hobby[]"]').eq(i).is(":checked") == true) {
    //         hobbyCheck = true;
    //         break;
    //     }
    // }
    //
    // if(!hobbyCheck){
    //     alert("하나이상 관심분야를 체크해 주세요");
    //     return false;
    // }

    // //자기소개란 유효성 검사
    // //공백이 있다면 안됨.
    // if(getIntro==""){
    //     alert("자기소개를 입력해주세요");
    //     $("#intro").val("");
    //     $("#intro").focus();
    //     return false;
    // }

    return true;
}

// //주민번호 확인 함수
// function check_jumin() {
//     var jumins3 = $("#first_register_number").val() + $("#last_register_number").val();
//     //주민등록번호 생년월일 전달
//
//     var fmt = RegExp(/^\d{6}[1234]\d{6}$/)  //포멧 설정
//     var buf = new Array(13);
//
//     //주민번호 유효성 검사
//     if (!fmt.test(jumins3)) {
//         alert("주민등록번호 형식에 맞게 입력해주세요");
//         $("#first_register_number").focus();
//         return false;
//     }
//
//     //주민번호 존재 검사
//     for (var i = 0; i < buf.length; i++){
//         buf[i] = parseInt(jumins3.charAt(i));
//     }
//
//     var multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];// 밑에 더해주는 12자리 숫자들
//     var sum = 0;
//
//     for (var i = 0; i < 12; i++){
//         sum += (buf[i] *= multipliers[i]);// 배열끼리12번 돌면서
//     }
//
//     if ((11 - (sum % 11)) % 10 != buf[12]) {
//         alert("잘못된 주민등록번호 입니다.");
//         $("#first_register_number").focus();
//         return false;
//     }
//
//     var birthYear = (jumins3.charAt(6) <= "2") ? "19" : "20";
//     birthYear += $("#first_register_number").val().substr(0, 2);
//     var birthMonth = $("#first_register_number").val().substr(2, 2);
//     var birthDate = $("#first_register_number").val().substr(4, 2);
//     var birth = new Date(birthYear, birthMonth, birthDate);
//
//
//     // $("#year").val(birthYear);
//     // $("#month").val(birthMonth);
//     // $("#day").val(birthDate);
//
// }

