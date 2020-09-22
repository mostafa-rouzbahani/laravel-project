<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransLevel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'desc',
    ];

    /**
     * The transactions that belong to the TransLevel.
     */
    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
