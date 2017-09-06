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

    public function getBySlug($slug)
    {
        $article = $this->model->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        return $article;
    }

    public function search($key)
    {
        return $this->model->where('title', 'like', "%{$key}%")->orderBy('published_at', 'desc')->get();
    }
}
