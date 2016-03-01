<?php

class ViewHelper
{

    public static function getIni()
    {
        global $storage;
        if ($storage) {
            return $storage;
        }

        $pathFile = conf('app.storage');
        if (!file_exists($pathFile)) {
            file_put_contents( conf('app.storage'), '');
        }

        $reader = new Piwik\Ini\IniReader();
        $storage = $reader->readFile($pathFile);
        return $storage;
    }

    public static function setIni($content)
    {
        $writer = new Piwik\Ini\IniWriter();
        $writer->writeToFile(conf('app.storage'), $content);
    }

    public static function match($key, $topic)
    {
        $storage = self::getIni();
        if (!isset($storage[$topic])) {
            return false;
        }

        foreach ($storage[$topic] as $item) {
            if (in_array($key, $item)) {
                return true;
            }
        }

        return false;
    }

}
