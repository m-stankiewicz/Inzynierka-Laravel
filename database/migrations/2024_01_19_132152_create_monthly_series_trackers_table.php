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
        Schema::create('monthly_series_trackers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('yearly_series_tracker_id');
            $table->unsignedTinyInteger('month');
            $table->unsignedInteger('last_monthly_id')->default(0);
            $table->timestamps();
        
            $table->foreign('yearly_series_tracker_id')->references('id')->on('yearly_series_trackers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_series_trackers');
    }
};
