<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->timestamps();
            $table->string('name',24)->comment('名稱');
            $table->string('account',64)->comment('帳號');
            $table->string('password',64)->comment('密碼');
            $table->date('limit')->nullable()->comment('帳號到期日');
            $table->integer('status')->comment('狀態 : 0停用 1啟用');
            $table->integer('update_admin_id');
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
        Schema::dropIfExists('customer');
    }
}
