<?php
const CLOSE = true;
ignore_user_abort(true);
set_time_limit(0);

/**
 * true - only production
 * false - only develop
 */
if(CLOSE) {
    ob_start();
    header("Content-Type: application/json", true);
    header("Connection: close", true);
    header("Content-Length: " . ob_get_length(), true);
    ob_end_flush();
    ob_flush();
    flush();
}

require_once "../vendor/autoload.php";
require_once "../factory/bootstrap/async.php";

$detector = new \Detector\Run();
$detector->make(function () {
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
});

$async = new AsyncServer();
$async->classLoader();
$async->run();
