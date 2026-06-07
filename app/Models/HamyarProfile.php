<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HamyarProfile extends Model
{
    protected $fillable = [
        'user_id',
        'cooperation_type',
        'neighborhood_id',
        'organization_name',
        'position_title',
        'experience_text',
        'skills_text',
        'availability_text',
        'description',
        'reviewed_at',
        'reviewed_by',
        'approval_note',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
