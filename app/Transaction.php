<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'advertisement_id', 'transaction_id', 'exchange', 'wage', 's_user_id', 's_currency_id', 's_country_id', 'transAccept_id', 'transAccept_date',
        's_amount', 's_bank_name', 's_account_number', 's_account_name', 's_description', 'b_user_id', 'b_currency_id',
        'b_country_id', 'b_amount', 'b_bank_name', 'b_account_number', 'b_account_name', 'b_description', 'admin_money_flag',
        'admin_money_date', 'b_money_flag', 'b_money_date', 's_money_flag', 's_money_date', 'transLevel_id', 'transState_id',
        'cancel_flag', 'cancel_flag_date', 'unsuccessful_flag', 'unsuccessful_flag_date'
    ];

    protected $dates = ['transAccept_date','admin_money_date', 'b_money_date', 's_money_date', 'cancel_flag_date', 'unsuccessful_flag_date'];

    /**
     * Get the ad that trans come from it.
     */
    public function advertisement()
    {
        return $this->belongsTo('App\Advertisement');
    }

    /**
     * The seller user of the transaction.
     */
    public function s_user()
    {
        return $this->belongsTo('App\User','s_user_id');
    }

    /**
     * The seller currency of the transaction.
     */
    public function s_currency()
    {
        return $this->belongsTo('App\Currency', 's_currency_id');
    }

    /**
     * The seller country of the transaction.
     */
    public function s_country()
    {
        return $this->belongsTo('App\Country', 's_country_id');
    }

    /**
     * The buyer user of the transaction.
     */
    public function b_user()
    {
        return $this->belongsTo('App\User', 'b_user_id');
    }

    /**
     * The buyer currency of the transaction.
     */
    public function b_currency()
    {
        return $this->belongsTo('App\Currency', 'b_currency_id');
    }

    /**
     * The buyer country of the transaction.
     */
    public function b_country()
    {
        return $this->belongsTo('App\Country', 'b_country_id');
    }

    /**
     * The level of the transaction.
     */
    public function transLevel()
    {
        return $this->belongsTo('App\TransLevel', 'transLevel_id');
    }

    /**
     * The state of the transaction.
     */
    public function transState()
    {
        return $this->belongsTo('App\TransState', 'transState_id');
    }

    /**
     * The accept state of the transaction.
     */
    public function transAccept()
    {
        return $this->belongsTo('App\TransAccept', 'transAccept_id');
    }
}
