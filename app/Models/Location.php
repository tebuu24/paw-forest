<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'address',
    ];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}