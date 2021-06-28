<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code')->nullable();
            $table->string('titre')->nullable();
            $table->string('titre_ar')->nullable();
            $table->text('presentation')->nullable();
            $table->string('fax')->nullable();
            $table->string('telephone')->nullable();
            $table->string('url')->nullable();
            $table->integer('adresse_id')->nullable();

            $table->foreign('adresse_id')->references('id')->on('adresses')->onDelete('cascade');

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
        Schema::dropIfExists('universites');
    }
}
