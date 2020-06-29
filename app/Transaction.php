<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = "transactions";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title', 'amount', 'type', 'first_user_name', 'second_user_name', 'cc'
    ];
    protected $appends = ['transaction_generated_id'];
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
    public function getTransactionGeneratedIdAttribute()
    {
        $fakedate =  Carbon::createFromFormat('Y-m-d H:m:s', now());
        $date = $this->created_at ?? $fakedate;
        $date=$this->id.'TRNS'.$date->year. $date->month. $date->day. $date->hour;
        return $date;
    }
}
