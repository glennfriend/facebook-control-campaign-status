<?php

class PackageSetting extends PackageSettingBase
{

    /**
     *  di loader
     */
    public function diLoader()
    {
        $basePath = conf('app.path');

        $di = di();
        $di->setParameter('app.path', $basePath);

        // log & log folder
        $di->register('log', 'Bridge\Log')
            ->addMethodCall('init', ['%app.path%/var']);

        // view
        $di->register('view', 'Bridge\View');

        // queue
        $di->register('queue', 'Bridge\Queue');
    }

    /**
     *
     */
    public function perform()
    {
        $this->diLoader();
    }

}
