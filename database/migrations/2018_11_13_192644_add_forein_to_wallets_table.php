<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeinToWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->unsignedInteger('commerce_id')->nullable();
            $table->foreign('commerce_id')->references('id')->on('commerces')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('crypto_id')->nullable();
            $table->foreign('crypto_id')->references('id')->on('cryptos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wallets', function (Blueprint $table) {
            $table->dropColumn('commerce_id');
            $table->dropColumn('crypto_id');
        });
    }
}
