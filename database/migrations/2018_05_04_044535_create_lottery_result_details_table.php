<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotteryResultDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lottery_result_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('result_lottery_id')->unsigned();
            $table->foreign('result_lottery_id')->references('id')->on('result_lotteries')->onDelete('cascade');
            $table->string('prize');
            $table->string('prize_number');
            $table->integer('order');
            $table->integer('status');
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
        Schema::dropIfExists('lottery_result_details');
    }
}
