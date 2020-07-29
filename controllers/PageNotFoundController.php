<?php

declare(strict_types = 1);

namespace controllers;

class PageNotFoundController
{
    /** @var string */
    public $title;

    /**
     * PageNotFoundController constructor.
     */
    public function __construct()
    {
	    http_response_code(404);
        $this->title = 'Page not found';
    }

    public function getData()
    {
        return [
            'title' => $this->title,
        ];
    }
}
