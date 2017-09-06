<?php

namespace App\Repositories;

use App\User;
use App\Scopes\StatusScope;

class UserRepository
{
    use Repository;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getByGithubId($githubId)
    {
        return $this->model->where('github_id', $githubId)->first();
    }
}
