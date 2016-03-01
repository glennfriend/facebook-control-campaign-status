<?php
namespace Bridge\Options;
// use CommandLine;

class InputCli implements \Bridge\Tie\Input
{
    protected $args = [];

    /**
     *  init
     */
    public function init($arguments)
    {
        if ($arguments) {
            $this->args = \CommandLine::parseArgs($args);
        }
    }

    /* --------------------------------------------------------------------------------

    -------------------------------------------------------------------------------- */

    public function get($key, $defaultValue=null)
    {
        if (isset($this->args[$key])) {
            return $this->args[$key];
        }
        return $defaultValue;
    }

    public function has($key)
    {
        if (isset($this->args[$key])) {
            return true;
        }
        return false;
    }

    public function query( $key, $defaultValue=null )
    {
        throw new Exception('無實作');
    }

    public function post( $key, $defaultValue=null )
    {
        throw new Exception('無實作');
    }

    public function isPost()
    {
        throw new Exception('無實作');
    }

    public function files( $filename='' )
    {
        throw new Exception('無實作');
    }

    public function getParam( $key )
    {
        throw new Exception('無實作');
    }

    public function getParams()
    {
        throw new Exception('無實作');
    }

    public function isAjax()
    {
        throw new Exception('無實作');
    }

}
