var createServer = require("auto-sni");
var express      = require("express");
var app          = express();

var greenlock = require('greenlock');
var gl = greenlock.create({
    configDir: '~/.config/acme'
    , store: require('greenlock-store-fs')

});

app.get('/', function (req, res) {
    res.send('hello world')
});



var server = createServer({
    email: "donny9292@naver.com", // Emailed when certificates expire.
    agreeTos: true, // Required for letsencrypt.
    debug: false, // Add console messages and uses staging LetsEncrypt server. (Disable in production)
    domains: ["weightbeginner.ga"], // List of accepted domain names. (You can use nested arrays to register bundles with LE).
    dir: "/etc/letsencrypt/live/weightbeginner.ga/", // Directory for storing certificates. Defaults to "~/letsencrypt/etc" if not present.
    ports: {
        // http: 80, // Optionally override the default http port.
        https: 3000 // // Optionally override the default https port.
    }
});

server.once("listening", ()=> {
    console.log("We are ready to go.");
});