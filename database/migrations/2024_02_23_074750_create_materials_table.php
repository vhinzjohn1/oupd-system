<?php
// database/migrations/YYYY_MM_DD_create_materials_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id('material_id');
            $table->string('material_name');
            $table->unsignedBigInteger('material_category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('price_id')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('material_category_id')->references('material_category_id')->on('material_categories');
            $table->foreign('unit_id')->references('unit_id')->on('units');
            $table->foreign('price_id')->references('price_id')->on('prices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
