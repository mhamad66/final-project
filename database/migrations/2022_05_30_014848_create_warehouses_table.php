<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('Id');
            $table->string('district')->nullable();
            $table->string('address')->nullable();
            $table->integer('total_space');
            $table->float('longitude');
            $table->float('latitude');
            $table->float('avg_sales')->default(0)->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();

            //Foreign Key
            // $table->foreign('district_id')
            //     ->references('id')
            //     ->on('districts')
            //     ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
