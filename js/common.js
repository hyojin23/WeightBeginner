/*댓글 작성 버튼을 클릭하면 동작*/
$(document).ready(function () { //jquery 사용 준비
	$(".reply_button").click(function () { // reply_button 클래스를 클릭하면. $(): jquery 함수
		console.log("댓글 작성 버튼을 눌러서 common.js의 ajax 실행");
		var data = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
		// console.log($("form").serialize());
		$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
			type: 'post',
			url: 'reply_ok.php', // reply_ok.php에 요청(reply_ok.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
			data: data,
			dataType: 'html',
			success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
				$(".reply_view").remove(); // 원래 댓글페이지를 제거하고
				$("#read_body").append(data); // read.php 파일에서 댓글 부분이 이어붙어져 보이게 함
				// $(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
				// $(".reply_content").val(''); // reply_content는 빈칸이 됨
				//alert("성공!");
			},
			error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
				alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
			}

		});

	});


	/*read.php 페이지에서 댓글의 수정 버튼을 누를 경우 동작*/
	$(".dat_edit_bt").click(function () {
		console.log("댓글에서 수정 버튼을 눌렀습니다.");
		/* dat_edit_bt클래스 클릭시 동작(댓글 수정) */
		$('body').css("overflow", "hidden"); // 스크롤 고정시키는 코드 안해도 동작함
		 var obj = $(this).closest(".dap_lo").find(".dat_edit");
		console.log(obj);
		console.log(this);
		// var a = $('#reply_edit')
		// console.log(a);
		// console.log("안녕");
		obj.dialog({
			modal: true, // 뒷배경 어둡게 함
			width: 650,
			height: 240,
			title: "댓글 수정",
			position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정
			buttons: {
				'수정하기': function () {
					edit();
					$(this).dialog('close');

				}
			},
			// close 버튼을 누를 경우 ajax로 댓글 목록을 초기화시켜 다이얼로그를 닫은 뒤 수정 버튼을 눌러도 다이얼로그가 뜨지 않는 문제 해결
			close: function () {
				closeDialog()
			}
		});
		$('body').css("overflow", "scroll"); // 스크롤 고정을 푸는 코드
	});





	$(".reply_modify_button").click(function () { // reply_modify_button 클래스를 클릭하면. $(): jquery 함수
		console.log("다이얼로그에서 댓글 수정 버튼 누름ffff");
		var params = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
		$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
			type: 'post',
			url: 'reply_modify_ok.php', // reply_modify_ok.php에 요청(reply_modify_ok.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
			data: params,
			dataType: 'html',
			success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
				$(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
				$(".reply_content").val(''); // reply_content는 빈칸이 됨

			},
			error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
				alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
			}

		});

	});


// 댓글 삭제
// 	$(".dat_delete_bt").click(function () {
// 	// 확인버튼을 누를 경우 댓글 삭제함수 실행
// 	if (window.confirm('정말 삭제하시겠습니까?'))
// 	{
// 		replyDelete();
// 		// 취소버튼을 누를 경우 창 종료
// 	} else {
// 	}
// 	});

// 댓글 삭제
	$(".dat_delete_bt").click(function () {
		console.log("댓글에서 삭제 버튼을 눌렀습니다.");
		/* dat_edit_bt클래스 클릭시 동작(댓글 수정) */
		$('body').css("overflow", "hidden"); // 스크롤 고정시키는 코드 안해도 동작함
		var obj = $(this).closest(".dap_lo").find(".dat_delete");
		console.log(obj);
		console.log(this);
		obj.dialog({
			modal: true, // 뒷배경 어둡게 함
			width: 550,
			height: 180,
			title: "댓글 삭제",
			position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정
			buttons: {
				'삭제': function () {
					replyDelete();
					$(this).dialog('close');
				},
				'취소': function () {
					$(this).dialog('close');
				}
			},
			// close 버튼을 누를 경우 ajax로 댓글 목록을 초기화시켜 다이얼로그를 닫은 뒤 수정 버튼을 눌러도 다이얼로그가 뜨지 않는 문제 해결
			close: function () {
				closeDialog()
			}
		});
		$('body').css("overflow", "scroll"); // 스크롤 고정을 푸는 코드
	});




