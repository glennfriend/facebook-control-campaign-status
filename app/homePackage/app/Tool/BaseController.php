<?php
namespace AppModule\Tool;
use SlimManager;

/**
 *
 */
class BaseController
{

    /**
     *  you can rewrite in extend
     */
    protected function init()
    {
        // nothing
    }

    /**
     *
     */
    public function __call($method, $controllerArgs)
    {
        global $app;    // Slim app
        global $argv;   // by command line

        if (!method_exists($this, $method)) {
            throw new \Exception("API method '{$method}' is not exist!");
            exit;
        }

        di('view')->init();

        if (isCli()) {
            \CliManager::init($argv);
        }
        else {
            SlimManager::init($app, $controllerArgs);
            \Bridge\Input::init($controllerArgs);
        }

        $this->loadHelper($controllerArgs);

        // 如果有回傳值, 則不往下執行
        $result = $this->init();
        if (null !== $result) {
            return $result;
        }

        //
        return $this->$method();
    }

    /**
     *  load functions, to help controller
     *
     *  裡面包裹的 help function
     *  僅給 controller 使用
     *  並不給予 view 使用
     */
    protected function loadHelper(Array $args)
    {
        LoadHelper::init();
    }

    /**
     *  render view
     */
    protected function render($name, $params)
    {
        $tmp = explode('\\', get_class($this));
        $className = strtolower($tmp[count($tmp)-1]);

        $file = dirname(__DIR__) . "/view/{$className}/{$name}.phtml";
        di('view')->render($file, $params);
    }

}
