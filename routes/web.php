<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MarksController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;


// Public Routes (No Authentication Required)
Route::controller(UserController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::get('/registerform', 'registerform')->name('registerform');
    Route::get('/forget-password', 'forgetpassowrd')->name('forgetpassowrd');
    Route::post('/resetpassword', 'resetpassword')->name('resetpassword');
    Route::post('/register', 'register')->name('register');
    Route::post('/loginform', 'loginform')->name('loginform');
});

// Authenticated User Routes (Requires Authentication)
Route::controller(UserController::class)->middleware(['auth'])->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/updatepicture', 'updatepicture')->name('updatepicture');
    Route::post('/updateprofileinfo', 'updateprofileinfo')->name('updateprofileinfo');
    Route::get('/logout', 'logout')->name('logout');
});

// Salary Management Routes
Route::controller(SalaryController::class)->middleware(['auth'])->group(function () {
    Route::get('/salary/{teacher}', 'showSalary')->name('salary.show');
    Route::get('/salary/{teacher}/{class}', 'students')->name('salary.students');
    Route::post('/update-fee-status', 'updateFeeStatus')->name('update.fee.status');
    Route::post('/save-summary', 'saveSummary')->name('save.salary.summary');
    Route::get('/salary', 'showSalary')->name('get.salary.summary');
    Route::post('/reset-salary-summary', 'resetSalarySummary')->name('reset.salary.summary');
    Route::post('/salary/store', 'store')->name('salary.store');
    Route::get('/get-salary-summary', 'getSalarySummary');
    Route::get('/salaries-information', 'salariesinfo')->name('salaries-information');
});

// Student Management Routes
Route::controller(StudentController::class)->middleware(['auth'])->group(function () {
    Route::get('/add-student', 'addStudent')->name('add-student');
    Route::get('/dashboard', 'index')->name('dashboard');
    Route::get('/staff-members', 'staffmembers')->name('staff-members');
    Route::get('/promote-students', 'promoteStudents')->name('promote-students');
    Route::post('/promote-1st-year', 'promoteFirstYear')->name('promote-first-year');
    Route::post('/promote-2nd-year', 'promoteSecondYear')->name('promote-second-year');
    Route::get('/filter-students', 'filterStudents')->name('filter-students');
    Route::get('/account', 'account')->name('account');
    Route::get('/students', 'AllStudents')->name('all-students');
    Route::post('/new-student', 'store')->name('new-student');
    Route::get('/students/edit/{id}', 'edit')->name('edit-student');
    Route::post('/students/update/{id}', 'update')->name('update-student');
    Route::delete('/students/delete/{id}', 'destroy')->name('delete-student');
});

// Attendance Management Routes
Route::controller(AttendanceController::class)->middleware(['auth'])->group(function () {
    Route::get('/attendance-table', 'getClassAttendanceData')->name('attendance-table');
    Route::get('/count', 'index')->name('attendance');
    Route::get('/attendance-form', 'showAttendanceForm')->name('attendance-form');
    Route::get('/attendance', 'attendancePage');
    Route::post('/attendance/store', 'storeAttendance')->name('attendance.store');
    Route::get('/reset-daily-attendance', 'resetDailyAttendance')->name('attendance.resetDaily');
    Route::get('/reset-monthly-fees', 'resetMonthlyFees')->name('fees.resetMonthly');
});

// Marks Management Routes
Route::controller(MarksController::class)->middleware(['auth'])->group(function () {
    Route::get('/marks-form', 'marks')->name('marks');
    Route::get('/weekly-report', 'weeklyReport')->name('weekly-report');
    Route::get('/marks-form', 'marksForm')->name('marks-form');
    Route::post('/submit-marks', 'submitMarks')->name('submit-marks');
    Route::get('/marks-form/{year}/{category}/{gender}', 'marksForm')->name('marks-form');
});

Route::get('/today-activity', [ReportController::class, 'todayActivity'])->name('today.activity')->middleware('auth');


    




