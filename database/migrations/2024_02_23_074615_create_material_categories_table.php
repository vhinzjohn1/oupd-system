<?php
// database/migrations/YYYY_MM_DD_create_material_categories_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('material_categories', function (Blueprint $table) {
            $table->id('material_category_id');
            $table->string('material_category_name');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('material_categories');
    }
}
