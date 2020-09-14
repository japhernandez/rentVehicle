<?php


namespace App\UseCase;


use App\Models\Rent;

interface RentInterface
{
    /**
     * @param array $data
     * @return Rent
     */
    public function addRent(array $data);
}
