<?php

namespace WS\Mvc;

use WS\BaseInitializable;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 * @copyright Jayson Fong 2022
 */
class Router extends BaseInitializable
{

    /**
     * @todo Change controllers to be in a different path & namespace
     * @param Route $route
     * @return Response
     */
    public function process(Route $route): Response
    {
        $path = $route->getCleanRoutePath();
        $path = $path ?: 'Index';

        $actionPosition = strrpos($path, '/');
        if($actionPosition !== false) {
            $action = substr($path, $actionPosition + 1);
            $path = substr($path, 0, $actionPosition);
        }
        else
        {
            $action = 'index';
        }

        if (class_exists('WS\Controller\\' . $path, false))
        {
            $controller = new ('WS\Controller\\' . $path)($this->app);
        }
        else
        {
            $controller = new ('WS\Controller\Index')($this->app);
        }

        if(method_exists($controller, $action))
        {
            $action = 'index';
        }

        return call_user_func(array($controller, 'action' . $action));
    }

}