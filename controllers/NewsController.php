<?php

declare(strict_types = 1);

namespace controllers;

class NewsController
{
    /** @var string */
    private $rootDir;

    /** @var string */
    public $title;

    /**
     * MainController constructor.
     * @param string $rootDir
     */
    public function __construct(string $rootDir)
    {
        $this->rootDir = $rootDir;
        $this->title = 'News list page';
    }

    public function render()
    {
        include $this->rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'MainTemplate.phtml';
    }
}