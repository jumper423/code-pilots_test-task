<?php

require(__DIR__ . '/../vendor/autoload.php');
include "../controllers/ApiController.php";
include "../core/Router.php";

$router = new \core\Router();
$router->callAction();