<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marks extends Model
{
    use HasFactory;

    protected $table = 'marks';

    protected $fillable = [
        'student_id',
        'week',
        'month',
        'year',
        'Chemistry',
        'Biology',
        'Math',
        'Computer',
        'Physics',
        'English',
        'Urdu',
        'Islamiat',
        'Pakstudy',
        'Economics',
        'Healthphysicaledication',
        'Sociology',
        'total_marks',
        'subject',
    ];

    /**
     * Get the student associated with the marks.
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
