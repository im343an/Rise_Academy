<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeSummary extends Model
{
    use HasFactory;

    protected $fillable = ['class', 'month_year', 'full_paid', 'half_paid'];
}
