var mysql      = require('mysql');
// 비밀번호는 별도의 파일로 분리해서 버전관리에 포함시키지 않아야 합니다.
var connection = mysql.createConnection({
    host     : 'localhost',
    user     : 'hyojin',
    password : 'rlagywlsmyDB1030!',
    database : 'myDB'
});

connection.connect();

var game = "타이틀";
console.log(game);
var params = ['타이틀'];

var sql = 'INSERT INTO crawling_data (title) VALUES (?)';

connection.query(sql, params, function (error, results, fields) {
    if (error) {
        console.log(error);
    }
    console.log(results);
});

connection.end();