<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsArticleCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_article_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('news_article_id')->unsigned();
            $table->integer('customer_id')->unsigned();
            $table->integer('news_article_comment_id')->unsigned()->nullable(); // Parent
            $table->text('article_comment')->nullable();
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
