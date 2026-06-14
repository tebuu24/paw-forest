<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    public $timestamps = false;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'health_status',
        'gender',
        'species',
        'breed',
        'age',
        'location_id',
        'image',
        'date_added',
    ];

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