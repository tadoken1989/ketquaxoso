<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('label');
            $table->string('description')->nullable();
            $table->string('value')->nullable();
            $table->string('type')->nullable();
            $table->text('options');
            $table->text('attributes');
            $table->tinyInteger('active');
            $table->unsignedInteger('group_id');
            $table->timestamps();
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('setting_groups')->onDelete('cascade');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('setting_settings');
    }
}