// 댓글 삭제
// 	$(".dat_delete_bt").click(function () {
// 		/* dat_delete_bt클래스 클릭시 동작(댓글 삭제) */
// 		var obj = $(this).closest(".dap_lo").find(".dat_delete");
// 		obj.dialog({
// 			modal: true,
// 			width: 400,
// 			title: "댓글 삭제확인"
// 		});
// 	});


	$("#secret_post").click(function () {
		console.log("비밀글 클릭시 common.js에서 dialog 실행");
		var secret = $("#write_pass");
		secret.dialog({
			modal: true,
			title: '비밀글입니다.',
			width: 400,
			// closeOnEscape: false, // ESC 눌렀을 때 dialog가 종료되지 않게 함(기본값은 true)
			// open: function (event, ui) {
			// 	$(".ui-dialog-titlebar-close", $(this).parent()).hide(); // dialog의 x버튼을 숨김
			// }
		});
	});

	// 댓글 블라인드
	// $(".reply_blind").click(function () {
	// 	console.log("블라인드 버튼을 눌렀습니다.");
	// 	/* dat_edit_bt클래스 클릭시 동작(댓글 수정) */
	// 	$('body').css("overflow", "hidden"); // 스크롤 고정시키는 코드 안해도 동작함
	// 	var obj = $(this).closest(".dap_lo").find(".dat_blind");
	// 	console.log(obj);
	// 	console.log(this);
	// 	obj.dialog({
	// 		modal: true, // 뒷배경 어둡게 함
	// 		width: 550,
	// 		height: 180,
	// 		title: "댓글 블라인드",
	// 		position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정
	// 		buttons: {
	// 			'블라인드': function () {
	// 				blind();
	// 				$(this).dialog('close');
	// 			},
	// 			'취소': function () {
	// 				$(this).dialog('close');
	// 			}
	// 		},
	// 		// close 버튼을 누를 경우 ajax로 댓글 목록을 초기화시켜 다이얼로그를 닫은 뒤 수정 버튼을 눌러도 다이얼로그가 뜨지 않는 문제 해결
	// 		close: function () {
	// 			var params = $("form").serialize();
	// 			console.log("common.js 파일의 close: function 실행");
	// 			$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
	// 				type: 'post',
	// 				url: 'dialog_close_reload.php', // dialog_close_reload.php에 요청(dialog_close_reload.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
	// 				data: params,
	// 				dataType: 'html',
	// 				success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
	// 					setTimeout(function () {
	// 						$(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
	// 						$(".reply_content").val(''); // reply_content는 빈칸이 됨
	// 					}, 100);
	// 				},
	// 				error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
	// 					alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
	// 				}
	// 			});
	// 		}
	// 	});
	// 	$('body').css("overflow", "scroll"); // 스크롤 고정을 푸는 코드
	// });


	// 댓글 블라인드
	$(".reply_blind").click(function () {
		var obj = $(this).closest(".dap_lo").find(".dat_blind");
		obj.dialog({
			modal: false,
			position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정
		});
		blind();
	});

	// 댓글 블라인드 해제
	$(".reply_blind_cancel").click(function () {
		var obj = $(this).closest(".dap_lo").find(".dat_blind");
		obj.dialog({
			modal: false,
			position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정
		});
		blindCancel();
	});

	// 메인 페이지에 있는 오늘의 운동 수정 다이얼로그
	$(".modify").click(function () {
		console.log("hey");
		var obj = $(".today_workout_modify");
		obj.dialog({
			modal: true,
			width: 550,
			height: 700,
			title: "오늘의 추천 운동",
			buttons: {
				'확인': function () {
					todayWorkOut();
					$(this).dialog('close');

					},

			}
		});

	});



	// $(".reply_blind").click(function () {
	// 	var obj = $(this).closest(".dap_lo").find(".dat_blind");
	// 	obj;
	// 	blind();
	// });


}); // $(document).ready 끝부분. jquery 사용을 위해서는 이 안에 함수를 넣어야 한다.

