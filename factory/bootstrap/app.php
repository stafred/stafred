<?php
/**
 * Stafred Framework
 * @package  Stafred
 * @author   Stafred <stafred.framework@gmail.com>
 */

/*******************************************************************/
/*******************************************************************/
/*******************************************************************/

interface IApp
{
    /*main error number of the web application.*/
    const ERROR_SERVER      = 500;
    const FORBIDDEN_SERVER  = 403;

    /*main application configuration for error handling.*/
    const ENV_DEBUG = 'APP_DEBUG_DISPLAY';
    const ENV_INFO  = 'ERROR_PAGE_INFO';
    const ENV_NAME  = 'ERROR_NAME_LOG';
    const ENV_PATH  = 'ERROR_PATH_LOG';
}

/*******************************************************************/
/*******************************************************************/
/*******************************************************************/

interface IAppMethods
{
    /*application methods interface.*/
    public function autoload(): void;

    public function debug(): void;

    public function run(...$loader): void;

    public function time(): void;
}

/**
 * Class AppHelper
 */
class AppHelper
{
    const AUTOLOAD = __DIR__ . '/../../vendor/autoload.php';

    const ENVIRONMENT = '../.env';

    protected $ENV_ALL = [];

    /**
     * @throws Exception
     */
    protected function _autoload()
    {
        if (!file_exists(self::AUTOLOAD)) {
            throw new Exception(
                "Autoload file not found.",
                IApp::FORBIDDEN_SERVER
            );
        }
        require_once self::AUTOLOAD;
    }

    /**
     * @param mixed $debug
     * @param mixed $info
     * @param mixed $name
     * @param mixed $path
     */
    protected function _debug($debug, $info, $name, $path)
    {
        $detector = new \Detector\Run();
        $detector->setErrorDebug($debug);
        $detector->setErrorInfo($info);
        $detector->setErrorNameLog($name);
        $detector->setErrorPathLog($path);
        $detector->make(function () {
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
        });
    }

    /**
     * @param mixed ...$loader
     */
    protected function _run(...$loader)
    {
        $loader = array_reduce($loader, 'array_merge', []);
        foreach ($loader as $key => $clazz) new $clazz;
    }

    /**
     * @display time
     */
    protected function _time()
    {
        if (APP_TIME_DISPLAY) {
            echo "<small>" . (microtime(true) - STAFRED_START) . "</small>";
        }
    }

    /**
     * @return mixed
     */
    protected function _env()
    {
        return require_once __DIR__ . '/env.php';
    }

    /**
     * @throws Exception
     */
    protected function openEnv()
    {
        try {
            if (!file_exists(self::ENVIRONMENT)) {
                throw new Exception(
                    "ENV file not found",
                    IApp::FORBIDDEN_SERVER
                );
            }
            $this->define();
            $this->inspector();
        } catch (Exception $e) {
            $detector = new \Detector\Run();
            $detector->exceptionHandler($e);
        }

    }

    /**
     * @param string $value
     * @return bool
     */
    protected function isDefined(string $value): bool
    {
        return defined($value);
    }

    /**
     * @return void
     */
    private function define()
    {
        $env = (array)parse_ini_file(
            self::ENVIRONMENT,
            true,
            INI_SCANNER_TYPED
        );
        foreach ($env as $section => $param) {
            foreach ($param as $key => $value) {
                $section = str_replace(".", "_", strtoupper($section));
                $key = str_replace(".", "_", strtoupper($key));
                define($section . '_' . $key, $value);
            }
        }
    }

    /**
     * @throws Exception
     */
    private function inspector()
    {
        $c = count($this->ENV_ALL);
        for ($i = 0; $i < $c; ++$i) {
            if (!defined($this->ENV_ALL[$i])) {
                throw new Exception(
                    $this->ENV_ALL[$i] . ": Environment variable not found",
                    IApp::FORBIDDEN_SERVER
                );
            }
        }

        if (!class_exists("ZipArchive")) {
            throw new Exception(
                "You dont have installed zip archive Please, install now!!!",
                IApp::FORBIDDEN_SERVER
            );
        }
    }

    /**
     * @return bool
     */
    private function isDevelopment(): bool
    {
        return defined("APP_DEVELOPMENT_ENABLE") ? APP_DEVELOPMENT_ENABLE : false;
    }
}

/**
 * Class App
 */
final class App extends AppHelper implements IApp, IAppMethods
{
    /**
     * App constructor.
     */
    public function __construct()
    {
        $this->ENV_ALL = $this->_env();
    }

    /**
     * @throws Exception
     */
    public function autoload(): void
    {
        parent::_autoload();
        $this->openEnv();
    }

    public function debug(): void
    {
        parent::_debug(
            self::ENV_DEBUG,
            self::ENV_INFO,
            self::ENV_NAME,
            self::ENV_PATH
        );
    }

    /**
     * @param mixed ...$loader
     */
    public function run(...$loader): void
    {
        parent::_run($loader);
    }

    public function time(): void
    {
        parent::_time();
    }

    /**
     * @param int $level
     */
    public function errorsReporting(int $level = 0){
        $level = $this->isDefined('ERROR_PAGE_REPORTING')
            ? constant('ERROR_PAGE_REPORTING')
            : $level;

        //error_reporting($level);
    }

    /**
     * @param int $level
     */
    public function errorsDisplay(int $level = 0){
        $level = $this->isDefined('ERROR_PAGE_DISPLAY')
            ?  constant('ERROR_PAGE_DISPLAY')
            : $level;
        //ini_set('display_errors', $level);
    }
}

return new App();