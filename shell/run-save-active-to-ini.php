<?php

    // --------------------------------------------------------------------------------
    //  php -q /var/www/facebook-control-campaign-status/shell/run-save-active-to-ini.php
    // --------------------------------------------------------------------------------

    $basePath = dirname(__DIR__);
    require_once $basePath . '/app/bootstrap.php';
    initialize($basePath, 'nothing');

    $php         = "/root/.phpbrew/php/php-5.6.6/bin/php -q";
    $projectPath = conf('app.path');
    $commandLine = "{$php} {$projectPath}/shell/save-active-to-ini >> {$projectPath}/var/crontab.log";

    // echo $commandLine . "\n"; exit;
    system($commandLine);
