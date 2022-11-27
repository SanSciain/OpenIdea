<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeaRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idea_role_user', function (Blueprint $table) {
            $table->unsignedBigInteger('idea_id');
            $table->foreign('idea_id')
                ->references('idea_id')
                ->on('idea_role');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id')
                ->references('role_id')
                ->on('idea_role');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            // $table->boolean("chosen");

            $table->primary(['idea_id', 'role_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('idea_role_user');
    }
}