// 다이얼로그 종료 함수
function closeDialog() {
	var params = $("form").serialize();
	console.log("common.js 파일의 close: function 실행");
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
		type: 'post',
		url: 'dialog_close_reload.php', // dialog_close_reload.php에 요청(dialog_close_reload.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: params,
		dataType: 'html',
		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
			setTimeout(function () {
				console.log("closeDialog 성공!");
				$(".reply_view").remove(); // 원래 댓글페이지를 제거하고
				$("#read_body").append(data); // read.php 파일에서 댓글 부분이 이어붙어져 보이게 함
			}, 0);
		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}
	});
}

// 댓글 수정 함수
function edit() {
	console.log("다이얼로그에서 댓글 수정 버튼 누름");
	var edit = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
		type: 'post',
		url: 'reply_modify_ok.php', // reply_modify_ok.php에 요청(reply_modify_ok.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: edit,
		dataType: 'html',
		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
			// $(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
			// $(".reply_content").val(''); // reply_content는 빈칸이 됨


		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}

	});
}

// 댓글 삭제 함수
function replyDelete() {
	var obj = $(this).closest(".dap_lo").find(".dat_delete");
	var reply_delete = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
		type: 'post',
		url: 'reply_delete.php', // reply_modify_ok.php에 요청(reply_modify_ok.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: reply_delete,
		dataType: 'html',
		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
			// $(".reply_view").remove();
			// $("#read_body").append(data); // reply_view 클래스에 데이터를 넣어 보여줌
			// $(".reply_content").val(''); // reply_content는 빈칸이 됨


		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}

	});
}

// 댓글 블라인드 함수
function blind() {
	console.log("관리자가 블라인드 버튼 누름");
	var data = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
	// console.log(data);
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
		type: 'post',
		url: 'reply_blind.php', // reply_blind.php에 요청(reply_blind.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: data,
		dataType: 'html',
		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
			$(".reply_view").remove(); // 원래 댓글페이지를 제거하고
			$("#read_body").append(data); // read.php 파일에서 댓글 부분이 이어붙어져 보이게 함
			// $(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
			// $(".reply_content").val(''); // reply_content는 빈칸이 됨


		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}

	});
}

// 댓글 블라인드 해제 함수
function blindCancel() {
	console.log("관리자가 블라인드 해제 버튼 누름");
	var data = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
	// console.log(data);
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
		type: 'post',
		url: 'reply_blind_cancel.php', // reply_blind.php에 요청(reply_blind.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: data,
		dataType: 'html',
		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
			$(".reply_view").remove(); // 원래 댓글페이지를 제거하고
			$("#read_body").append(data); // read.php 파일에서 댓글 부분이 이어붙어져 보이게 함
			// $(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
			// $(".reply_content").val(''); // reply_content는 빈칸이 됨


		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}

	});
}

// 메인 페이지 오늘의 추천운동 데이터를 바꾸는 함수
function todayWorkOut() {
	console.log("todayWorkOut() 실행");
	var data = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)

	console.log(data);
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
		type: 'post',
		// aysnc: false,
		url: 'today_work_out.php', // today_work_out.php에 요청(today_work_out.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: data,
		dataType: 'html',
		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면 today_work_out.php의 코드를 인자로 받음(data는 today_work_out.php 코드가 실행된 결과물)
			console.log("성공!");
			$("#page").remove(); // 원래 main_page.html에 있던 #page태그의 값들을 제거
			// 원래 main_page.html에 있던 .today_workout_modify태그의 값들을 제거(제거하지 않으면 수정 후 다시 수정하기 버튼을 눌렀을 때 다이얼로그가 2개씩 뜨는 문제 발생)
			$(".today_workout_modify").remove();

			$("#page-wrapper").append(data); // #page-wrapper에 data를 이어 붙여 #page에 data가 보이게 함
			// 다이얼로그 입력폼에 써 넣은 값을 지움
			// $("#today_title").val('');
			// $("#youtube_url").val('');
			// $("#website_src").val('');
			// $("#today_content").val('');
		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}

	});
	console.log("11");
}


// function transferData() {
// 	var obj = $(this).closest(".dap_lo").find(".dat_delete");
// 	var reply_delete = $("#delete_form").serialize();
// 	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
// 		type: 'post',
// 		url: 'reply_delete.php', // reply_modify_ok.php에 요청(reply_modify_ok.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
// 		data: reply_delete,
// 		dataType: 'json',
// 		success: function (json) { // ajax가 서버에 보낸 요청이 성공하면
//
//
// 		},
// 		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
// 			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
// 		}
// 	});
//
// }



