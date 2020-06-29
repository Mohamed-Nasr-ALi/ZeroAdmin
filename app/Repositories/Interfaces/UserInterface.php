<?php
namespace App\Repositories\Interfaces;

interface UserInterface{

    public function create(array $data);
    public function update(array $data, $id);

}
