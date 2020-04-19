<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vote_id');
            /********COMPULSORY NAAME SINGULAR_NAME DENA HAI YAHA*/
            $table->string('vote_type');
            $table->tinyInteger('vote');
            /********COMPULSORY NAAME SINGULAR_NAME DENA HAI YAHA*/
            $table->timestamps();

            $table->unique(['user_id', 'vote_id', 'vote_type']);
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
