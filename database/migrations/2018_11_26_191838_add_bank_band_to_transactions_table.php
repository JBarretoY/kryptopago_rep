<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankBandToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('bank_id')->nullable()->unsigned();
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('band_id')->nullable()->unsigned();
            $table->foreign('band_id')->references('id')->on('bands')->onDelete('cascade')->onUpdate('cascade');
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
            $table->dropColumn('bank_id');
            $table->dropColumn('band_id');
        });
    }
}
