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
            $table->longText('map');
            $table->longText('album');
        });
        //步道口
        Schema::create('trail_heads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trail_id');
            $table->string('name');
            $table->string('latitude');
            $table->string('longitude');
            $table->longText('bannerImage');
            $table->longText('description');
            $table->timestamps();

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });
        //最新消息
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trail_id');
            $table->longText('imgUrl');
            $table->string('title');
            $table->date('date');
            $table->string('source');
            $table->mediumText('link');
            $table->timestamps();

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });
        //附近景點
        Schema::create('attractions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('trail_id');
            $table->string('category');
            $table->string('title');
            $table->mediumText('link');
            $table->timestamps();

            $table->foreign('trail_id')->references('id')->on('trails')->onDelete('cascade');
        });
        //chips
        Schema::create('chips', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('chip_trails', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('chip_id');
            $table->unsignedInteger('trail_id');
            $table->timestamps();

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
        Schema::table('trail_heads', function (Blueprint $table) {
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
        Schema::table('chip_trails', function (Blueprint $table) {
            $table->dropForeign(['chip_id']);
            $table->dropForeign(['trail_id']);
        });
        Schema::dropIfExists('chip_trails');
        Schema::dropIfExists('chips');
    }
}
