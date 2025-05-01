<?php

namespace App\Http\Controllers;

use App\Models\Marks;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarksController extends Controller
{
    public function marks(){
        return view('Marks/marks-form');
    }
    public function weeklyReport(Request $request)
    {
        $selectedYear = $request->year ?? date('Y'); // Default to current year
        $selectedMonth = $request->month ?? date('m'); // Default to current month
        $selectedWeek = $request->week ?? 'Week 1'; // Default to Week 1
    
        $classes = [
            ["name" => "1st Year Pre-Medical Girls", "desired_class" => "1styear", "catagory" => "fscPreMedical", "gender" => "female"],
            ["name" => "1st Year Pre-Medical Boys", "desired_class" => "1styear", "catagory" => "fscPreMedical", "gender" => "male"],
            ["name" => "1st Year Pre-Eng Girls", "desired_class" => "1styear", "catagory" => "fscPreEngineering", "gender" => "female"],
            ["name" => "1st Year Pre-Eng Boys", "desired_class" => "1styear", "catagory" => "fscPreEngineering", "gender" => "male"],
            ["name" => "1st Year ICS Girls", "desired_class" => "1styear", "catagory" => "ics", "gender" => "female"],
            ["name" => "1st Year ICS Boys", "desired_class" => "1styear", "catagory" => "ics", "gender" => "male"],
            ["name" => "1st Year FA-IT Girls", "desired_class" => "1styear", "catagory" => "faIt", "gender" => "female"],
            ["name" => "1st Year FA-IT Boys", "desired_class" => "1styear", "catagory" => "faIt", "gender" => "male"],
            ["name" => "2nd Year Pre-Medical Girls", "desired_class" => "2ndyear", "catagory" => "fscPreMedical", "gender" => "female"],
            ["name" => "2nd Year Pre-Medical Boys", "desired_class" => "2ndyear", "catagory" => "fscPreMedical", "gender" => "male"],
            ["name" => "2nd Year Pre-Eng Girls", "desired_class" => "2ndyear", "catagory" => "fscPreEngineering", "gender" => "female"],
            ["name" => "2nd Year Pre-Eng Boys", "desired_class" => "2ndyear", "catagory" => "fscPreEngineering", "gender" => "male"],
            ["name" => "2nd Year ICS Girls", "desired_class" => "2ndyear", "catagory" => "ics", "gender" => "female"],
            ["name" => "2nd Year ICS Boys", "desired_class" => "2ndyear", "catagory" => "ics", "gender" => "male"],
            ["name" => "2nd Year FA-IT Girls", "desired_class" => "2ndyear", "catagory" => "faIt", "gender" => "female"],
            ["name" => "2nd Year FA-IT Boys", "desired_class" => "2ndyear", "catagory" => "faIt", "gender" => "male"]
        ];
    
        // Define subject lists
        $subjectsList = [
            'fscPreMedical' => ['Biology', 'Chemistry', 'Physics', 'English', 'Urdu', 'Islamiat'],
            'fscPreEngineering' => ['Math', 'Chemistry', 'Physics', 'English', 'Urdu', 'Islamiat'],
            'ics' => ['Computer', 'Math', 'Physics', 'English', 'Urdu', 'Islamiat'],
            'faIt' => ['Computer', 'Sociology', 'Healthphysicaledication', 'English', 'Urdu', 'Islamiat']
        ];
    
        foreach ($classes as &$class) {
            // Get students count
            $students = Student::where([
                ['desired_class', $class['desired_class']],
                ['catagory', $class['catagory']],
                ['gender', $class['gender']]
            ])->get();
    
            $class['total_students'] = $students->count();
    
            // Attendance calculation
            $class['present_students'] = Attendance::whereHas('student', function ($query) use ($class) {
                $query->where([
                    ['desired_class', $class['desired_class']],
                    ['catagory', $class['catagory']],
                    ['gender', $class['gender']]
                ]);
            })->where('is_present', 1)->count();
    
            $class['absent_students'] = $class['total_students'] - $class['present_students'];
    
            // Get total subjects for the class category
            $class['total_subjects'] = count($subjectsList[$class['catagory']] ?? []);
    
            // Fetch marks for the selected week
            $marks = Marks::whereHas('student', function ($query) use ($class) {
                $query->where([
                    ['desired_class', $class['desired_class']],
                    ['catagory', $class['catagory']],
                    ['gender', $class['gender']]
                ]);
            })->where([
                ['week', $selectedWeek],
                ['month', $selectedMonth],
                ['year', $selectedYear]
            ])->get();
    
            // Count uploaded subjects
            $class['subjects_with_marks'] = 0;
            foreach ($subjectsList[$class['catagory']] ?? [] as $subject) {
                if ($marks->pluck($subject)->filter()->count() > 0) {
                    $class['subjects_with_marks']++;
                }
            }
        }
    
        return view('weekly-report', compact('classes', 'selectedWeek', 'selectedMonth', 'selectedYear'));
    }
            public function submitMarks(Request $request)
    {
        $year = $request->year;
        $month = $request->month;
        $week = $request->week;
    
        foreach ($request->marks as $studentId => $subjectMarks) {
            $marksEntry = Marks::where('student_id', $studentId)
                              ->where('year', $year)
                              ->where('month', $month)
                              ->where('week', $week)
                              ->first();
    
            if ($marksEntry) {
                // Update existing record
                foreach ($subjectMarks as $subject => $obtainedMarks) {
                    $totalMarks = $request->total_marks[$subject] ?? null;
                    if ($obtainedMarks !== null && $totalMarks !== null) {
                        $marksEntry->$subject = $obtainedMarks . '/' . $totalMarks;
                    }
                }
                $marksEntry->save();
            } else {
                // Insert new record
                $newMarks = [
                    'student_id' => $studentId,
                    'year' => $year,
                    'month' => $month,
                    'week' => $week,
                ];
    
                foreach ($subjectMarks as $subject => $obtainedMarks) {
                    $totalMarks = $request->total_marks[$subject] ?? null;
                    if ($obtainedMarks !== null && $totalMarks !== null) {
                        $newMarks[$subject] = $obtainedMarks . '/' . $totalMarks;
                    }
                }
    
                Marks::create($newMarks);
            }
        }
    
        return back()->with('success', 'Marks updated successfully');
    }
    public function marksForm($year, $category, $gender, Request $request)
    {
        // Get filter values from request or set defaults
        $selectedYear = $request->get('year', date('Y'));
        $selectedMonth = $request->get('month', date('m'));
        $selectedWeek = $request->get('week', 'Week 1');
    
        // Fetch students based on class, category, and gender
        $students = Student::where([
            ['desired_class', $year],
            ['catagory', $category],
            ['gender', $gender]
        ])->get();
    
        // Define subject lists
        $subjects = [
            'fscPreMedical' => [
                '1styear' => ['Biology', 'Chemistry', 'Physics', 'English', 'Urdu', 'Islamiat'],
                '2ndyear' => ['Biology', 'Chemistry', 'Physics', 'English', 'Urdu', 'Pakstudy']
            ],
            'fscPreEngineering' => [
                '1styear' => ['Math', 'Chemistry', 'Physics', 'English', 'Urdu', 'Islamiat'],
                '2ndyear' => ['Math', 'Chemistry', 'Physics', 'English', 'Urdu', 'Pakstudy']
            ],
            'ics' => [
                '1styear' => ['Computer', 'Math', 'Physics', 'English', 'Urdu', 'Islamiat'],
                '2ndyear' => ['Computer', 'Math', 'Physics', 'English', 'Urdu', 'Pakstudy']
            ],
            'faIt' => [
                '1styear' => ['Computer', 'Sociology', 'Healthphysicaledication', 'English', 'Urdu', 'Islamiat'],
                '2ndyear' => ['Computer', 'Sociology', 'Healthphysicaledication', 'English', 'Urdu', 'Pakstudy']
            ]
        ];
    
        $selectedSubjects = $subjects[$category][$year] ?? [];
    
        // Fetch existing marks based on selected filters
        $marks = Marks::whereIn('student_id', $students->pluck('id'))
            ->where('week', $selectedWeek)
            ->where('month', $selectedMonth)
            ->where('year', $selectedYear)
            ->get()
            ->keyBy('student_id');
    
        return view('marks-form', compact('students', 'year', 'category', 'gender', 'selectedSubjects', 'selectedWeek', 'selectedMonth', 'selectedYear', 'marks'));
    }
    }