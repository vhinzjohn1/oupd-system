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
        Schema::create('project_particular_labors', function (Blueprint $table) {
            $table->bigIncrements('project_particular_labor_id');
            $table->unsignedBigInteger('project_particular_id');
            $table->unsignedBigInteger('labor_id');
            $table->decimal('quantity', 10, 4);
            $table->unsignedInteger('work_days');
            $table->timestamp('datetime');
            // Foreign keys
            $table->foreign('project_particular_id')->references('project_particular_id')->on('project_particulars')->onDelete('cascade');
            $table->foreign('labor_id')->references('labor_id')->on('labors')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_particular_labors');
    }
};
