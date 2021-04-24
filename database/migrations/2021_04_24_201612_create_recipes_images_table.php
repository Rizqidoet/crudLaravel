<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes_images', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('path');
            $table->unsignedBigInteger('recipes_id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('recipes_id')->references('id')->on('recipes')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->constrained()->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes_images');
    }
}
