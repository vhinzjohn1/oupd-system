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
            $table->id('material_id')->onDelete('cascade');
            $table->string('material_name');
            $table->string('unit');
            $table->unsignedBigInteger('material_category_id');
            $table->foreign('material_category_id')
                ->references('material_category_id')
                ->on('material_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
