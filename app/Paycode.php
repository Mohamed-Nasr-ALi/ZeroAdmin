<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paycode extends Model
{
    protected $table = "paycodes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'paycode', 'amount', 'used'
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