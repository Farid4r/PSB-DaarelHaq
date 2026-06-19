<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentDetail extends Model
{
    protected $fillable = [
    'registration_id',
    'father_name',
    'father_occupation',
    'father_phone',
    'mother_name',
    'mother_occupation',
    'address',
];
}
