<?php
ignore_user_abort(true);
set_time_limit(0);

ob_start();
echo "OK";

header("Connection: close", true);
header("Content-Type: application/json", true);
header("Content-Length: " . ob_get_length(), true);

ob_end_flush();
ob_flush();
flush();

require_once "../vendor/autoload.php";

use Stafred\Async\Server\Handler as AsyncHandler;
use Stafred\Async\Server\Request as AsyncRequest;

$handler = new AsyncHandler(
    new AsyncRequest()
);

$handler->run();
