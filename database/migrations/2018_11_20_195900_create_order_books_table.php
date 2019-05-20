<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_books', function (Blueprint $table) {
            $table->increments('id');
            $table->float('min_bid');
            $table->float('max_bid');
            $table->float('avg_bid');
            $table->float('min_ask');
            $table->float('max_ask');
            $table->float('avg_ask');
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
        Schema::dropIfExists('order_books');
    }
}
