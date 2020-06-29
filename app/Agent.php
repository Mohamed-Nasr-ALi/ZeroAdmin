<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $table = "agents";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'type_id', 'business_name', 'business_type', 'business_logo'
    ];
    protected $appends = ['cashback'];
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

    public function type()
    {
        return $this->belongsTo('App\Type');
    }
    public function cashback(){
        return $this->hasOne(Cashback::class);
    }
    public function getCashbackAttribute()
    {
        $total= $this->cashback()->first();
        $total= $total['total_cashback'] ?? 0;
        return number_format($total, 2) ;
    }
}
