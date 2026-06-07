<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'neighborhood_id',
        'title',
        'description',
        'event_date',
        'location',
        'capacity',
        'type',
        'category'
    ];

    protected $casts = [
        'event_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
