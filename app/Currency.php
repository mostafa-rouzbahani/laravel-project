<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'usd_rate', 'usd_rate_date', 'irr_rate', 'irr_rate_date', 'exchange', 'exchange_date',
    ];

    protected $dates = ['usd_rate_date','irr_rate_date', 'exchange_date'];

    /**
     * The ads that belong to the currency.
     */
    public function advertisements()
    {
        return $this->hasMany('App\Advertisement');
    }
}
