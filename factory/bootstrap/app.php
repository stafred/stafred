<?php
/**
 * Stafred Framework
 * @package  Stafred
 * @author   Stafred <stafred.framework@gmail.com>
 */

/**
 * Interface IApp
 */
interface IApp
{
    const AUTOLOAD = __DIR__ . '/../../vendor/autoload.php';

    const ENVIRONMENT = '../.env';

    const ERROR_SERVER = 500;

    const ENV = [
        'APP_DEBUG',
        'APP_TIME_DISPLAY',
        'ERROR_INFO',
        'ERROR_LOG',
        'ERROR_DISPLAY',
        'ERROR_REPORTING',
        'ERROR_NAME_LOG',
        'ERROR_PATH_LOG',
    ];

    public function autoload();

    public function debug();

    public function run(...$loader);

    public function time();
}

/**
 * Class AppHelper
 */
class AppHelper
{
    /**
     * @throws Exception
     */
    protected function _autoload()
    {
        if (!file_exists(IApp::AUTOLOAD)) {
            throw new Exception("Autoload file not found.", 500);
        }
        require_once IApp::AUTOLOAD;
    }

    protected function _debug()
    {
        $detector = new \Detector\Run;
        $detector->setErrorDebug('APP_DEBUG');
        $detector->setErrorInfo('ERROR_INFO');
        $detector->setErrorNameLog('ERROR_NAME_LOG');
        $detector->setErrorPathLog('ERROR_PATH_LOG');
        $detector->make(function(){
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
     * @throws Exception
     */
    protected function openEnv()
    {
        if (!file_exists(IApp::ENVIRONMENT)) {
            throw new Exception(
                "ENV file not found",
                IApp::ERROR_SERVER
            );
        }

        $this->define();
        $this->addConst();
    }

    /**
     * @return void
     */
    private function define()
    {
        $env = (array)parse_ini_file(
            IApp::ENVIRONMENT,
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
    private function addConst()
    {
        $c = count(IApp::ENV);

        for ($i = 0; $i < $c; ++$i) {
            if (!defined(IApp::ENV[$i])) {
                throw new Exception(IApp::ENV[$i] . ": Environment variable not found");
            }
        }
    }
}

/**
 * Class App
 */
final class App extends AppHelper implements IApp
{
    /**
     * @throws Exception
     */
    public function autoload()
    {
        parent::_autoload();
        $this->openEnv();
    }

    public function debug()
    {
        parent::_debug();
    }

    /**
     * @param mixed ...$loader
     */
    public function run(...$loader)
    {
        parent::_run($loader);
    }

    public function time()
    {
        parent::_time();
    }
}

return new App();