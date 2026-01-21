<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'event_id','amount','full_name','email','phone','payment_method','status','transaction_reference','notes',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Scopes
    public function scopeByEvent($query, $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }
}
