<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoryBandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_bands', function (Blueprint $table) {
            $table->increments('id');
            $table->float('min_value_init')->default(0);
            $table->float('max_value_init');
            $table->float('min_value_half');
            $table->float('max_value_half');
            $table->float('min_value_end');
            $table->float('max_value_end')->default(-1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_bands');
    }
}
