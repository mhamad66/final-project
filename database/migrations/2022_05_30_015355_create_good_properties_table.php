<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('good_properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('good_id')->constrained()->cascadeOnDelete();
            $table->decimal('height', 8, 4);
            $table->decimal('width', 8, 4);
            $table->decimal('box_size', 8, 4);
            $table->decimal('box_weight', 8, 4);
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
        Schema::dropIfExists('good_properties');
    }
}
