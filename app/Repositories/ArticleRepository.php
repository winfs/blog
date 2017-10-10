<?php

namespace App\Repositories;

use App\Models\Article;
use App\Scopes\DraftScope;

class ArticleRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Article $article)
    {
        $this->model = $article;
    }

    public function paginate($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        $this->model = $this->checkAuthScope();

        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    public function getBySlug($slug)
    {
        $this->model = $this->checkAuthScope();

        $article = $this->model->where('slug', $slug)->firstOrFail();

        $article->increment('view_count');

        return $article;
    }

    /*
     * 检查当前登录用户是否为管理员，如果是，可以查看草稿状态的文章
     */
    public function checkAuthScope()
    {
        if (auth()->check() && auth()->user()->is_admin) {
            $this->model = $this->model->withoutGlobalScope(DraftScope::class); // 移除全局作用域
        }

        return $this->model;
    }

    public function search($key)
    {
        return $this->model->where('title', 'like', "%{$key}%")->orderBy('published_at', 'desc')->get();
    }

    public function syncTag($tags)
    {
        $this->model->tags()->sync($tags);
    }
}
