<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostsTable extends Migration {

	public function up()
	{
		Schema::create('posts', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug')->unique();
            $table->string('seo_title')->nullable();
            $table->text('excerpt');
            $table->text('body');
            $table->text('meta_description');
            $table->text('meta_keywords');
//            $table->string('tag'); remove tag in post field // config mapping tag - post many to many
            $table->boolean('active')->default(false);
			$table->integer('user_id')->unsigned();
			$table->string('image')->nullable();
//			$table->integer('status'); // remove status  because duplicate with active field
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('posts');
	}
}
