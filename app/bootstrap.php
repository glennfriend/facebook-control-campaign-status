<?php

function initialize($basePath, $packageName)
{
    error_reporting(-1);
    ini_set('html_errors','Off');
    ini_set('display_errors','Off');

    /**
     *  load helper function
     */
    include ('helper.php');

    /**
     *  load composer
     */
    $loadComposer = function($basePath)
    {
        $autoload = $basePath . '/composer/vendor/autoload.php';
        if (!file_exists($autoload)) {
            die('Lose your composer!');
        }
        require_once ($autoload);

        // custom extend load
        $loader = new Composer\Autoload\ClassLoader();
        $loader->addPsr4('Bridge\\',    "{$basePath}/app/components/package/Bridge/");
        $loader->addPsr4('Ydin\\',      "{$basePath}/app/components/package/Ydin/");
        $loader->register();
    };
    $loadComposer($basePath);

    // init config
    ConfigManager::init( $basePath . '/app/config');
    if ( conf('app.path') !== $basePath ) {
       pr('base path setting error!');
       exit;
    }

    if (isTraining()) {
        error_reporting(E_ALL);
        ini_set('html_errors','On');
        ini_set('display_errors','On');
    }

    if (isCli()) {
        ini_set('html_errors','Off');
        ini_set('display_errors','Off');
    }

    date_default_timezone_set(conf('app.timezone'));

    //
    // ---- start ----
    //

    if ( phpversion() < '5.5' ) {
        pr("PHP Version need >= 5.5");
        exit;
    }

    // load Package
    switch($packageName)
    {
        case 'home':
            include_once "{$basePath}/app/{$packageName}Package/PackageSetting.php";
            $setting = new PackageSetting();
            $setting->set('basePath', $basePath);
            $setting->perform();
            break;

        case 'queue':
            include_once "{$basePath}/app/{$packageName}Package/PackageSetting.php";
            $setting = new PackageSetting();
            $setting->set('basePath', $basePath);
            $setting->perform();
            break;

        case 'nothing':
            // 不做任何事情
            break;

        default:
            throw new Exception('Warning! setting file error!'); 
            exit;
    }
}
