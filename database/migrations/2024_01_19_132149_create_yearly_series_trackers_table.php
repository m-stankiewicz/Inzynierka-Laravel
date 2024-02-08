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
        Schema::create('yearly_series_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_series_id');
            $table->year('year');
            $table->unsignedInteger('last_yearly_id')->default(0);
            $table->timestamps();
        
            $table->foreign('invoice_series_id')->references('id')->on('invoice_series')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yearly_series_trackers');
    }
};
