<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'phone', 'password', 'pin', 'salt', 'account_number', 'role', 'firebase_token', 'device_id', 'profile_picture', 'app'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallet()
    {
        return $this->hasOne('App\Wallet');
    }

    public function requests()
    {
        return $this->hasMany('App\Request');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

    public function friend_requests()
    {
        return $this->hasMany('App\Friend_request');
    }

    public function friends()
    {
        return $this->hasMany('App\Friend');
    }

    public function paycodes()
    {
        return $this->hasMany('App\Paycode');
    }

    public function agent()
    {
        return $this->hasOne('App\Agent');
    }
}
