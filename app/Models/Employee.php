<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'phone_number',
        'job_title',
        'location_id',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}