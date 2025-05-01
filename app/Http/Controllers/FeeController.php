<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FeeController extends Controller
{
    public function updateFeeStatus(Request $request)
{
    $student = Student::findOrFail($request->student_id);

    // Check if a record already exists for this student & month
    $feeRecord = Fee::where('student_id', $student->id)
        ->where('month_year', date('Y-m')) // Current month
        ->first();

    if ($feeRecord) {
        // Update existing fee record
        $feeRecord->status = $request->fee_status == 'Full Paid' ? 'Paid' : 'Unpaid';
        $feeRecord->paid_amount = $request->fee_status == 'Full Paid' ? $student->fee_amount : $student->fee_amount / 2;
        $feeRecord->remaining_amount = $request->fee_status == 'Full Paid' ? 0 : $student->fee_amount / 2;
        $feeRecord->last_paid_date = now();
        $feeRecord->save();
    } else {
        // Create new fee record
        Fee::create([
            'student_id' => $student->id,
            'desired_class' => $student->desired_class,
            'catagory' => $student->catagory,
            'gender' => $student->gender,
            'month_year' => date('Y-m'), // Store the current month
            'paid_amount' => $request->fee_status == 'Full Paid' ? $student->fee_amount : $student->fee_amount / 2,
            'remaining_amount' => $request->fee_status == 'Full Paid' ? 0 : $student->fee_amount / 2,
            'status' => $request->fee_status == 'Full Paid' ? 'Paid' : 'Unpaid',
            'last_paid_date' => now(),
        ]);
    }

    // Fetch updated summary counts
    $fullPaidCount = Fee::where('desired_class', $student->desired_class)
        ->where('month_year', date('Y-m'))
        ->where('status', 'Paid')
        ->count();

    $halfPaidCount = Fee::where('desired_class', $student->desired_class)
        ->where('month_year', date('Y-m'))
        ->where('status', 'Unpaid')
        ->count();

    return response()->json([
        'success' => true,
        'fullPaidCount' => $fullPaidCount,
        'halfPaidCount' => $halfPaidCount,
    ]);
}

}
