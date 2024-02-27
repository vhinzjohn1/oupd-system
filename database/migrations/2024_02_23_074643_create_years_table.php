<?php

// database/migrations/YYYY_MM_DD_create_years_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateYearsTable extends Migration
{
    public function up()
    {
        Schema::create('years', function (Blueprint $table) {
            $table->id('year_id'); // Define custom primary key column
            $table->string('year');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('years');
    }
}
