<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function getByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }
}
