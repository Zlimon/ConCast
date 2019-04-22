<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('channels', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::table('subscribers', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('channel_id')->references('id')->on('channels');
        });

        Schema::table('tags', function($table) {
            $table->foreign('podcast_id')->references('id')->on('podcasts');
        });

        Schema::table('podcasts', function($table) {
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->foreign('audio_id')->references('id')->on('audio');
            $table->foreign('image_id')->references('id')->on('images');
        });

        Schema::table('categories', function($table) {
            $table->foreign('podcast_id')->references('id')->on('podcasts');
        });

        Schema::table('comments', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('podcast_id')->references('id')->on('podcasts');
        });

        Schema::table('ratings', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('podcast_id')->references('id')->on('podcasts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
