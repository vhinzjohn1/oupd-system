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
            $table->decimal('price', 10, 2)->default(0.00);
            $table->foreignId('quarter_id')->nullable();
            $table->foreignId('year_id')->nullable();
            $table->timestamps();

            // Add foreign key constraint
            $table->foreign('quarter_id')->references('quarter_id')->on('quarters');
            $table->foreign('year_id')->references('year_id')->on('years');
        });
    }

    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