function passwordCheck() {
	console.log("passwordCheck 함수 실행");
	var form_data = $("form").serialize(); // HTML form 요소를 통해 입력된 데이터를 쿼리 문자열로 변환(직렬화)
	console.log($("form").serialize());
	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.

		type: 'post',
		url: 'board_password_check.php', // board_password_check.php에 요청(board_password_check.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
		data: form_data,
		dataType: 'html',
		success: function ($index) { // ajax가 서버에 보낸 요청이 성공하면
			// $(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
			// $(".reply_content").val(''); // reply_content는 빈칸이 됨]

				// location.href = "board_password_check.php"


//alert("성공")
		},
		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
		}

	});
}

// 로그인하지 않고 댓글 입력창을 클릭하면 발생하는 이벤트
function replyLoginCheck() {
	$('.reply_content').click(function () {
		// 확인버튼을 누를 경우 로그인페이지로 이동
		if (window.confirm('로그인이 필요한 서비스입니다. 로그인하시겠습니까?'))
		{
			window.location = "login_page.html";
			// 취소버튼을 누를 경우 창 종료
		} else {
		}
	});

}

function replyLoginCheckBtn() {
	$('.reply_button').click(function () {
		// 확인버튼을 누를 경우 로그인페이지로 이동
		if (window.confirm('로그인이 필요한 서비스입니다. 로그인하시겠습니까?'))
		{
			window.location = "login_page.html";
			// 취소버튼을 누를 경우 창 종료
		} else {
		}
	});
}

// function aaa() {
// 	$(".dat_edit_bt").click(function () {
// 		alert("수정 버튼 누름~~!!");
// 		console.log("댓글에서 수정 버튼을 눌렀습니다.");
// 		/* dat_edit_bt클래스 클릭시 동작(댓글 수정) */
// 		$('body').css("overflow", "hidden"); // 스크롤 고정시키는 코드 안해도 동작함
// 		var obj = $(this).closest(".dap_lo").find(".dat_edit");
// 		console.log(obj);
// 		console.log(this);
// 		// var a = $('#reply_edit')
// 		// console.log(a);
// 		// console.log("안녕");
// 		obj.dialog({
// 			modal: true, // 뒷배경 어둡게 함
// 			width: 650,
// 			height: 240,
// 			title: "댓글 수정",
// 			position: { my: "center", at: "center", of: ".dap_lo" }, // 위치 지정
// 			buttons: {
// 				'수정하기': function () {
// 					edit();
// 					//$(this).dialog('close');
//
// 				}
// 			},
// 			// close 버튼을 누를 경우 ajax로 댓글 목록을 초기화시켜 다이얼로그를 닫은 뒤 수정 버튼을 눌러도 다이얼로그가 뜨지 않는 문제 해결
// 			// close: function () {
// 			// 	var params = $("form").serialize();
// 			// 	console.log("common.js 파일의 close: function 실행ㅋㅋdd");
// 			// 	$.ajax({ // 이렇게 직렬화된 데이터를 ajax를 통해 서버에 한방에 보낼 수 있다.
// 			// 		type: 'post',
// 			// 		url: 'dialog_close_reload.php', // dialog_close_reload.php에 요청(dialog_close_reload.php의 코드가 ajax에서 보낸 데이터를 받아 실행됨)
// 			// 		data: params,
// 			// 		dataType: 'html',
// 			// 		success: function (data) { // ajax가 서버에 보낸 요청이 성공하면
// 			// 			setTimeout(function () {
// 			// 				$(".reply_view").html(data); // reply_view 클래스에 데이터를 넣어 보여줌
// 			// 				$(".reply_content").val(''); // reply_content는 빈칸이 됨
// 			// 			}, 100);
// 			// 		},
// 			// 		error: function (request, status, error) { // 에러 발생시 에러가 발생한 원인을 띄워줌
// 			// 			alert("code:" + request.status + "\n" + "message:" + request.responseText + "\n" + "error:" + error);
// 			// 		}
// 			// 	});
// 			// }
// 		});
// 		$('body').css("overflow", "scroll"); // 스크롤 고정을 푸는 코드
// 	});
// }



