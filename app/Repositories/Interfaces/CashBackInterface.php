<?php
namespace App\Repositories\Interfaces;

interface CashBackInterface{

    public function create(array $data);
    public function update(array $data, $id);

}
