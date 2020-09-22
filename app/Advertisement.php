<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'p_country_id', 'p_currency_id', 'amount_from', 'amount_to', 'r_country_id', 'r_currency_id'
    ];

    /**
     * Get the user that owns the ad.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * The payment country that belong to the ad.
     */
    public function p_country()
    {
        return $this->belongsTo('App\Country', 'p_country_id');
    }

    /**
     * The payment currency that belong to the ad.
     */
    public function p_currency()
    {
        return $this->belongsTo('App\Currency', 'p_currency_id');
    }

    /**
     * The receiver country that belong to the ad.
     */
    public function r_country()
    {
        return $this->belongsTo('App\Country', 'r_country_id');
    }

    /**
     * The receiver currency that belong to the ad.
     */
    public function r_currency()
    {
        return $this->belongsTo('App\Currency', 'r_currency_id');
    }

    /**
     * The transactions that belong to the ad.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }


//    /**
//     * The countries that belong to the ad.
//     */
//    public function countries()
//    {
//        return $this->belongsToMany('App\Country')->withTimestamps();
//    }
//
//    /**
//     * The payment countries that belong to the ad.
//     */
//    public function payment_countries()
//    {
//        return $this->belongsToMany('App\Country')->wherePivot('type','pay');
//    }
//
//    /**
//     * The receiver countries that belong to the ad.
//     */
//    public function receiver_countries()
//    {
//        return $this->belongsToMany('App\Country')->wherePivot('type','rcv');
//    }
//
//    /**
//     * The currencies that belong to the ad.
//     */
//    public function currencies()
//    {
//        return $this->belongsToMany('App\Currency')->withTimestamps();
//    }
//
//    /**
//     * The payment currencies that belong to the ad.
//     */
//    public function payment_currencies()
//    {
//        return $this->belongsToMany('App\Currency')->wherePivot('type','pay');;
//    }
//
//    /**
//     * The payment currencies that belong to the ad.
//     */
//    public function receiver_currencies()
//    {
//        return $this->belongsToMany('App\Currency')->wherePivot('type','rcv');;
//    }
}
