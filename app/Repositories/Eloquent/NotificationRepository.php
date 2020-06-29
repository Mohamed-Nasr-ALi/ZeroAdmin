<?php
namespace App\Repositories\Eloquent;
use App\Notification;
use App\Repositories\Interfaces\NotificationInterface;

class NotificationRepository implements NotificationInterface{
    // model property on class instances

    protected $notification;

    // Constructor to bind model to repo
    public function __construct(Notification $notification){
        $this->notification = $notification;
    }
    public function sendNotification($title, $body, $user, $type)
    {
        if ($user->role == 2)
            return $this->sendNotificationClient($title, $body, $user->firebase_token, $type);
        else
            return $this->sendNotificationVendor($title, $body, $user->firebase_token, $type);
    }
    public function sendNotificationClient($title, $body, $to, $type)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"to\":\"$to\",\n\t\"notification\": {\n\t\t\"body\": \"$body\",\n\t\t\"title\":\"$title\",\n\t\t\"data\":\"$type\"\n\t}\n}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=AAAAS_q6Nc8:APA91bEIXaUgvNXxfaX5KuVccYxQJ4s4YSV99TFPXTquEVzSIB1xu1ZqnLx6iH5SvTfzeFf9e7hx-GJ_0dgEPzKRnq13Gcq7kl6e7BAgylUGP_X5ly7Ct99wxHVanT-8zj5woLea-PVD",
                "Cache-Control: no-cache",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function sendNotificationVendor($title, $body, $to, $type)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\n\t\"to\":\"$to\",\n\t\"notification\": {\n\t\t\"body\": \"$body\",\n\t\t\"title\":\"$title\",\n\t\t\"data\":\"$type\"\n\t}\n}",
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=AAAA2s8Jdjg:APA91bE0n4wZbKP5P0XpRuYSSt-gYnFTotNPiNbu5qRhdAZFMO5Ljs4i2zBs1AMPCAKa8ybTVLcaWEPuZpyofbW4_AyRxYeUjerJfdmyzZXRsXHIs0lTnmdZbOapf1nilVVD4vlEXUSi",
                "Cache-Control: no-cache",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    public function sendTransactionNotifications($admin, $amount, $user_to_pay)
    {
        $notification1 = $this->notification->create([
            'user_id' => $admin->id,
            'title' => 'You Send Money!',
            'body' => 'You send ,' . $amount . ', to ,' . $user_to_pay->full_name,
            'type' => '2'
        ]);

        $notification2 = $this->notification->create([
            'user_id' => $user_to_pay->id,
            'title' => 'You Received Money!',
            'body' => 'You get ,' . $amount . ', from ,' . $admin->full_name,
            'type' => '3'
        ]);


        $this->sendNotification($notification1->title, $notification1->body, $admin, $notification1->type);
        $this->sendNotification($notification2->title, $notification2->body, $user_to_pay, $notification2->type);
    }
}
