<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function todayActivity()
    {
        $today = Carbon::today();
    
        // Get absent students today
        $absentStudents = Attendance::whereDate('attendance_date', $today)
                                    ->where('is_present', 0) // 0 means absent
                                    ->with('student') // Assuming 'student' is a relationship
                                    ->get();

        $absentCount = $absentStudents->count();
    
        // Get students who paid fees today
        $todayPayments = Fee::whereDate('last_paid_date', $today)
                                ->with('student') // Assuming 'student' is a relationship
                                ->get();

        $paidstudents = $todayPayments->count();
    
        // Total amount collected today
        $todayfee = Carbon::today()->todatestring();

        $todayCollection = Fee::where('last_paid_date', $todayfee)
                        ->sum('paid_amount');

        return view('report', compact('absentStudents', 'todayPayments', 'todayCollection', 'absentCount', 'paidstudents'));
    }
}
