<?php
/**
 * Stafred Framework
 * @package  Stafred
 * @author   Stafred <stafred.framework@gmail.com>
 */

define("STAFRED_START", microtime(true));

/*
 > -------------------------------------------------
 >>>>>  Load App
 > -------------------------------------------------
 */
$app = require_once "../factory/bootstrap/app.php";
$app->autoload();
$app->debug();
///*
// > -------------------------------------------------
// >>>>>  Run The Application
// > -------------------------------------------------
// */
$app->run(
    \Stafred\Kernel\LoaderBuilder::class,
);
/*
 > -------------------------------------------------
 >>>>>  Getting A Time The Application
 > -------------------------------------------------
 */
$app->time();


