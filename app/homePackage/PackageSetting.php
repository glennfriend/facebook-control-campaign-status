<?php

class PackageSetting extends PackageSettingBase
{

    /**
     *  autoload
     *      - module 裡面所需載入的程式
     */
    public function autoloader()
    {
        $basePath = $this->get('basePath');         // Ex. "/var/www/project-name"
        $packageName = basename(dirname(__FILE__)); // Ex. "homePackage"

        $loader = new Composer\Autoload\ClassLoader();
        $loader->addPsr4('AppModule\\', "{$basePath}/app/{$packageName}/app/");

        $filesMap = $this->findFoldersFiles([
            "{$basePath}/app/{$packageName}/app/components",
        ]);

        $loader->addClassMap($filesMap);
        $loader->register();
    }

    /**
     *  di loader
     *  @see https://github.com/symfony/dependency-injection
     *  @see http://symfony.com/doc/current/components/dependency_injection/factories.html
     *  @see http://symfony.com/doc/current/components/dependency_injection/introduction.html
     */
    public function diLoader()
    {
        $basePath = conf('app.path');

        $di = di();
        $di->setParameter('app.path', $basePath);

        /*
        $di->register('abc', 'Lib\Abc')
            ->addArgument('%app.path%');                    // __construct
            ->setProperty('setDb', [new Reference('db')]);  // ??
        */

        // log & log folder
        $di->register('log', 'Bridge\Log')
            ->addMethodCall('init', ['%app.path%/var']);

        // view
        $di->register('view', 'Bridge\View');

        // url
        $di->register('url', 'UrlManager');
        $di->get('url')->init([
            'basePath'  =>  conf('app.path'),
            'baseUrl'   =>  conf('home.base.url'),
            'host'      =>  isCli() ? '' :  $_SERVER['HTTP_HOST'],
        ]);

        /*
        // cache
        $di->register('cache', 'Bridge\Cache')
            ->addMethodCall('init', ['%app.path%/var/cache']);
        */
    }

    /**
     *  package init
     */
    public function packageInit()
    {
    }

    /**
     *
     */
    public function perform()
    {
        $this->autoloader();
        $this->diLoader();
        $this->packageInit();
    }
}
