<?php
namespace App\Repositories\Interfaces;
use Illuminate\Database\Eloquent\Model as ModelAlias;

interface WalletInterface{
    public function all();
    public function show($id);
    public function update(array $data, $id);
    public function with($relations);
    public function subFromAdminWallet($admin,$amount);
    public function addToUserWallet($user_to_pay,$amount);
    public function checkWallet($user_to_pay);
}
