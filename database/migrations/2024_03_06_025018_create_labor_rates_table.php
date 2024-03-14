<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('labor_rates', function (Blueprint $table) {
            $table->id('labor_rate_id');
            $table->decimal('rate', 10, 2);
            $table->unsignedBigInteger('labor_id')->nullable(); // Foreign Key
            $table->foreign('labor_id')
                ->references('labor_id')
                ->on('labors');
            $table->boolean('is_active')->default(true);
            $table->timestamp('date_effective')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('labor_rates');
    }
};
