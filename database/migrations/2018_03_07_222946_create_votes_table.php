<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->integer('vote_member_id')->unsigned();
            $table->integer('vote_member_value');
            $table->integer('status');
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('member_id')->references('id')->on('members')->onDelete('restrict')->onUpdate('cascade');
            $table->foreign('vote_member_id')->references('id')->on('members')->onDelete('restrict')->onUpdate('cascade');
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
