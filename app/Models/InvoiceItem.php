<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function vatRate()
    {
        return $this->belongsTo(VatRate::class);
    }

    protected $fillable = [
        'name',
        'unit',
        'quantity',
        'unit_price',
        'vat_rate_id'
    ];
}
