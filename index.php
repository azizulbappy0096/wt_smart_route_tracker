<?php

define('BASE_PATH', realpath(__DIR__));

require BASE_PATH . '/app/config.php';
require BASE_PATH . '/core/Model.php';
require BASE_PATH . '/core/Router.php';
require BASE_PATH . '/core/SessionMiddlware.php';

Model::init();
SessionMiddleware::init();
$router = new Router();
$router->run();

?>
