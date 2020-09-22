<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug',
    ];

    /**
     * The ads that belong to the country.
     */
    public function advertisements()
    {
        return $this->hasMany('App\Advertisement');
    }
}
