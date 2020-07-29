<?php

declare(strict_types = 1);

error_reporting(E_ALL);

define(ROOT, __DIR__);

$router = [
    '/404'      => controllers\PageNotFoundController::class,
    '/'         => controllers\MainController::class,
    '/news'     => controllers\NewsController::class,
    '/articles' => controllers\ArticlesController::class,
];

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!isset($router[$requestPath])) {
    $requestPath = '/404';
}

$pathController = ROOT . DIRECTORY_SEPARATOR . strtr($router[$requestPath], '\\', DIRECTORY_SEPARATOR) . '.php';

include $pathController;
$controller = new $router[$requestPath]();
echo json_encode($controller->getData());
