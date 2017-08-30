<?php

namespace App\Repositories;

use App\Models\Article;

class ArticleRepository
{
    use Repository;

    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }
}
