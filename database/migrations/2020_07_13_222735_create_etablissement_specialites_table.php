<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtablissementSpecialitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissement_specialite', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('etablissement_id');
            $table->integer('specialite_id');
            $table->string('annee_universitaire')->nullable();
            $table->integer('nbr_orient')->nullable();
            $table->string('annee')->nullable();

            $table->foreign('etablissement_id')->references('id')->on('etablissements')->onDelete('cascade');
            $table->foreign('specialite_id')->references('id')->on('specialites')->onDelete('cascade');
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
        Schema::dropIfExists('etablissement_specialites');
    }
}
