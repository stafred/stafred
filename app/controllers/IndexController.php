<?php

namespace App\Controllers;

use Stafred\Utils\Request;

/**
 * Class IndexController
 * @package App\controllers
 */
final class IndexController
{
    /**
     * @return String|NULL
     * @throws \Exception
     */
    public function pageGet()
    {
        return view('index')->return();
    }
}