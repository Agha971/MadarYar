<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;
    use HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->email === 'admin@madaryar.ir';
    }

    public function neighborhood()
    {
        return $this->belongsTo(Neighborhood::class);
    }

    public function children()
    {
        return $this->hasMany(Child::class);
    }

    public function hamyarProfile()
    {
        return $this->hasOne(HamyarProfile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function motherProfile()
    {
        return $this->hasOne(MotherProfile::class);
    }


    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'neighborhood_id',
        'status',
        'is_active',
        'profile_completed',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'reportable');
    }

}
