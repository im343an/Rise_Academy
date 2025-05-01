<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Fee;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $totalStudents = Student::whereIn('desired_class', ['1styear', '2ndyear'])->count();
        $today = Carbon::today()->toDateString();
        $currentMonth = Carbon::now()->format('Y-m');
    
        // Attendance Data
        $absentStudent = Attendance::where('attendance_date', $today)
                                    ->where('is_present', 0)
                                    ->count();
    
        // Fee Data
        $totalCollection = Fee::where('month_year', $currentMonth)->sum('paid_amount');
        $todayCollection = Fee::where('last_paid_date', $today)->sum('paid_amount');

        // Correcting the Paid and Unpaid Student Count
        $paidStudentCount = Fee::where('month_year', $currentMonth)
                                ->where('status', 'Paid')
                                ->distinct('student_id')
                                ->count();

        $unpaidStudentCount = $totalStudents - $paidStudentCount;
    
        // Monthly Fee Collections from January 2025
        $monthlyCollections = [];
        $months = [];
        $startMonth = Carbon::create(2025, 1, 1);
        $endMonth = Carbon::now();
    
        while ($startMonth <= $endMonth) {
            $monthYear = $startMonth->format('Y-m');
            $months[] = $startMonth->format('F');
            $monthlyCollections[] = Fee::where('month_year', $monthYear)->sum('paid_amount');
            $startMonth->addMonth();
        }
    
        // Reset data after hover issue
        $monthlyCollections = array_map('floatval', $monthlyCollections);
    
        return view('dashboard', compact(
            'totalStudents',
            'absentStudent',
            'paidStudentCount',
            'unpaidStudentCount',
            'totalCollection',
            'todayCollection',
            'monthlyCollections',
            'months'
        ));
    }
    public function AllStudents(){
        $students = Student::all();
        return view('all-students', compact('students'));
    }

    public function addStudent(){
        return view('add-student');
    }

    public function store(Request $request)
    {
        // Validation Rules
        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'father_profession' => 'required|string|max:255',
            'previous_school' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'session' => 'required|string',
            'previous_class' => 'required|string',
            'marks' => 'required|integer',
            'desired_class' => 'required|string',
            'catagory' => 'required|string',
            'current_year' => 'required|integer',
            'address' => 'required|string',
            'source' => 'required|string',
        ]);

        // Store Student Data
        Student::create($request->all());

        return redirect()->route('all-students')->with('success', 'Student added successfully!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('edit-student', compact('student'));
    }

    public function edits($id)
    {
        $student = Student::findOrFail($id);
        return view('student-edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        // Validation Rules
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'father_profession' => 'required|string|max:255',
            'previous_school' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'previous_class' => 'required|in:matric,inter1stYear',
            'marks' => 'required|integer',
            'desired_class' => ['required', Rule::in(['1styear', '2ndyear'])],
            'current_year' => 'required|integer',
            'catagory' => 'required|string',
            'address' => 'required|string',
            'source' => 'required|string',
        ]);

        // Find Student Record
        $student = Student::findOrFail($id);

        // Update Student Data
        $student->update($validatedData);

        return redirect()->route('all-students')->with('edit', 'Student updated successfully!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('all-students')->with('delete', 'Student deleted successfully!');
    }
 
    public function filterStudents(Request $request)
    {
        $query = Student::query();
    
        if ($request->has('year') && !empty($request->year)) {
            $query->where('desired_class', $request->year);
        }
    
        if ($request->has('session') && !empty($request->session)) {
            $query->where('session', $request->session);
        }
    
        if ($request->has('category') && !empty($request->category)) {
            $query->where('catagory', $request->category);
        }
    
        if ($request->has('gender') && !empty($request->gender)) {
            $query->where('gender', $request->gender);
        }
    
        $students = $query->get();
    
        return view('all-students', compact('students'));
    }
    public function saveSummary(Request $request)
    {
        $request->validate([
            'class' => 'required|string',
            'month_year' => 'required|string',
            'full_paid' => 'required|integer',
            'half_paid' => 'required|integer',
    ]);

    // Check if a summary already exists for this class & month
        $summary = FeeSummary::updateOrCreate(
            ['class' => $request->class, 'month_year' => $request->month_year],
            ['full_paid' => $request->full_paid, 'half_paid' => $request->half_paid]
    );

        return response()->json(['message' => 'Summary Saved Successfully!', 'data' => $summary]);
    }
    public function promoteStudents(){
        return view('Promote-students');
    }

    public function promoteFirstYear()
    {

        // Get all students in 1st Year
        $students = Student::where('desired_class', '1styear')->get();

        foreach ($students as $student) {
            $student->desired_class = '2ndyear';
            $student->current_year++; // Increment year
            $student->save();
        }

        return redirect()->route('promote-students')->with('success', '1st Year students promoted to 2nd Year successfully!');    
    }


    public function promoteSecondYear()
    {
        // Get all students in 2nd Year
        $students = Student::where('desired_class', '2ndyear')->get();

        foreach ($students as $student) {
            $student->desired_class = 'Passout';
            $student->current_year++; // Increment year
            $student->save();
        }

        return redirect()->route('promote-students')->with('success', '2nd Year students promoted to Passout successfully!');
    }   
    public function staffmembers(){
        return view('staff-members');
    }
    public function account(){
        return view('account');
    }
}    