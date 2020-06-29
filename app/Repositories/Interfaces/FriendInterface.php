<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Model as ModelAlias;

interface FriendInterface{
    public function all();
    /**
     * @param $id
     * @return ModelAlias
     */
    public function show($id);
    public function update(array $data, $id);
    public function delete($id);

}
