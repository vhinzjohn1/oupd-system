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
        Schema::create('projects', function (Blueprint $table) {
            $table->id('project_id');
            $table->string('project_title');
            $table->string('project_location');
            $table->string('project_owner');
            $table->text('project_description');
            $table->string('project_contract_duration');
            $table->date('project_date_prepared');
            $table->decimal('project_appropriation', 10, 2);
            $table->string('project_source_of_fund');
            $table->string('project_mode_of_implementation');
            $table->integer('ocm')->nullable();
            $table->integer('contractors_profit')->nullable();
            $table->integer('vat')->nullable()->default(5);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
