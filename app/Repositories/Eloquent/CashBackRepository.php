<?php
namespace App\Repositories\Eloquent;

use App\Cashback;
use App\Repositories\Interfaces\CashBackInterface;
use App\Repositories\Interfaces\UserInterface;
use App\User;

class CashBackRepository implements CashBackInterface
{

    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Cashback $model)
    {

        $this->model = $model;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }
}
