<?php
namespace Bridge\Options;

class ViewNormal
{

    /**
     *  init
     */
    public function init()
    {
    }

    /* --------------------------------------------------------------------------------

    -------------------------------------------------------------------------------- */
    public function render($path, $params)
    {
        if (false !== strstr($path,'..')) {
            throw new \Exception('View path is error');
            exit;
        }

        $templateName = basename($path);

        if (!preg_match('/^[a-zA-Z0-9\.]+$/', $templateName)) {
            throw new \Exception('View name ['. htmlspecialchars($templateName) .'] is error');
            exit;
        }

        $tmp = explode('\\', get_class($this));
        $className = strtolower($tmp[count($tmp)-1]);

        if (!file_exists($path)) {
            throw new \Exception('View file "'. htmlspecialchars($path) .'" not found!');
            exit;
        }

        $render = function() use ($path, $params) {
            // EXTR_SKIP - 如果有沖突，覆蓋已有的變量
            extract($params, EXTR_OVERWRITE);
            include $path;
        };
        $render();
    }

}
