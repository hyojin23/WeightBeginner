// server.js

// var express = require('express');  // require('express'): 설치한 express module을 불러와서 변수(express)에 담음
// var app = express(); // express를 실행하여 app object를 초기화함

// socket.io와 express가 직접 연결될 수 없기 때문에  app를 http에 연결시키고, 이 http를 다시 socket.io에 연결해야함
// var http = require('http').Server(app);
// const https = require('https');
const fs = require('fs');
// var io = require('socket.io')(https);

// 서버에 https 적용을 위한 let's encrypt key 파일 경로
const options = {
    key: fs.readFileSync('/etc/letsencrypt/live/weightbeginner.ga/privkey.pem'),
    cert: fs.readFileSync('/etc/letsencrypt/live/weightbeginner.ga/fullchain.pem')
};

// express 모듈을 불러오고 실행
var express = require('express');
var app = express();

// https 서버를 만들고 socket.io와 연결
    server = require('https').createServer(options, app);
    io = require('socket.io').listen(server);

    // 서버 실행시 로그 출력
server.listen(8000, function () {
    console.log("server on!");
});



// 모든 request는 client.html를 response하도록 설정(요청에 대한 응답으로 client.html를 실행)
// __dirname: 현재 파일의 경로(/usr/local/apache24/htdocs/chatting)
app.get('/',function(req, res){
    res.sendFile(__dirname + '/client.html');
});
app.use(express.static(__dirname )); // 이미지, css, js과 같은 정적파일을 html 문서와 연결하기 위해 기본경로를 지정

/*사용자가 웹사이트에 접속하면 socket.io에 의해 'connection' event가 자동으로 발생
 io.on(EVENT,함수)는 서버에 전달된 EVENT를 인식하여 함수를 실행시키는 event listener
 함수에는 접속한 사용자의 socket이 인자로 전달되므로 해당 접속자(socket)에 대한 event들은 이 'connection' event listener 안에 작성되어야 합*/
var count=1;
io.on('connection', function(socket){ //

    // 다이얼로그에 닉네임을 입력하고 확인 버튼을 누르면 발생.(connection event의 listener)
    socket.on('connection', function(user_name){
        console.log('user_name: ', user_name ); // 유저가 입력한 닉네임을 로그로 출력
        var name = user_name; // name을 유저가 입력한 닉네임으로 함
        io.to(socket.id).emit('change name',name);   // change name 이벤트를 io.to(socket.id).emit 함수로 전달하여 client.html의 해당 event listener에서 처리되게함
        io.emit('alert name', name);
    });

    console.log('user connected: ', socket.id);  // user connected: NxruXYBvEeC6zfAwAAAA 이런식으로 socket.id는 알아볼 수 없게 나옴
   // var name = "user" + count++;                 // name = user1, user2 이런식으로 나오게 한다

   // io.to(socket.id).emit('change name',name);   // 해당 소켓에 이벤트를 io.to(socket.id).emit 함수로 전달하여 client.html의 해당 event listener에서 처리되게함

    socket.on('disconnect', function(){ // socket.on(EVENT,함수)은 해당 socket에 전달된 EVENT를 인식하여 함수를 실행시키는 event listener.
        console.log('user disconnected: ', socket.id); // 접속자의 접속이 해제될 경우 로그로 해당 아이디를 보여줌
    });

    socket.on('send message', function(name,text){ // 'send message' 이벤트의 event listener. 접속자가 채팅메세지를 전송할 때 발생한다.
        var msg = name + ' : ' + text;
        console.log(msg); // 유저 이름과 채팅메세지를 로그로 보여줌
        io.emit('receive message', msg); // io.emit() 함수로 모든 클라이언트들에게 event 전달

    });
});

// http.listen(3000, function(){ // 서버 실행시 server on! 로그 보여줌
//     console.log('server on!');
// });

// https.createServer(options, app).listen(8000, function() {
//     console.log("Https server listening on port 8000");
// });
