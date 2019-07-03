<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminuser', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('account',24);
            $table->string('password',64);
            $table->string('name',24);
            $table->tinyInteger('status');
            $table->integer('create_admin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adminuser');
    }
}
