<?php


namespace App\Repositories;

use App\UseCase\UserInterface;
use App\User;

class UserRepository implements UserInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserRepository constructor.
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return
     */
    public function addUser(array $data)
    {
       return $this->model->create($data);
    }
}
