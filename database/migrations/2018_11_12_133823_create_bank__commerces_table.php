<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankCommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bank_commerce', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bank_id')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->unsignedInteger('commerce_id')->nullable();
            $table->foreign('commerce_id')->references('id')->on('commerces')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('bank_commerce');
    }
}
