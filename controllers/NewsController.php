<?php

declare(strict_types = 1);

namespace controllers;

class NewsController
{
    /** @var string */
    public $title;

    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        $this->title = 'News list';
    }

    public function getData()
    {
        return [
            'title' => $this->title,
            'content' => 'News content',
        ];
    }
}
