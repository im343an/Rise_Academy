<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Student;

Route::get('/get-student-phone', function () {
    $student = Student::first(); // Fetch the first student from the database

    if (!$student) {
        return response()->json(['error' => 'No student found'], 404);
    }

    return response()->json([
        'name' => $student->name,
        'phone_number' => $student->phone_number
    ]);
});
