<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;
    protected $table = 'availability';
    protected $fillable = [
        'doctor_id', 
        'day', 
        'hour_start',
        'duration'
    ];
}
