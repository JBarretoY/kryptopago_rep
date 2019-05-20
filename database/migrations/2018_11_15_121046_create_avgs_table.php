<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avgs', function (Blueprint $table) {
            $table->increments('id');
            $table->float('avg_12h')->nullable();
            $table->float('volume_btc')->nullable();
            $table->float('avg_24h')->nullable();
            $table->float('avg_1h')->nullable();
            $table->float('avg_6h')->nullable();
            $table->float('last')->nullable();
            $table->json('json');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avgs');
    }
}
