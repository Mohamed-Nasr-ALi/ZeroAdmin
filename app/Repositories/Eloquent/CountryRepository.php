<?php
namespace App\Repositories\Eloquent;

use App\Country;
use App\Repositories\Interfaces\CountriesInterface;

class CountryRepository implements CountriesInterface
{

    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Country $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->paginate(15);
    }
    //get all for api
    public function get_all()
    {
        return $this->model->all();
    }

    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
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

}
