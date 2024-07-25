<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $table = 'doctors';
    protected $fillable = [
        'name', 
        'lastname', 
        'specialty',
        'type_document',
        'document',
        'phone',
        'email',
        'address'
    ];
    public static function getNameById($id)
    {
        $doctor = self::find($id);
        return $doctor ? $doctor->name : null;
    }
}
