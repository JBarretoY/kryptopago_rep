<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalsToCommerceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commerces', function (Blueprint $table) {
            $table->float('total_VES_by_BTC')->default(0);
            $table->float('total_BTC')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commerces', function (Blueprint $table) {
            Schema::dropIfExists('commerces');
        });
    }
}
