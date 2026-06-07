<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MotherProfile extends Model
{
    protected $fillable = [
        'user_id',
        'bio',
        'skills'
    ];

    protected $casts = [
        'skills' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
