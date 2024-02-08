<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('name');
            $table->string('unit');
            $table->decimal('quantity', 8, 2);
            $table->decimal('unit_price', 10, 2);
            $table->unsignedBigInteger('vat_rate_id');
            $table->timestamps();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('vat_rate_id')->references('id')->on('vat_rates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
