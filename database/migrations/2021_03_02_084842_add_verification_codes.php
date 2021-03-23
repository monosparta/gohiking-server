<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVerificationCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('verification_code_0')->nullable();
            $table->string('verification_code_1')->nullable();
            $table->string('verification_code_2')->nullable();
            $table->string('verification_code_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verification_code_0');
            $table->dropColumn('verification_code_1');
            $table->dropColumn('verification_code_2');
            $table->dropColumn('verification_code_3');
        });
    }
}
