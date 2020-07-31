<?php

return [
    'routes' => [
        '/phpinfo'  => controllers\PhpInfoController::class,
        '/404'      => controllers\PageNotFoundController::class,
        '/'         => controllers\MainController::class,
        '/news'     => controllers\NewsController::class,
        '/articles' => controllers\ArticlesController::class,
    ]
];