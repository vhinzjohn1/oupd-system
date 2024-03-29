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
        Schema::create('equipments', function (Blueprint $table) {
            $table->id('equipment_id');
            $table->string('equipment_name');
            $table->unsignedBigInteger('equipment_category_id'); // Foreign Key
            $table->foreign('equipment_category_id')
                ->references('equipment_category_id')
                ->on('equipment_categories');
            $table->string('equipment_model');
            $table->string('equipment_capacity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
