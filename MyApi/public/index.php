<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

error_reporting(E_ALL);

ini_set("display_errors", 1);



//$app = new \Slim\Slim();
//$app->error(function (\Exception $e) use ($app) {
//    $app->render('error.php');
//});

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/hello/{name}', function (Request $request, Response $response, array $args) {
    $name = $args['name'];
    $response->getBody()->write("Hello, $name");
    return $response;
});

//var_dump($_SERVER);

$app->run();

//// Redirect HTTP traffic to HTTPS
//$app->add(function (Request $request, Response $response, $next) {
//    $uri = $request->getUri();
//    if($uri->getScheme() !== 'https') {
//        // Map http to https
//        $httpsUrl = $uri->withScheme('https')->withPort(443)->__toString();
//
//        // Redirect to HTTPS Url
//        return $response->withRedirect($httpsUrl);
//    }
//
//    return $next($request, $response);
//});


//use Psr\Http\Message\ResponseInterface as Response;
//use Psr\Http\Message\ServerRequestInterface as Request;
//use Slim\Factory\AppFactory;
//
//require __DIR__ . '/../vendor/autoload.php';
//
///**
// * Instantiate App
// *
// * In order for the factory to work you need to ensure you have installed
// * a supported PSR-7 implementation of your choice e.g.: Slim PSR-7 and a supported
// * ServerRequest creator (included with Slim PSR-7)
// */
//$app = AppFactory::create();
//
//// Add Routing Middleware
//$app->addRoutingMiddleware();
//
///*
// * Add Error Handling Middleware
// *
// * @param bool $displayErrorDetails -> Should be set to false in production
// * @param bool $logErrors -> Parameter is passed to the default ErrorHandler
// * @param bool $logErrorDetails -> Display error details in error log
// * which can be replaced by a callable of your choice.
//
// * Note: This middleware should be added last. It will not handle any exceptions/errors
// * for middleware added after it.
// */
//$errorMiddleware = $app->addErrorMiddleware(true, true, true);
//
//// Define app routes
//$app->get('/hello/{name}', function (Request $request, Response $response, $args) {
//    $name = $args['name'];
//    $response->getBody()->write("Hello, $name");
//    return $response;
//});
//
//// Run app
//$app->run();