<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $table = "fees";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'recharge_fees_option', 'recharge_fees_percentage', 'recharge_fees_amount', 'transfer_fees_option', 'transfer_fees_percentage', 'transfer_fees_amount', 'request_fees_option', 'request_fees_percentage', 'request_fees_amount'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
