<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceSeries extends Model
{
    use HasFactory;

    public function trackers()
    {
        return $this->hasMany(YearlySeriesTracker::class);
    }

    public function getLastIdForSeries($issueDate)
    {
        $year = $issueDate->year;
        $month = $issueDate->month;

        // Pobierz lub utwórz YearlySeriesTracker dla danego roku
        $yearlyTracker = $this->trackers()->firstOrCreate([
            'year' => $year
        ]);

        // Pobierz lub utwórz MonthlySeriesTracker dla danego miesiąca
        $monthlyTracker = $yearlyTracker->monthlyTrackers()->firstOrCreate([
            'month' => $month
        ]);

        // Aktualizuj i zapisz ID
        $monthlyTracker->last_monthly_id++;
        $monthlyTracker->save();

        $yearlyTracker->last_yearly_id++;
        $yearlyTracker->save();

        return [
            'monthly_id' => $monthlyTracker->last_monthly_id,
            'yearly_id' => $yearlyTracker->last_yearly_id
        ];
    }
    
    protected $fillable= [
        'name',
        'pattern',
        'description',
    ];
}
