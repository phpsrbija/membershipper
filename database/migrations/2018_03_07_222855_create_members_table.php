<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first');
            $table->string('last');
            $table->string('email')->unique();
            $table->string('nickname');
            $table->string('username');
            $table->string('password');
            $table->string('password_salt');
            $table->boolean('password_verified')->default(0);
            $table->boolean('active')->default(0);
            $table->string('github_profile_url');
            $table->string('manualy_uploaded_biografy_file_url');
            $table->string('about_me');
            $table->string('profile_image_url');
            $table->softDeletes();
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
        Schema::dropIfExists('members');
    }
}
