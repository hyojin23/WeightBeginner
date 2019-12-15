var mysql = require('mysql');
var connection = mysql.createConnection({
    host: 'localhost',
    user: 'hyojin',
    password: 'rlagywlsmyDB1030!',
    database: 'myDB',
});
connection.connect();

const axios = require("axios"); // axios 모듈 사용준비
const cheerio = require("cheerio"); // cheerio 모듈 사용준비
const log = console.log;

for (var i = 1; i < 18; i++) {
    const getHtml = async () => { // async / await 구문: 비동기 처리를 위해 사용,  getHtml()에서 async () 함수를 호출한다
        try {

            console.log("반복문" + i);
            return await axios.get("https://terms.naver.com/list.nhn?cid=51030&categoryId=51030&page=" + i); // axios.get() : get 방식으로 데이터 요청

        } catch (error) {
            console.error(error); // 에러 발생시 에레내용 출력
        }
    };

    // getHtml()
    //         .then(html => {
    //             let ulList = []; // 배열 변수
    //             const $ = cheerio.load(html.data); //  인자로 html 문자열을 받아 cheerio 객체를 반환
    //             const $bodyList = $("div#content").children("div.model_group_new");
    //
    //             $bodyList.each(function (i, elem) {
    //                 ulList[i] = {
    //                     title: $(this).find('div.sum a').attr('href'), // <strong class="news-tl"> 의 text내용
    //                   //  text: $(this).find('div.related span.info').text(),
    //                     //level: $(this).find('div.iner em.data').text(),
    //                    // title_url: $(this).find('strong.title a').attr('href'), // <p class="poto"> img 태그의 src 속성 내용
    //                    // image: $(this).find('div.thumb_area a img').attr('data-src'), // <p class="poto"> img 태그의 alt 속성 내용
    //
    //                 };
    //             });


// 네이버 크롤링 8월 7일
    getHtml()
        .then(html => {
            let ulList = []; // 배열 변수
            const $ = cheerio.load(html.data); //  인자로 html 문자열을 받아 cheerio 객체를 반환
            const $bodyList = $("ul.content_list").children("li");

            $bodyList.each(function (i, elem) {
                ulList[i] = {
                    title: $(this).find('strong.title a').text(), // <strong class="news-tl"> 의 text내용
                    text: $(this).find('div.related span.info').text(),
                    level: $(this).find('div.iner em.data').text(),
                    title_url: $(this).find('strong.title a').attr('href'), // <p class="poto"> img 태그의 src 속성 내용
                    image: $(this).find('div.thumb_area a img').attr('data-src'), // <p class="poto"> img 태그의 alt 속성 내용

                };
            });
// 반복문 8월 7일
            for (var i = 0; i < ulList.length; i++) {
                var raw_title = ulList[i].title;
                var title = raw_title.replace('담기', '');
                var level = ulList[i].level;
                var title_url = ulList[i].title_url;
                var image = ulList[i].image;
                let params = [title, level, title_url, image];
                //console.log(ulList.length);
                var sql = 'INSERT INTO crawling_data (title, level, title_url, image) VALUES (?,?,?,?)';


                connection.query(sql, params, function (error, results, fields) {
                    if (error) {
                        console.log(error);
                    }
                    console.log(results);
                });


                //console.log(title);
                //console.log(level);


                // var sql = 'INSERT INTO crawling_data (title) values (a)';
                // connection.query(sql, function (error, results, fields) {
                //     if (error) {
                //         console.log(error);
                //     }
                //     console.log(results);
                // });

            }   // 반복문 8월 7일


            //  console.log(b[0][0]);

            // 8월 7일
            // var sql_query = 'SELECT * FROM crawling_data';
            // connection.query(sql_query, function(err, rows, fields){
            //     if(err){
            //         console.log(err);
            //     } else {
            //         for(var i=0; i<rows.length; i++){
            //            // console.log(rows[i].title);
            //         }
            //     }
            // });


            //  console.log(ulList[1].level);
            //   console.log(ulList[1].text);
            //  console.log(ulList[1].title_url);
            // console.log(ulList[1].image_src);


            //  console.log(ulList[1].title);
            //  console.log(ulList[1].level);
            const data = ulList.filter(n => n.title);
            //    console.log("데이터:" + JSON.stringify(data));
            return data;
        })


}  // 반복문 종료 8월 7일





//         .then(res => log(res));
// }


// var a = getHtml();
// var obj = JSON.parse(a);
//  console.log("이미지: " + obj.image_src);






// getHtml()
//     .then(html => {
//         let ulList = []; // 배열 변수
//         const $ = cheerio.load(html.data); //  인자로 html 문자열을 받아 cheerio 객체를 반환
//         const $bodyList = $("div.headline-list ul").children("li.section02");
//
//         $bodyList.each(function(i, elem) {
//             ulList[i] = {
//                 title: $(this).find('strong.news-tl a').text(), // <strong class="news-tl"> 의 text내용
//                 url: $(this).find('strong.news-tl a').attr('href'), // <strong class="news-tl"> 의 a 태그의 href 속성 내용
//                 image_url: $(this).find('p.poto a img').attr('src'), // <p class="poto"> img 태그의 src 속성 내용
//                 image_alt: $(this).find('p.poto a img').attr('alt'), // <p class="poto"> img 태그의 alt 속성 내용
//                 summary: $(this).find('p.lead').text().slice(0, -11), // <p class="lead"> text 내용
//                 date: $(this).find('span.p-time').text() // <span class="p-time">의 text 내용
//             };
//         });
//
//         const data = ulList.filter(n => n.title);
//         return data;
//     })
//     .then(res => log(res));