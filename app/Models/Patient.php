<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $fillable = [
        'name', 
        'lastname', 
        'email',
        'phone',
        'type_document',
        'document',
        'date_birth',
        'gender',
        'address',
        'status'
    ];
}
