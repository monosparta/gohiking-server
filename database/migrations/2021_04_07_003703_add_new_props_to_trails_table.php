<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPropsToTrailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //新屬性
        Schema::table('trails', function (Blueprint $table) {
            $table->string('class');
            $table->integer('costTime');
            $table->string('roadstatus');
            $table->mediumText('intro');
            $table->binary('map');
            $table->longText('album');
        });
        //步道口
        Schema::create('trailheads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trail_id');
            $table->string('name');
            $table->string('latitude');
            $table->string('longitude');
            $table->binary('bannerImage');
            $table->longText('description');

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });
        //最新消息
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trail_id');
            $table->binary('imgUrl');
            $table->string('title');
            $table->string('source');
            $table->mediumText('link');

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });
        //附近景點
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trail_id');
            $table->binary('category');
            $table->string('title');
            $table->mediumText('link');

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });
        //chips
        Schema::create('chips', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
        Schema::create('chip_trail', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('chip_id');
            $table->unsignedInteger('trail_id');

            $table->foreign('chip_id')->references('id')->on('chips')->onDelete('cascade');
            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trails', function (Blueprint $table) {
            $table->dropColumn('class');
            $table->dropColumn('costTime');
            $table->dropColumn('roadstatus');
            $table->dropColumn('intro');
            $table->dropColumn('map');
            $table->dropColumn('album');
        });
        //步道口
        Schema::table('trailheads', function (Blueprint $table) {
            $table->dropForeign(['trail_id']);
        });
        Schema::dropIfExists('trailheads');
        //最新消息
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign(['trail_id']);
        });
        Schema::dropIfExists('announcements');
        //附近景點
        Schema::table('attractions', function (Blueprint $table) {
            $table->dropForeign(['trail_id']);
        });
        Schema::dropIfExists('attractions');
        //chips
        Schema::table('chip_trail', function (Blueprint $table) {
            $table->dropForeign(['chip_id']);
            $table->dropForeign(['trail_id']);
        });
        Schema::dropIfExists('chip_trail');
        Schema::dropIfExists('chips');
    }
}
