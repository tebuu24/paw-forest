<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Medicine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'method_of_use',
        'frequency',
        'date_from',
        'date_until',
        'employee_id',
        'animal_id',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

  public function animal()
    {
        return $this->belongsTo(\App\Models\Animal::class, 'animal_id');
    }
}