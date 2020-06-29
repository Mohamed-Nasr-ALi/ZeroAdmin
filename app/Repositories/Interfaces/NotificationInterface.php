<?php
namespace App\Repositories\Interfaces;
interface NotificationInterface{
    public function sendNotification($title, $body, $user, $type);
    public function sendNotificationClient($title, $body, $to, $type);
    public function sendNotificationVendor($title, $body, $to, $type);
    public function sendTransactionNotifications($admin, $amount, $user_to_pay);
}
