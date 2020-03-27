<?php
declare(strict_types=1);

require_once __DIR__.'/core/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use Rocket\Errors\Load as Error;
use Rocket\Errors\PageHandler;

$path = __DIR__.'/core/';
//error_reporting(E_ALL);

$environment = getenv("APP_ENV");

/**
* Register the error handler
*/
$error = new Error;
if ($environment !== 'production') {
    $error->pushHandler(new PageHandler);
} else {
    $error->pushHandler(function($e){
        echo 'Todo: Friendly error page and send an email to the developer';
    });
}
$error->register();

//throw new \Exception("cannot find sex");

$request = Request::createFromGlobals();
$app = new \Voom\Config\App();
$app->run($request);
?>