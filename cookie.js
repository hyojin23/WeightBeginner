 // setCookie();
// getCookie();

// 쿠키를 설정한다.
function setCookie(name, value, hour)
{
    var today_date = new Date(); // 현재 시간과 날짜를 반환하는 객체 생성
    console.log(today_date);
    today_date.setTime(today_date.getTime()+hour*60*60*1000); // 현재 날짜를 기준으로 하루 뒤를 today_date로 설정 (1000=1초)

    // 날짜로 하려면 이것 사용
    // today_date.setDate(today_date.getTime()+1); // 현재 날짜를 기준으로 하루 뒤를 today_date로 설정

    console.log(today_date);
    console.log(today_date.toUTCString());
    document.cookie = name+ "=" + escape( value ) + "; path=/; expires=" +   today_date.toUTCString() + ";"; // 쿠키의 이름, 경로, 만료날짜 설정
}

// 팝업창의 24시간 동안 열지 않기를 체크할 경우 동작하게 할 함수
function closeWin()
{
    console.log($("#popup_check").is(":checked")); // popup.html의 체크박스가 체크되었는지 확인(jquery)
    if ($("#popup_check").is(":checked") ) // popup.html의 체크박스가 체크되었으면
    {
        setCookie("popup_stop", "check", 24); // 쿠키의 이름(key값)과 value값, 시간 설정
        window.close(); // 팝업창 닫음
    }
}

/*document.cookie는 key-value 값 쌍으로 이루어진 json처럼 name-value 값 쌍으로 이루어진 String이다. (총 쿠키를 이어붙인 String)
* ex) document.cookie === "someKey=aCookieMadeMeHaveValue7;anotherKey=aShorterValue"
* 여기서는 getCookie(name) 함수의 인자로 name값을 넣어 원하는 value를 가져올 수 있다.
*/
function getCookie(name) {
    var Found = false;
    var start, end;
    var i = 0;

    while(i <= document.cookie.length) {  // document.cookie.length는 총 쿠키의 길이
        start = i;
        end = start + name.length; // name으로 지정한 값이 poptup_stop이면 name.length는 10이므로 처음 start=0, end=10
        console.log(name.length);
     /*    substring()으로 인덱스번호가 0번째 이상부터 10번째 미만인 문자열을 추출한다.
     왜 추출을 해야하는지 적기
           두번째 반복문에서는 1번째 이상 11번째 미만 추출,
           세번째 반복문에서는 2번째 이상 12번째 미만 추출 이런식으로 name과 같은 문자열이 있는지 비교하기 위해
           총 쿠키에서 name의 길이만큼 문자를 추출한다.
         Var fruit = "apple", fruit.substring(0,3)="app"*/
        if(document.cookie.substring(start, end) == name) {  // 추출한 문자열이 name(여기서는 popup_stop)과 같다면
            Found = true;
            break
        }
        i++
    }
/* function getCookie(name)에서는 인자로 들어온 name을 찾았다면 이제는 name에 맞는 value값을 추출한다.
* */
    if(Found == true) {
        /* 찾은 name에 해당하는 value값을 구하기 위해 name 인덱스에 1을 더해 value의 시작 인덱스를 정한다.
       * ex) document.cookie === "someKey=aCookieMadeMeHaveValue7;anotherKey=aShorterValue" 에서 someKey를 추출하기 위한
       * start = 0 , end = 7 이므로 value 값인 aCookieMadeMeHaveValue7 를 추출하려면 start = 8 이 되어야함
       * */
        start = end + 1;
        end = document.cookie.indexOf(";", start); // start를 시작점으로 document.cookie 문자열에서 ;가 들어간 인덱스를 찾는다(없으면 -1이 반환됨)
        if(end < start)
  /*        end < start 인 경우는 end가 -1인 경우이다. 즉 이 경우는 총 쿠키인 document.cookie에서 ;가 없다는 말이고
            쿠키값이 여러개가 존재할 경우 구분짓기 위해 사용하는 ;가 없다는 것은 쿠키값이 하나만 존재한다는 말이다.*/

        /*쿠키값이 하나만 존재하므로 value값을 추출하기 위한 끝 인덱스번호는 총쿠키의 길이와 같다.
        * document.cookie="fruit=apple" 이면 document.cookie.length=11, apple을 추출하기 위한 start = 6 ,end = 11 */
            end = document.cookie.length;
        return document.cookie.substring(start, end) // 얻은 value값 반환
    }
    return "" // Found = false 일 경우(getCookie 함수에 인자로 들어온 name과 같은 name값이 없을 경우, 즉 쿠키가 존재하지 않을 경우에서 공백을 반환한다.)
}