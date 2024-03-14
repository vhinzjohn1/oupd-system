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
        Schema::create('equipment_rates', function (Blueprint $table) {
            $table->id('equipment_rate_id');
            $table->decimal('rate', 10, 2);
            $table->unsignedBigInteger('equipment_id')->nullable(); // Foreign Key
            $table->foreign('equipment_id')
                ->references('equipment_id')
                ->on('equipments');
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
        Schema::dropIfExists('equipment_rates');
    }
};
