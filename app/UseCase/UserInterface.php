<?php


namespace App\UseCase;


interface UserInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function addUser(array $data);
}
