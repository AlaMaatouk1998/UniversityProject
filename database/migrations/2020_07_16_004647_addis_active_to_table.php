<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddisActiveToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('universites', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('etablissements', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        }); 
        Schema::table('diplomes', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('domaines', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('mentions', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('specialites', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
        Schema::table('adresses', function (Blueprint $table) {
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('universites', function (Blueprint $table) {
            //
        });
    }
}
