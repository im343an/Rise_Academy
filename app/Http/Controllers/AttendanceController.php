<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function attendancePage()
    {
        $classes = [
            ["name" => "1st Year Pre-Medical Girls", "desired_class" => "1styear", "catagory" => "fscPreMedical", "gender" => "female"],
            ["name" => "1st Year Pre-Medical Boys", "desired_class" => "1styear", "catagory" => "fscPreMedical", "gender" => "male"],
            ["name" => "1st Year Pre-Eng Girls", "desired_class" => "1styear", "catagory" => "fscPreEngineering", "gender" => "female"],
            ["name" => "1st Year Pre-Eng Boys", "desired_class" => "1styear", "catagory" => "fscPreEngineering", "gender" => "male"],
            ["name" => "1st Year ICS Girls", "desired_class" => "1styear", "catagory" => "ics", "gender" => "female"],
            ["name" => "1st Year ICS Boys", "desired_class" => "1styear", "catagory" => "ics", "gender" => "male"],
            ["name" => "1st Year FA-IT Girls", "desired_class" => "1styear", "catagory" => "faiT", "gender" => "female"],
            ["name" => "1st Year FA-IT Boys", "desired_class" => "1styear", "catagory" => "faiT", "gender" => "male"],
            ["name" => "2nd Year Pre-Medical Girls", "desired_class" => "2ndyear", "catagory" => "fscPreMedical", "gender" => "female"],
            ["name" => "2nd Year Pre-Medical Boys", "desired_class" => "2ndyear", "catagory" => "fscPreMedical", "gender" => "male"],
            ["name" => "2nd Year Pre-Eng Girls", "desired_class" => "2ndyear", "catagory" => "fscPreEngineering", "gender" => "female"],
            ["name" => "2nd Year Pre-Eng Boys", "desired_class" => "2ndyear", "catagory" => "fscPreEngineering", "gender" => "male"],
            ["name" => "2nd Year ICS Girls", "desired_class" => "2ndyear", "catagory" => "ics", "gender" => "female"],
            ["name" => "2nd Year ICS Boys", "desired_class" => "2ndyear", "catagory" => "ics", "gender" => "male"],
            ["name" => "2nd Year FA-IT Girls", "desired_class" => "2ndyear", "catagory" => "faiT", "gender" => "female"],
            ["name" => "2nd Year FA-IT Boys", "desired_class" => "2ndyear", "catagory" => "faiT", "gender" => "male"]
        ];
    
        $currentDate = now()->toDateString();
        $currentTime = now()->format('H:i:s');
    
        // Check if it's before 12 PM to allow previous day's attendance to show
        if ($currentTime < '12:00:00') {
            $yesterday = now()->subDay()->toDateString();
            $attendanceDate = [$yesterday, $currentDate];
        } else {
            $attendanceDate = [$currentDate];
        }
    
        $today = Carbon::today()->toDateString();

        foreach ($classes as &$class) {
            // Check total and present students
            $class['total_students'] = Student::where([
                ['desired_class', $class['desired_class']],
                ['catagory', $class['catagory']],
                ['gender', $class['gender']]
            ])->count();
        
            $class['present_students'] = Attendance::whereHas('student', function ($query) use ($class) {
                $query->where([
                    ['desired_class', $class['desired_class']],
                    ['catagory', $class['catagory']],
                    ['gender', $class['gender']]
                ]);
            })->whereIn('attendance_date', $attendanceDate)
              ->where('is_present', 1)
              ->count();
        
            $class['absent_students'] = $class['total_students'] - $class['present_students'];
        
            // Check if attendance has been submitted for today
            $attendanceSubmitted = Attendance::whereHas('student', function ($query) use ($class) {
                $query->where([
                    ['desired_class', $class['desired_class']],
                    ['catagory', $class['catagory']],
                    ['gender', $class['gender']]
                ]);
            })->where('attendance_date', $today)
              ->exists();
        
            $class['attendance_status'] = $attendanceSubmitted ? 'Submitted' : 'Not Submitted';
        }
            return view('attendance', compact('classes'));
    }
    public function showAttendanceForm(Request $request)
    {
        $desiredClass = $request->input('year');
        $category = $request->input('category');
        $gender = $request->input('gender');
        $currentMonthYear = Carbon::now()->format('Y-m');
    
        // Fetch students based on filters
        $students = Student::where([
            ['desired_class', $desiredClass],
            ['catagory', $category],
            ['gender', $gender]
        ])->get();
    
        // Fetch fees for the current month for these students
        $fees = Fee::whereIn('student_id', $students->pluck('id'))
            ->where('month_year', $currentMonthYear)
            ->get()
            ->keyBy('student_id'); // Key by student_id for easy access
    
        return view('attendance-form', compact('students', 'fees'));
    }
    public function storeAttendance(Request $request)
    {
        $attendanceData = $request->input('attendance');
        $feeData = $request->input('paid');
        $remainingFeeData = $request->input('remaining');
        $feeDates = $request->input('fee_date'); // Ensure fee date is captured
        $currentMonthYear = Carbon::now()->format('Y-m');
        $today = Carbon::now()->toDateString();
    
        foreach ($attendanceData as $studentId => $status) {
            // Fetch student details
            $student = Student::find($studentId);
            if (!$student) {
                continue;
            }
    
            // Save Attendance with correct class, category, and gender
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'attendance_date' => $today,
                    'month_year' => $currentMonthYear,
                ],
                [
                    'is_present' => ($status === 'Present' ? 1 : 0),
                    'desired_class' => $student->desired_class,
                    'catagory' => $student->catagory,
                    'gender' => $student->gender,
                ]
            );
    
            // Save Fee with correct class, category, and gender
            if (isset($feeData[$studentId])) {
                $paidAmount = (float) $feeData[$studentId];
                $remainingAmount = (float) $remainingFeeData[$studentId];
                $feeDate = $feeDates[$studentId] ?? null;
    
                $fee = Fee::updateOrCreate(
                    [
                        'student_id' => $studentId,
                        'month_year' => $currentMonthYear,
                    ],
                    [
                        'paid_amount' => $paidAmount,
                        'remaining_amount' => $remainingAmount,
                        'status' => ($paidAmount > 0 ? 'Paid' : 'Unpaid'),
                        'last_paid_date' => $feeDate, // Fix: Ensure last paid date is stored correctly
                        'desired_class' => $student->desired_class,
                        'catagory' => $student->catagory,
                        'gender' => $student->gender,
                    ]
                );
            }
        }
    
        return redirect()->back()->with('success', 'Attendance and Fees saved successfully!');
    }
    
                    
        
    // Reset daily attendance (called by Kernel schedule)
    public function resetDailyAttendance()
    {
        Attendance::whereDate('attendance_date', Carbon::yesterday())->update(['is_present' => 0]);
        return "Daily attendance reset completed.";
    }

    // Reset monthly fees (called by Kernel schedule)
    public static function resetMonthlyFees()
    {
        $currentMonthYear = Carbon::now()->format('Y-m');
        $previousMonthYear = Carbon::now()->subMonth()->format('Y-m');
    
        // Fetch all students with remaining fees from the previous month
        $previousFees = self::where('month_year', $previousMonthYear)
            ->where('remaining_amount', '>', 0)
            ->get();
    
        \Log::info('Previous Month Fees Found:', ['count' => $previousFees->count()]);
    
        foreach ($previousFees as $fee) {
            // Check if a fee record already exists for the student in the new month
            $existingFee = self::where('student_id', $fee->student_id)
                ->where('month_year', $currentMonthYear)
                ->first();
    
            if ($existingFee) {
                \Log::info('Updating Existing Fee Record:', ['student_id' => $fee->student_id]);
    
                //  Update the existing record by adding the remaining fee
                $existingFee->update([
                    'remaining_amount' => $existingFee->remaining_amount + $fee->remaining_amount,
                    'status' => 'Unpaid',
                ]);
            } else {
                \Log::info('Creating New Fee Record:', ['student_id' => $fee->student_id]);
    
                //  Create a new record with carried forward remaining amount
                self::create([
                    'student_id'      => $fee->student_id,
                    'desired_class'   => $fee->desired_class,
                    'catagory'        => $fee->catagory,
                    'gender'          => $fee->gender,
                    'month_year'      => $currentMonthYear,
                    'status'          => 'Unpaid',
                    'paid_amount'     => 0,
                    'remaining_amount'=> $fee->remaining_amount, //  Carry forward
                    'last_paid_date'  => null,
                ]);
            }
        }
    }
        }
