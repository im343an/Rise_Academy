<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Attendance;
use App\Models\Fee;
use Carbon\Carbon;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        //  Reset attendance daily at 12 PM
        $schedule->call(function () {
            Attendance::whereDate('attendance_date', Carbon::yesterday())
                ->update(['is_present' => 0]);
        })->dailyAt('12:00');
    
        //  Reset fee statuses on the 1st of every month at 12 AM
        $schedule->call(function () {
            Fee::resetMonthlyFees();
        })->monthlyOn(1, '00:00'); // Runs on the 1st of every month at 12 AM
    }
        
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
    protected $middlewareGroups = [
        'web' => [
            // Other middleware...
            \App\Http\Middleware\InactiveLogout::class,
        ],
    ];
    
}
