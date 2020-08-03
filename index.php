<?php

declare(strict_types = 1);
error_reporting(E_ALL);

// Configs part
include __DIR__ . DIRECTORY_SEPARATOR . 'components' . DIRECTORY_SEPARATOR . 'ConfigAggregatorComponent.php';
$configs = (new components\ConfigAggregatorComponent())
    ->setConfigFolderPath(__DIR__ . DIRECTORY_SEPARATOR . 'config');

$routes = $configs->getConfig('routes');

// Request part
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Router part
if (!isset($routes[$requestPath])) {
    $requestPath = '/404';
}

// Controller part
$pathController = __DIR__ . DIRECTORY_SEPARATOR . strtr($routes[$requestPath], '\\', DIRECTORY_SEPARATOR) . '.php';
include $pathController;
$controller = new $routes[$requestPath]();

// Response part
echo json_encode($controller->getData());