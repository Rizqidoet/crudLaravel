<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaggableTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taggable__tags', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recipes_id');
            $table->string('tag_name');
            $table->timestamps();
            $table->foreign('recipes_id')->references('id')->on('recipes')->constrained()->onUpdate('cascade')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggable__tags');
    }
}
