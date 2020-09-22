<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'is_admin',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * This looks for an admin column in users table
     *
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Get the ads for the user.
     */
    public function advertisements()
    {
        return $this->hasMany('App\Advertisement');
    }

    /**
     * Get the buyer transactions for the user.
     */
    public function b_transactions()
    {
        return $this->hasMany('App\Transaction','b_user_id');
    }

    /**
     * Get the seller transactions for the user.
     */
    public function s_transactions()
    {
        return $this->hasMany('App\Transaction','s_user_id');
    }

    /**
     * Get the accepted seller transactions for the user.
     */
    public function s_transactions_accept()
    {
        return $this->hasMany('App\Transaction','s_user_id')->where('transAccept_id', '=', 3);
    }

    /**
     * Get the tickets for the user.
     */
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
