<?php

declare(strict_types = 1);

error_reporting(E_ALL);

$rootDir = __DIR__;

$router = [
    '/404'      => 'controllers\\PageNotFoundController',
    '/'         => 'controllers\\MainController',
    '/news'     => 'controllers\\NewsController',
    '/articles' => 'controllers\\ArticlesController',
];

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!isset($router[$requestPath])) {
    http_response_code(404);
    $requestPath = '/404';
}

$pathController = $rootDir . DIRECTORY_SEPARATOR . strtr($router[$requestPath], '\\', DIRECTORY_SEPARATOR) . '.php';

if (file_exists($pathController)) {
    include $pathController;
    $controller = new $router[$requestPath]($rootDir);
    $controller->render();
}