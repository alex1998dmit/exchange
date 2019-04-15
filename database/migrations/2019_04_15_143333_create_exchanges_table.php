<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExchangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exchanges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exchanged_currency')->unsigned();
            $table->bigInteger('received_currency')->unsigned();
            $table->decimal('amount', 15, 2);
            $table->date('date');
            $table->decimal('rate', 5, 2);
            $table->timestamps();
        });

        Schema::table('exchanges', function($table) {
            $table->foreign('exchanged_currency')->references('id')->on('currencies');
            $table->foreign('received_currency')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exchanges');
    }
}
