<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trails', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('latitude');
            $table->string('longitude');
            $table->integer('location_id');
            $table->integer('distance');
            $table->binary('coverImage');;
            $table->integer('difficulty');
            $table->integer('evaluation');
            $table->integer('altitude');
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
        Schema::dropIfExists('trails');
    }
}
