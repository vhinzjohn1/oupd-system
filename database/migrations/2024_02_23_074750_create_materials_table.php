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
            $table->string('unit');
            $table->double('price');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
