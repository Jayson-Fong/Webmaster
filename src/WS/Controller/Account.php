<?php

namespace WS\Controller;

use WS\Mvc\Response;

/**
 * @author Jayson Fong <contact@jaysonfong.org>
 * @copyright Jayson Fong 2022
 */
class Account extends Controller
{

    public function actionIndex(): Response
    {
        return $this->app->buildResponse('account', 'login');
    }

}