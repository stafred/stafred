<?php
final class AsyncEnv  extends \Stafred\Kernel\Enviroment
{
    public static function value(string $key)
    {
        // TODO: Implement value() method.
    }
}

final class AsyncServer
{

    /**
     * AsyncServer constructor.
     */
    public function __construct()
    {
        AsyncEnv::get();
        require_once "../bin/routes/async.php";
    }

    public function classLoader(): void
    {
        new \Stafred\Kernel\LoaderBuilder(true);
    }

    public function run()
    {

    }
}
