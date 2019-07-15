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
            $table->bigIncrements('id')->unsigned();
            $table->timestamps();
            $table->string('account',24)->comment('帳號');
            $table->string('password',64)->comment('密碼');
            $table->string('name',24)->comment('姓名');
            $table->tinyInteger('status')->comment('狀態 :0停用 1啟用');
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
