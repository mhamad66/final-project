<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShowroomGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showroom_goods', function (Blueprint $table) {
            $table->id();
            $table->integer('min');
            $table->unsignedBigInteger('showroom_id');
            $table->unsignedBigInteger('good_id');
            $table->foreign('showroom_id')->on('showrooms')->references('Id');
            $table->foreign('good_id')->on('goods')->references('Id');
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
        Schema::dropIfExists('showroom_goods');
    }
}
