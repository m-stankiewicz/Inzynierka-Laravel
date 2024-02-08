<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function series()
    {
        return $this->belongsTo(InvoiceSeries::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function calculateTotals()
    {
        $totalsByVatRate = $this->items->load('vatRate')->groupBy('vat_rate_id')
            ->mapWithKeys(function ($items, $vatRateId) {
                $vatRate = $items->first()->vatRate->rate / 100;
                $netto = $items->sum(fn($item) => $item->quantity * $item->unit_price);
                $brutto = $netto * (1 + $vatRate);

                return [$vatRateId => [
                    'netto' => $netto,
                    'brutto' => $brutto,
                    'vat_rate' => $vatRate * 100,
                ]];
            });

        $totalNetto = $this->items->sum(fn($item) => $item->quantity * $item->unit_price);
        $totalBrutto = $this->items->reduce(function ($carry, $item) {
            $vatRate = $item->vatRate->rate / 100;
            return $carry + ($item->quantity * $item->unit_price * (1 + $vatRate));
        }, 0);

        return [
            'totals_by_vat_rate' => $totalsByVatRate,
            'total_netto' => $totalNetto,
            'total_brutto' => $totalBrutto,
        ];
    }

    protected $fillable = [
        'customer_id',
        'invoice_series_id',
        'invoice_number',
        'description',
        'issue_date',
        'payment_received_date'
    ];
}
