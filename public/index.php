<?php

require(__DIR__ . '/../vendor/autoload.php');
include "../controllers/BaseController.php";
include "../controllers/ApiController.php";
include "../core/Router.php";
include "../core/DataBase.php";

\core\DataBase::connect('test_task', 'homestead', 'secret', 'localhost', 33060);

$router = new \core\Router();
$router->callAction();