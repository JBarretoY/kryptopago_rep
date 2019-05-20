<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeinToTransacitionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedInteger('commerce_id')->nullable();
            $table->foreign('commerce_id')->references('id')->on('commerces')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedInteger('wallet_id')->nullable();
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('commerce_id');
            $table->dropColumn('user_id');
            $table->dropColumn('wallet_id');
        });
    }
}
