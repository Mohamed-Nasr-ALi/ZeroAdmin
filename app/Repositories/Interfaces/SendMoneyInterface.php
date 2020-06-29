<?php
namespace App\Repositories\Interfaces;
interface SendMoneyInterface{
public function sendMoney(array $data);
public function sendMoneyTransactionWithNotification($user_to_pay, $admin, $amount);
}
