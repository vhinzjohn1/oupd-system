<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->text('description')->nullable();
            $table->text('remark')->nullable();
            $table->decimal('total', 10, 4)->nullable(); // Assuming a decimal type with precision 10 and scale 2
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('project_id')->references('project_id')->on('projects')->onDelete('cascade');
            $table->foreign('particular_id')->references('particular_id')->on('particulars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_particulars');
    }
};
