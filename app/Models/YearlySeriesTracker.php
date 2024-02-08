<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YearlySeriesTracker extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_series_id',
        'year',
        'last_yearly_id'
    ];

    public function series()
    {
        return $this->belongsTo(InvoiceSeries::class);
    }

    public function monthlyTrackers()
    {
        return $this->hasMany(MonthlySeriesTracker::class);
    }
}
