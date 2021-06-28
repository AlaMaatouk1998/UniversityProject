<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('code_postale')->nullable();
            $table->string('rue')->nullable();
            $table->string('numero')->nullable();
            $table->string('gouvernorat')->nullable();
            $table->string('gouvernorat_id')->nullable();

            $table->foreign('gouvernorat_id')->references('id')->on('gouvernorats')->onDelete('cascade');
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
        Schema::dropIfExists('adresses');
    }
}
