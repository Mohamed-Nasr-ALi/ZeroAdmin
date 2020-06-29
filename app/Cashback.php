<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cashback extends Model
{
    //
    protected $table = "cashbacks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'agent_id', 'client_cashback', 'zerocach_cashback'
    ];
    protected $appends = ['total_cashback'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }
    public function getTotalCashbackAttribute()
    {
        $total =$this->client_cashback + $this->zerocach_cashback;
        return number_format($total, 2) ;
    }
}
