<?php

use WS\App;

require __DIR__ . '/src/autoload.php';

$app = App::getInstance()->console()->run();