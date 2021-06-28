<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiplomeEtablissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diplome_etablissement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('etablissement_id');
            $table->integer('diplome_id');

            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('cascade');
            $table->foreign('diplome_id')->references('id')->on('specialites')->onDelete('cascade');
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
        Schema::dropIfExists('diplome_etablissements');
    }
}
