<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use SoftDeletes;
    public $timestamps = false;

    protected $fillable = [
        'date',
        'comment',
        'status',
        'user_id',
        'employee_id',
        'animal_id',
        'location_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function animal()
    {
        return $this->belongsTo(\App\Models\Animal::class, 'animal_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}