<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->longText('stories');
            $table->integer('serving');
            $table->integer('preptime')->default(0);
            $table->integer('cooktime');
            $table->integer('calories')->default(0);
            $table->tinyInteger('level')->default(0);
            $table->tinyInteger('budget')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('ishalal')->default(1);
            $table->tinyInteger('isvegan')->default(1);
            $table->index(['title']);
            $table->index(['serving']);
            $table->index(['cooktime']);
            $table->index(['preptime']);
            $table->index(['calories']);
            $table->index(['level']);
            $table->index(['budget']);
            $table->index(['status']);
            $table->foreign('category_id')->references('id')->on('categories')->constrained()->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('recipes');
    }
}
