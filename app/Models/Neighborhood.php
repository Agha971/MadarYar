<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    // فیلدهایی که اجازه تغییر دارند
    protected $fillable = [
        'name',
        'parent_id',
    ];

    /**
     * رابطه با منطقه مادر
     * هر محله به یک منطقه تعلق دارد
     */
    public function parent()
    {
        return $this->belongsTo(Neighborhood::class, 'parent_id');
    }

    /**
     * رابطه با محله‌های زیرمجموعه
     * هر منطقه می‌تواند چندین محله داشته باشد
     */
    public function children()
    {
        return $this->hasMany(Neighborhood::class, 'parent_id');
    }

    /**
     * رابطه با کاربران
     * هر محله کاربران (مادران) خودش را دارد
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
