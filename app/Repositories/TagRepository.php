<?php

namespace App\Repositories;

use App\Models\Tag;

class TagRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(Tag $tag)
    {
        $this->model = $tag;
    }

    public function getByName($name)
    {
        return $this->model->where('tag', $name)->firstOrFail();
    }
}
