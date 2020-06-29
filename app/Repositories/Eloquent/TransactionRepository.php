<?php
namespace App\Repositories\Eloquent;

use App\Repositories\Interfaces\TransactionInterface;
use App\Transaction;

class TransactionRepository implements TransactionInterface {

    // model property on class instances
    protected $model;
    // Constructor to bind model to repo
    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function cc_history_transactions()
    {
        return $this->model->where('cc',1)->paginate(15);
    }
    // Get all instances of model
    public function cm_history_transactions()
    {
        return $this->model->where('cc',0)->paginate(15);
    }
    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }


    public function all_history_transactions()
    {
        // TODO: Implement all_history_transactions() method.
        return $this->model->paginate(15);
    }

    public function saveSendMoneyTransactions($admin,$user_to_pay,$amount)
    {
        $transaction1=$this->model->create([
            'user_id' => $admin->id,
            'title' => 'Send money',
            'type' => '-1',
            'amount' => $amount,
            'first_user_name' => $admin->full_name,
            'second_user_name' => $user_to_pay->full_name,
            'cc' => '0'
        ]);

        $transaction2 =$this->model->create([
            'user_id' => $user_to_pay->id,
            'title' => 'Received money',
            'type' => '+1',
            'amount' => $amount,
            'first_user_name' => $user_to_pay->full_name,
            'second_user_name' => $admin->full_name,
            'cc' => '0'
        ]);

    }
}
