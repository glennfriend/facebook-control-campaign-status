<?php
use CommandLine;

class CliManager
{
    protected $args = [];

    /**
     *  init
     */
    public function init($arguments)
    {
        if ($arguments) {
            $this->args = CommandLine::parseArgs($args);
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

}
