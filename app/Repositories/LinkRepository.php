<?php

namespace App\Repositories;

use App\Models\Link;

class LinkRepository
{
    use Repository;

    protected $model;

    public function __construct(Link $link)
    {
        $this->model = $link;
    }
}
