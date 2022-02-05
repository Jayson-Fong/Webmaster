<?php

namespace WS\Controller;

use WS\BaseInitializable;
use WS\Exception\InvalidRequestException;
use WS\Mvc\Request;
use WS\Mvc\Response;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 * @copyright Jayson Fong 2022
 */
abstract class Controller extends BaseInitializable
{

    public function actionIndex(): Response
    {
        return $this->app->buildResponse();
    }

    public function assetIsPost()
    {
        if ($this->app->request()->get(Request::SERVER, 'REQUEST_METHOD') !== 'POST')
        {
            throw new InvalidRequestException();
        }
    }

}