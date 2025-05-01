<?php

namespace App\Models;

use App\Models\Marks;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'father_name',
        'phone_number',
        'father_profession',
        'previous_school',
        'gender',
        'session',
        'previous_class',
        'marks',
        'desired_class',
        'current_year',
        'catagory',
        'address',
        'source',
    ];
    public function marks()
    {
        return $this->hasMany(Marks::class, 'student_id');
    }
    public function fees()
    {
        return $this->hasMany(Fee::class, 'student_id');
    }
}
