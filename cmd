#!/usr/bin/env php
<?php
define("AUTOLOAD", __DIR__ . '/vendor/autoload.php');

use Stafred\Kernel\Console;

if (file_exists(AUTOLOAD)) {
    require_once AUTOLOAD;
    echo Console::info()->start;

    Console::run();
} else {
    echo Console::info()->error;
}

echo Console::info()->close;