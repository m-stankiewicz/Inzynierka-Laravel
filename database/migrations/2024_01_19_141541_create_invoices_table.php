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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('invoice_series_id');
            $table->string('invoice_number')->nullable();
            $table->string('description');
            $table->date('issue_date');
            $table->date('payment_received_date')->nullable();
            $table->timestamps();
        
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('invoice_series_id')->references('id')->on('invoice_series');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
