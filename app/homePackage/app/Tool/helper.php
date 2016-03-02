<?php
namespace AppModule;
use SlimManager;

// --------------------------------------------------------------------------------
// wrap controller help functions
// --------------------------------------------------------------------------------

/**
 *  取得 route 處理之後獲得的參數
 *
 *  @see https://github.com/pwfisher/CommandLine.php
 */
function attrib($key, $defaultValue=null)
{
    return \Bridge\Input::get($key, $defaultValue);
}

/**
 *  輸出
 */
function put($message=null)
{
    if(null === $message) {
        echo "\n";
        return;
    }

    switch (gettype($message)) {
        case "array":
        case "object":
        case "resource":
            print_r($message);
            break;

        case "integer":
        case "double":
        case "string":
            echo $message;
            echo "\n";
            break;

        case "NULL":
        case "boolean":
        case "unknown type":
            var_dump($message);
            break;

        default:
            die('put() Error: fasdfasdfasfadfasdfsad');
    };
}

/**
 *  輸出
 */
function toJson($message)
{
    if (is_array($message)) {
        $message = json_encode($message);
    }
    elseif (is_object($message)) {
        $toArray = (array) $message;
        $result = [];
        foreach ($toArray as $key => $value) {
            $result[$key] = $value;
        }
        $message = json_encode($result);
    }
    else {
        $message = json_encode([
            'result' => $message
        ]);
    }

    SlimManager::getResponse()->getBody()->write($message);
}

function url($segment, $args=[])
{
    $url = conf('home.base.url') . $segment;
    if (!$args) {
        return $url;
    }
    $query = [];
    foreach ($args as $key => $value) {
        $query[] = $key .'='. $value;
    }
    return $url . '?' . join('&', $query);
}

function redirect($url, $isFullUrl=false)
{
    if (!$isFullUrl) {
        $url = url($url);
    }

    //$data = \Bridge\Input::getProperties();
    //return $data['response']->withHeader('Location', $url);
    return SlimManager::getResponse()->withHeader('Location', $url);
}
