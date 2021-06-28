<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFOreignKeyToSpecialite extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('specialites', function (Blueprint $table) {
            $table->integer('mention_id')->nullable();
            $table->foreign('mention_id')->references('id')->on('mentions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('specialites', function (Blueprint $table) {
            //
        });
    }
}
