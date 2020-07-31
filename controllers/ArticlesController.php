<?php

declare(strict_types = 1);

namespace controllers;

class ArticlesController
{
    /** @var string */
    public $title;

    /**
     * ArticlesController constructor.
     */
    public function __construct()
    {
        $this->title = 'Articles list';
    }

    public function getData()
    {
        return [
            'title' => $this->title,
            'content' => 'Articles content',
        ];
    }
}