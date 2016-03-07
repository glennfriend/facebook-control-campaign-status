<?php

function isTraining()
{
    if ( 'training' === conf('app.env') ) {
        return true;
    }
    return false;
}

function isCli()
{
    return PHP_SAPI === 'cli';
}

function conf($key)
{
    return ConfigManager::get($key);
}

// --------------------------------------------------------------------------------
// 
// --------------------------------------------------------------------------------

/**
 *  包裝了 Symfony Dependency-Injection
 *  提供了簡易的取用方式 DI->get( $service )
 *
 *  @return Symfont Container ????
 */
function di($getParam=null)
{
    static $container;
    if ($container) {
        if ($getParam) {
            return $container->get($getParam);
        }
        return $container;
    }

    $container = new Symfony\Component\DependencyInjection\ContainerBuilder();
    return $container;
}

function pr($data, $writeLog=false)
{
    if (is_object($data) || is_array($data)) {
        print_r($data);

        if ($writeLog) {
            di('log')->record(
                print_r($data, true)
            );
        }
    }
    else {
        echo $data;
        echo "\n";

        if ($writeLog) {
            di('log')->record($data);
        }
    }
}

/**
 *  show message to web html
 *      - debug only
 */
function html($data)
{
    if (!isTraining()) {
        return;
    }

    echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

    // is array, object
    if (is_object($data) || is_array($data)) {
        echo '<pre style="background-color:#def;color:#000;text-align:left; font-size: 8px; font-family: Hack,dina">';
        print_r($data);
        echo '</pre>';
        return;
    }

    // is json
    if (is_string($data)
        && is_array(json_decode($data, true))
        && (json_last_error() == JSON_ERROR_NONE)
    ) {
        echo '<pre style="background-color:#def;color:#000;text-align:left; font-size: 8px; font-family: Hack,dina">';
        print_r( json_encode($data, JSON_PRETTY_PRINT) );
        echo '</pre>';
        return;
    }

    echo '<pre style="background-color:#def;color:#000;text-align:left; font-size: 8px; font-family: Hack,dina">';
    echo $data;
    echo '</pre>';
}

function table(Array $rows, $headers=null)
{
    if (isCli()) {
        if (null === $headers) {
            $headers = array_keys($rows[0]);
        }
        echo ConsoleHelper::table( $headers, $rows );
    }
    else {
        if ($rows) {
            echo '<table style="border:1px solid; border-collapse:collapse; word-break:break-all; word-wrap:break-word; table-layout:fixed;">';
            echo '<tbody>';

            if ($headers) {
                echo '<tr>';
                foreach ($headers as $value) {
                    echo '<th>'. $value .'</th>';
                }
                echo '</tr>';
            }

            foreach ($rows as $row) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>'. $value .'</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        }
    }
}
