function removeCheck() {
    if (confirm("정말 삭제하시겠습니까??") == true){    //확인
        document.removefrm.submit();
    }else{   //취소
        return false;
    }
}
var delete_post = document.getElementById("delete").onclick;
delete_post.onclick = removeCheck();
