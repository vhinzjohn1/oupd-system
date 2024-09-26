<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('minimum_equipment', function (Blueprint $table) {
            $table->id('minimum_equipment_id');
            $table->string('min_equip_description');
            $table->string('min_equip_owned');
            $table->string('min_equip_lease');
            $table->string('min_equip_totalUnits');
            $table->unsignedBigInteger('project_id');
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minimum_equipment');
    }
};
