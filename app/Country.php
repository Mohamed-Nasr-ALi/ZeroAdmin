<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //
    protected $table = "countries";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'calling_code',
        'currency_name',
        'currency_code',
        'currency_symbol',
        'country_name_ar',
        'country_name_en',
        'flag',
        'alpha2Code'
    ];
    public $timestamps = false;
}
