<?php

// database/migrations/YYYY_MM_DD_create_prices_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->id('price_id');
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);
            $table->string('quarter');
            $table->string('year');
            $table->unsignedBigInteger('material_id')->nullable();
            $table->foreign('material_id')
                ->references('material_id')
                ->on('materials');
            $table->timestamps();
        });

    }

    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
