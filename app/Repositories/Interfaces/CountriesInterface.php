<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Model as ModelAlias;

interface CountriesInterface{
    public function all();
    /**
     * @param array $attributes
     * @return ModelAlias
     */
    public function create(array $attributes);
    public function show($id);
    /**
     * @param array $data
     * @return ModelAlias
     */
    public function update(array $data, $id);
    public function delete($id);
}
