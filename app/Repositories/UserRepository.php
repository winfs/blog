<?php

namespace App\Repositories;

use App\User;
use App\Scopes\StatusScope;

class UserRepository
{
    use BaseRepository;

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getByGithubId($githubId)
    {
        return $this->model->where('github_id', $githubId)->first();
    }

    public function getByName($name)
    {
        return $this->model->where('name', $name)->firstOrFail();
    }

    public function changePassword($user, $password)
    {
        return $user->update(['password' => bcrypt($password)]);
    }
}
