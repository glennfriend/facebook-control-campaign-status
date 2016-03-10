<?php

return [

    'gearman' => [
        'servers'   => ['127.0.0.1'],   // ['192.168.0.1:1001', '192.168.0.2::2002']
        'services'  => ['sleep'],       // ['sleep,rebuildSearchTable']
    ],

];
