<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemPermissionGroup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_permission_group', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->timestamps();
            $table->string('name',24)->comment('名稱');
            $table->tinyInteger('identity')->comment('身份別');
            $table->text('permission')->comment('權限值');
            $table->tinyInteger('enable')->comment('狀態 :0停用, 1啟用');
            $table->integer('create_member_id');
            $table->integer('update_member_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_permission_group');
    }
}
