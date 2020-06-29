<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Interfaces\SendMoneyInterface;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendMoneyRepository implements SendMoneyInterface
{

    // model property on class instances
    protected $user;
    protected $transactionRepository;
    protected $notificationRepository;
    protected $walletRepository;

    // Constructor to bind model to repo
    public function __construct(User $user, TransactionRepository $transactionRepository,NotificationRepository $notificationRepository,WalletRepository $walletRepository)
    {
        $this->user = $user;
        $this->transactionRepository = $transactionRepository;
        $this->notificationRepository = $notificationRepository;
        $this->walletRepository = $walletRepository;
    }

    public function getUser($searchBy, $data)
    {
        return $this->user->where($searchBy, $data)->first();
    }

    public function sendMoneyTransactionWithNotification($user_to_pay, $admin, $amount)
    {
        DB::beginTransaction();
        try{


                $this->walletRepository->subFromAdminWallet($admin,$amount);
                $this->walletRepository->addToUserWallet($user_to_pay,$amount);

                $this->transactionRepository->saveSendMoneyTransactions($admin,$user_to_pay,$amount);

                $this->notificationRepository->sendTransactionNotifications($admin,$amount,$user_to_pay);
                DB::commit();
                return true;


        } catch(\Exception $e){
            Log::info($e);
            DB::rollBack();
            return false;

        }
    }

    public function sendMoney(array $data)
    {
        $user_to_pay = $this->getUser('phone', $data['phone_number']);
        $admin = $this->getUser('id', $data['admin_id']);
        $amount = $data['amount'];
        return $this->sendMoneyTransactionWithNotification($user_to_pay, $admin, $amount);
    }




}
