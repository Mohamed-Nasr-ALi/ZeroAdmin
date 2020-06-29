<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Friend_request extends Model
{
    protected $table = "friend_requests";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'phone_number', 'state', 'full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
