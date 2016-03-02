<?php
namespace AppModule;
use SlimManager;

/**
 *
 */
class Help extends Tool\BaseController
{

    protected function info()
    {
        $routes = SlimManager::getRouter()->getRoutes();
        $urlPrefix = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'];
        $show = [];
        foreach ($routes as $index => $route) {

            $show[$index] = [
                'pattern' => $route->getPattern(),
                'methods' => join(',' , $route->getMethods()),
                'url'     => $urlPrefix . conf('home.base.url') . $route->getPattern(),
            ];

            $description = $this->getArgumentsTip($route->getPattern());
            if ($description) {
                $show[$index]['arguments_tip'] = $description;
            }

        }

        toJson($show);
    }

    private function getArgumentsTip($pattern)
    {
        switch ($pattern) {
            case '/status/{type}':
                return [1 => 'active', 0 => 'pause'];
                break;
        }
        return null;
    }

}
