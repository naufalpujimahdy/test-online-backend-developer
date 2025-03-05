<?php

namespace App\Service;

use App\Models\User;

class AuthService
{
    protected $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function register(array $data): User
    {
        return $this->model->create($data);
    }
}
