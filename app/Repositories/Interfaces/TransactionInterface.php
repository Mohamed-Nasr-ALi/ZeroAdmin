<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Model as ModelAlias;

interface TransactionInterface{
    public function cc_history_transactions();
    public function cm_history_transactions();
    public function all_history_transactions();
    /**
     * @param $id
     * @return ModelAlias
     */
    public function show($id);
    public function saveSendMoneyTransactions($admin,$user_to_pay,$amount);
}
