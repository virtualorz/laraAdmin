<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMemberStyle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_style', function (Blueprint $table) {
            $table->bigInteger('id')->unsigned();
            $table->timestamps();
            $table->string('show_name',24)->comment('顯示名稱');
            $table->longText('pic')->comment('大頭貼');
            $table->string('theme',24)->comment('佈景主題');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_style');
    }
}
