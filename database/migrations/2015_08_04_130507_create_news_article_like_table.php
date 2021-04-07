<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsArticleLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_article_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('news_article_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->tinyInteger('is_like')->nullable();
            $table->tinyInteger('is_dislike')->nullable();
            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_tag');
    }
}
