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

        if (isCli()) {
            CliManager::init($argv);
        }

        SlimManager::init($app, $controllerArgs);

        $this->loadHelper($controllerArgs);
        $this->init();
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
        \Bridge\Input::init($args);
        LoadHelper::init();
    }

    /**
     *  render view
     *  TODO: 請寫成一個 view class 抽出去
     */
    protected function render($name, $params)
    {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $name)) {
            throw new \Exception('View path ['. htmlspecialchars($name) .'] type is error');
            exit;
        }

        $tmp = explode('\\', get_class($this));
        $className = strtolower($tmp[count($tmp)-1]);

        $pathFile = dirname(__DIR__) . "/view/{$className}/{$name}.phtml"  ;
        if (!file_exists($pathFile)) {
            throw new \Exception('View file "'. htmlspecialchars($pathFile) .'" not found!');
            exit;
        }

        $render = function() use ($pathFile, $params)
        {
            // TODO: 有一個函式處理這個功能, 請修正
            // 將陣列裡面的值, 把 key 轉為變數名稱, 內容代入
            foreach ($params as $___key => $___value) {
                $$___key = $___value;
            }
            unset($___key, $___value);

            include $pathFile;
        };
        $render();

    }

}
