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
        Schema::create('project_particular_materials', function (Blueprint $table) {
            $table->bigIncrements('project_particular_material_id');
            $table->unsignedBigInteger('project_particular_id');
            $table->unsignedBigInteger('material_id');
            $table->decimal('quantity', 10, 4);
            $table->timestamp('timestamp')->useCurrent();
            // Foreign keys
            $table->foreign('project_particular_id')->references('project_particular_id')->on('project_particulars')->onDelete('cascade');
            $table->foreign('material_id')->references('material_id')->on('materials')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_particular_materials');
    }
};
