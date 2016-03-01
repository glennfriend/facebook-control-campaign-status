<?php
namespace Bridge;

class Input
{
    const CLI_MODE = 'cli';
    const WEB_MODE = 'web';

    /**
     *  request
     */
    protected static $request = array();

    /**
     *  request init
     */
    public static function init($mode, $arguments=null)
    {

        if (self::CLI_MODE === $mode) {
            self::$request = new Options\InputCommandLine();
            self::$request->init($arguments);
            return true;
        }

        // $mode is WEB_MODE
        $isSlimFramework = true;
        if ($isSlimFramework) {
            self::$request = new Options\InputWebSlim();
            self::$request->init($arguments);            
        }
        else {
            self::$request = new Options\InputWeb();
        }

    }
    
    /* --------------------------------------------------------------------------------
        get
    -------------------------------------------------------------------------------- */

    /**
     *  get $_POST or $_GET value
     */
    public static function get($key, $defaultValue=null)
    {
        return self::$request->get($key, $defaultValue);
    }

    /**
     *  get $_GET value
     */
    public static function query( $key, $defaultValue=null )
    {
        return self::$request->query($key, $defaultValue);
    }

    /**
     *  get $_POST value
     */
    public static function post( $key, $defaultValue=null )
    {
        return self::$request->post($key, $defaultValue);
    }

    /**
     *  get a post file or all post files
     */
    public static function files($filename='')
    {
        return self::$request->files($filename);
    }

    /**
     *  取得 framework 自己 parse router 格式的值
     */
    public static function getParam($key)
    {
        return self::$request->getParam($key);
    }

    /**
     *  取得 framework 自己 parse router 格式所有的值
     */
    public static function getParams()
    {
        return self::$request->getParams();
    }

    /* --------------------------------------------------------------------------------
        check
    -------------------------------------------------------------------------------- */

    /**
     *  has input $_POST or $_GET
     */
    public static function has($key)
    {
        return self::$request->has($key);
    }

    /**
     *  is post
     */
    public static function isPost()
    {
        return self::$request->isPost();
    }

    /**
     *  is ajax
     */
    public static function isAjax()
    {
        return self::$request->isAjax();
    }

    /* --------------------------------------------------------------------------------
        extends
    -------------------------------------------------------------------------------- */

    /**
     *  包裝的程式本身有一些資訊
     *  在這裡統一輸出
     */
    public static function getProperties()
    {
        return self::$request->getProperties();
    }

}
