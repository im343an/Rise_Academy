<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'desired_class',
        'catagory',
        'gender',
        'month_year',
        'status',
        'paid_amount',
        'remaining_amount',
        'last_paid_date',
    ];

    /**
     * Reset and carry forward student fees at the start of a new month.
     */
    public static function resetMonthlyFees()
    {
        $currentMonthYear = Carbon::now()->format('Y-m');
        $previousMonthYear = Carbon::now()->subMonth()->format('Y-m');

        // Get all unpaid fees from the previous month
        $previousFees = self::where('month_year', $previousMonthYear)
            ->where('remaining_amount', '>', 0)
            ->get();

        foreach ($previousFees as $fee) {
            // Check if a fee record already exists for the student in the new month
            $existingFee = self::where('student_id', $fee->student_id)
                ->where('month_year', $currentMonthYear)
                ->first();

            if (!$existingFee) {
                // Create a new fee record for the current month, carrying forward the remaining amount
                self::create([
                    'student_id'      => $fee->student_id,
                    'desired_class'   => $fee->desired_class,
                    'catagory'        => $fee->catagory,
                    'gender'          => $fee->gender,
                    'month_year'      => $currentMonthYear,
                    'status'          => 'Unpaid',
                    'paid_amount'     => 0,
                    'remaining_amount'=> $fee->remaining_amount,
                    'last_paid_date'  => null,
                ]);
            }
        }
    }

    /**
     * Relationship with Student model
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
