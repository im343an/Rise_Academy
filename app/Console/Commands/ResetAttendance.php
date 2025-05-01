<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Attendance;
use Carbon\Carbon;

class ResetAttendance extends Command
{
    protected $signature = 'reset:attendance';
    protected $description = 'Reset attendance records daily at 12 PM';

    public function handle()
    {
        Attendance::whereDate('attendance_date', Carbon::yesterday())->delete();
        $this->info('Attendance records for yesterday have been deleted.');
    }
}
