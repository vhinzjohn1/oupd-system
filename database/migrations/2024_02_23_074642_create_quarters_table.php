<?php

// database/migrations/YYYY_MM_DD_create_quarters_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuartersTable extends Migration
{
    public function up()
{
    Schema::create('quarters', function (Blueprint $table) {
        $table->id('quarter_id');
        $table->string('quarter');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('quarters');
    }
}
