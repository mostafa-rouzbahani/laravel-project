<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ticket_id', 'message', 'admin',
    ];

    /**
     * Get the ticket that owns the messages.
     */
    public function ticket()
    {
        return $this->belongsTo('App\Ticket');
    }
}
