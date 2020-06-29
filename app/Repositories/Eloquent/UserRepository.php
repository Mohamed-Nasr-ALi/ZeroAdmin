<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\UserInterface;
use App\User;

class UserRepository implements UserInterface
{

    // model property on class instances
    protected $users;
    // Constructor to bind model to repo
    public function __construct(User $user_model)
    {

        $this->users = $user_model;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
        return $this->users->create($data);
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
        $record = $this->users->findOrFail($id);
        return $record->update($data);
    }
}
