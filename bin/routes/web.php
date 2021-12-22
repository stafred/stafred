<?php

use Stafred\Utils\Route;

Route::group()->method('get')->add([
    \App\Controllers\IndexController::class => [
        '/' => 'index',
    ],
]);