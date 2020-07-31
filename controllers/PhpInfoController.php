<?php

declare(strict_types = 1);

namespace controllers;

class PhpInfoController
{
    /** @var string */
    public $title;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->title = 'phpinfo()';
    }

    public function getData()
    {
        return [
            'title' => $this->title,
            'content' => phpinfo(),
        ];
    }
}