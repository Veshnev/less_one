<?php

declare(strict_types = 1);

error_reporting(E_ALL);

$routes = include 'config' . DIRECTORY_SEPARATOR . 'routes.php';

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!isset($routes[$requestPath])) {
    $requestPath = '/404';
}

$pathController = __DIR__ . DIRECTORY_SEPARATOR . strtr($routes[$requestPath], '\\', DIRECTORY_SEPARATOR) . '.php';

include $pathController;
$controller = new $routes[$requestPath]();
echo json_encode($controller->getData());
