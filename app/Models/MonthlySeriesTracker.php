<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlySeriesTracker extends Model
{
    use HasFactory;
    public function yearlyTracker()
    {
        return $this->belongsTo(YearlySeriesTracker::class);
    }

    protected $fillable = [ 
        'yearly_series_tracker_id',
        'month',
        'last_monthly_id'
    ];
}
