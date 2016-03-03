<?php

class SlimConfigHelper
{
    public static function getDefaultJsonContainer()
    {
        $container = new Slim\Container();

        if (isTraining()) {
            $container['settings']['displayErrorDetails'] = true;
        }

        // Override the default Not Found Handler
        $container['notFoundHandler'] = function ($c) {
            return function ($request, $response) use ($c) {

                $error = ErrorSupportHelper::getJson('p404');
                return $c['response']
                    ->withStatus(404)
                    ->withHeader('Content-Type', 'application/json')
                    ->write($error)
                ;

            };
        };

        return $container;
    }
}
