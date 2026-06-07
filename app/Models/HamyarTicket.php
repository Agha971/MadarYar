<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HamyarTicket extends Model
{
    protected $fillable = [
        'user_id',
        'neighborhood_id',
        'hamyar_id',
        'subject',
        'message',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hamyar()
    {
        return $this->belongsTo(User::class, 'hamyar_id');
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }
}
