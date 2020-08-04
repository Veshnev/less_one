<?php

declare(strict_types = 1);

namespace controllers;

class MainController
{
    /** @var string */
    public $title;

    /**
     * MainController constructor.
     */
    public function __construct()
    {
        $this->title = 'Main page';
    }

    public function getData()
    {
        return [
            'title' => $this->title,
            'content' => 'Main content',
        ];
    }
}
