<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('project_particulars', function (Blueprint $table) {
            $table->id('project_particular_id');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('particular_id');
            $table->integer('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('unit_cost', 10, 5)->nullable();
            $table->decimal('total', 30, 5)->nullable();
            $table->timestamps();
            // Foreign key constraints
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('particular_id')->references('particular_id')->on('particulars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Optionally drop the trigger
        DB::unprepared('DROP TRIGGER IF EXISTS calculate_project_particular_total');

        Schema::dropIfExists('project_particulars');
    }
};
