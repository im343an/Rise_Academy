<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'attendance_date',
        'month_year',
        'is_present',
        'desired_class',
        'catagory',
        'gender',
    ];

    // Function to reset daily attendance at 12 PM
    public static function resetDailyAttendance()
    {
        $today = Carbon::now()->toDateString();
        self::where('attendance_date', '!=', $today)->update(['is_present' => 0]);
    }


    /**
     * Relationship with Student model
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
