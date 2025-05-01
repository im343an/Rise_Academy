<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Fee;

class ResetFee extends Command
{
    protected $signature = 'reset:fee';
    protected $description = 'Reset fee status to unpaid on the 1st of every month';

    public function handle()
    {
        Fee::query()->update([
            'status' => 'Unpaid',
            'paid_amount' => 0,
            'remaining_amount' => function ($query) {
                return $query->select('total_fee')->from('fees')->whereColumn('fees.id', 'fees.id');
            }
        ]);
        $this->info('All student fee statuses have been reset to unpaid.');
    }
}
