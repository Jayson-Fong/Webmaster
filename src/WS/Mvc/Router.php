<?php

namespace WS\Mvc;

use Exception;
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
        if ($actionPosition !== false) {
            $action = substr($path, $actionPosition + 1);
            $path = substr($path, 0, $actionPosition);
        } else {
            $action = 'Index';
        }

        $loaded = false;
        $controller = null;
        try {
            if (@class_exists('WS\Controller\\' . $path, true)) {
                $controller = new ('WS\Controller\\' . $path)($this->app);
                $loaded = true;
            }
        } catch (Exception) {
            $loaded = false;
        }

        if (!$loaded) {
            $controller = new ('WS\Controller\Index')($this->app);
        }

        if (!method_exists($controller, $action)) {
            $action = 'Index';
        }

        try
        {
            return call_user_func(array($controller, 'action' . $action));
        }
        catch (Exception)
        {
            return $this->app->buildResponse();
        }
    }

}