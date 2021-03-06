<?php

declare(strict_types = 1);

namespace controllers;

class MainController
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
        $this->title = 'Main page';
    }

    public function render()
    {
        include $this->rootDir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'MainTemplate.phtml';
    }
}