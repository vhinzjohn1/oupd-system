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
        Schema::create('project_particular_equipments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_particular_id');
            $table->foreign('project_particular_id')->references('project_particular_id')->on('project_particulars')->onDelete('cascade');
            $table->unsignedBigInteger('equipment_id');
            $table->foreign('equipment_id')->references('equipment_id')->on('equipments')->onDelete('cascade');
            $table->integer('no_of_units');
            $table->integer('work_days');
            $table->dateTime('datetime');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_particular_equipments');
    }
};
