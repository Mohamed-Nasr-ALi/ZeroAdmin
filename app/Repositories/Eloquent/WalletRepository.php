<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\WalletInterface;
use App\Wallet;

class WalletRepository implements WalletInterface
{

    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Wallet $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->paginate(15);
    }

    // create model
    public function create($data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
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
    public function subFromAdminWallet($admin,$amount)
    {
        $admin_wallet = $admin->wallet;
        $admin_wallet->current_balance -= $amount;
        $admin_wallet->total_spint += $amount;
        $admin_wallet->save();
    }

    public function addToUserWallet($user_to_pay,$amount)
    {
        $user=$this->checkWallet($user_to_pay);
        $user_to_pay_wallet = $user->wallet;
        $user_to_pay_wallet->current_balance += $amount;
        $user_to_pay_wallet->save();
    }

    public function checkWallet($user)
    {
        if ($user->wallet !== null){
            return  $user;
        }
        $wallet=$this->create(['user_id'=>$user->id]);
        return  $wallet->user;
    }
}
