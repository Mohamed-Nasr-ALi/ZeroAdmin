<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\RequestInterface;
use App\Request;

class RequestRepository implements RequestInterface{

    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Request $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->paginate(15);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        return $record->destroy($record->id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }

}
