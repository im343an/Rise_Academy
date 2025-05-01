<?php

namespace App\Http\Controllers;

use App\Models\Salary;
use App\Models\Student;
use App\Models\Salaries;
use App\Models\FeeSummary;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{
    public function showSalary($teacher, Request $request)
    {
        $monthYear = $request->get('month', now()->format('Y-m')); //  Get from request
    
        // Map teachers to allowed categories
        $teacherMappings = [
            'iftikhar-ahmad-shahid' => ['fscPreMedical', 'fscPreEngineering'],
            'rashid-khan' => ['fscPreEngineering', 'ics'],
            'maqsood-baloch' => ['fscPreMedical'],
            'tahir-mehmood' => ['fscPreMedical', 'fscPreEngineering', 'ics'],
            'muhammad-imran' => ['ics', 'faIt'],
            'mudasir-buzdar' => ['fscPreMedical', 'fscPreEngineering', 'ics', 'faIt', 'arts'],
            'baqir-hussain' => ['fscPreMedical', 'fscPreEngineering', 'ics', 'faIt', 'arts'],
        ];
        
        //  Validate teacher
        if (!isset($teacherMappings[$teacher])) {
            abort(403, "Invalid teacher!");
        }
    
        $classes = Student::whereIn(DB::raw('LOWER(TRIM(catagory))'), array_map('strtolower', $teacherMappings[$teacher]))
        ->where(DB::raw('LOWER(TRIM(catagory))'), '!=', 'office assistant')
        ->where('desired_class', '!=', 'Passout') 
        ->select(
            'desired_class', 
            'gender', 
            DB::raw('LOWER(TRIM(catagory)) as catagory')
        )
        ->distinct()
        ->get()
        ->map(function ($class) use ($monthYear) {
            $classKey = strtolower(trim("{$class->desired_class}_{$class->gender}_{$class->catagory}")); // ✅ Match with `fee_summaries`
    
            $totalStudents = Student::where([
                ['desired_class', $class->desired_class],
                ['catagory', $class->catagory],
                ['gender', $class->gender]
            ])->count();
    
            $summary = FeeSummary::where([
                ['class', $classKey], //  Ensure this matches `fee_summaries`
                ['month_year', $monthYear]
            ])->first();
    
            return [
                'id' => $classKey, //  Matches `fee_summaries.class`
                'name' => "{$class->desired_class} ({$class->gender}, {$class->catagory})",
                'desired_class' => $class->desired_class,
                'gender' => $class->gender,
                'catagory' => $class->catagory,
                'total_students' => $totalStudents,
                'full_fee_paid' => $summary->full_paid ?? 0, //  Fetching correctly
                'half_fee_paid' => $summary->half_paid ?? 0, //  Fetching correctly
            ];
        })
        ->unique('id')
        ->values();
                        
        return view('salary', compact('teacher', 'classes', 'monthYear'));
    }
        
    public function students($teacher, $class, Request $request)
    {
        $month = $request->get('month', date('Y-m'));
    
        //  Decode and parse the class identifier safely
        $decodedClass = urldecode($class);
        $parts = explode('_', $decodedClass);
    
        //  Ensure we have exactly 3 parts (desired_class, gender, category)
        if (count($parts) !== 3) {
            return abort(400, 'Invalid class format!');
        }
    
        [$desiredClass, $gender, $category] = $parts;
    
        //  Fetch students with fee details
        $students = Student::where([
            ['students.desired_class', $desiredClass],
            ['students.catagory', $category],
            ['students.gender', $gender]
        ])
        ->leftJoin('fees', function ($join) use ($month) {
            $join->on('students.id', '=', 'fees.student_id')
                 ->where('fees.month_year', '=', $month);
        })
        ->select(
            'students.id',
            'students.name',
            'students.gender',
            DB::raw('COALESCE(fees.paid_amount, 0) as paid_amount'),
            DB::raw('COALESCE(fees.remaining_amount, 0) as remaining_amount'),
            DB::raw('COALESCE(fees.status, "Unpaid") as fee_status')
        )
        ->orderBy('students.name')
        ->get();
    
        //  Auto-reset FeeSummary at the start of a new month
        $existingSummary = FeeSummary::where('class', $class)->where('month_year', $month)->first();
    
        if (!$existingSummary) {
            FeeSummary::create([
                'class' => $class,
                'month_year' => $month,
                'full_paid' => 0,
                'half_paid' => 0
            ]);
        }
    
        return view('students', compact('teacher', 'class', 'students', 'month'));
    }
    
    //  Save salary summary
    public function saveSummary(Request $request)
    {
        $request->validate([
            'full_paid' => 'required|integer|min:0',
            'half_paid' => 'required|integer|min:0',
            'class' => 'required|string',
            'month_year' => 'required|date_format:Y-m'
        ]);

        //  Find or create FeeSummary entry
        $summary = FeeSummary::updateOrCreate(
            ['class' => $request->class, 'month_year' => $request->month_year],
            ['full_paid' => $request->full_paid, 'half_paid' => $request->half_paid]
        );

        return response()->json(['success' => true, 'message' => 'Salary summary saved successfully.']);
    }

    //  Get salary summary for a specific class and month
    public function getSalarySummary(Request $request)
    {
        $class = $request->query('class');
        $monthYear = $request->query('month_year');

        $summary = FeeSummary::where('class', $class)->where('month_year', $monthYear)->first();

        return response()->json([
            'full_paid' => $summary->full_paid ?? 0,
            'half_paid' => $summary->half_paid ?? 0
        ]);
    }
    public function resetSalarySummary(Request $request)
{
    $request->validate([
        'class' => 'required|string',
        'month_year' => 'required|date_format:Y-m'
    ]);

    // Reset the summary for the class and month
    FeeSummary::where('class', $request->class)
        ->where('month_year', $request->month_year)
        ->update([
            'full_paid' => 0,
            'half_paid' => 0
        ]);

    return response()->json(['success' => true, 'message' => 'Salary summary reset successfully.']);
}

public function store(Request $request) {
    $request->validate([
        'teacher_name' => 'required|string',
        'final_payable' => 'required|numeric',
        'salary_month' => 'required|date',
    ]);

    Salary::create($request->all());

    return back()->with('success', 'Salary record saved successfully!');
}
public function salariesinfo(Request $request) {
    $currentMonth = Carbon::now()->format('Y-m'); // Get current year-month format (YYYY-MM)
    $month = $request->input('month', $currentMonth); // Use selected month or default to current

    // Fetch salaries for the selected month
    $salary = Salaries::where('salary_month', $month)->get();

    return view('salaries-info', compact('salary', 'month'));
}    
}
