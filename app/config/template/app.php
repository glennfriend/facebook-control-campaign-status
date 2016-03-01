<?php

$path = '/var/www/facebook-control-compain-status';

/**
 *  app config
 *  example:
 *      conf('app.env');
 *
 */
return [

    /**
     *  Environment
     *
     *      training    - 開發者環境
     *      production  - 正式環境
     */
    'env' => 'training',

    /**
     *  app path
     */
    'path' => $path,

    /**
     *  timezone
     *
     *      +0 => UTC
     *      -7 => America/Los_Angeles
     *      +8 => Asia/Taipei
     */
    'timezone' => 'America/Los_Angeles',

    /**
     *
     */
    'storage' => $path . '/var/ids.ini',

];
