<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commerces', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('rif')->nullable();
            $table->string('phone')->nullable();
            $table->string('email');
            $table->text('addres')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('type')->nullable();
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
        Schema::dropIfExists('commerces');
    }
}
