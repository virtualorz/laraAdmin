<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_permission', function (Blueprint $table) {
            $table->integer('permission_group_id')->comment('群組名稱');
            $table->integer('member_id')->comment('管理員ID');
            $table->dateTime('created_at');
            $table->integer('create_member_id');
            $table->primary(array('permission_group_id', 'member_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_permission');
    }
}
