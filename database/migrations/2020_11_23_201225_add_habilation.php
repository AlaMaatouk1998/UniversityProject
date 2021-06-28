<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHabilation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('etablissement_specialite', function (Blueprint $table) {
            $table->string('habilitation_debut')->nullable();
            $table->string('habilitation_fin')->nullable();
            $table->integer('code_dossier')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('etablisement_specialites', function (Blueprint $table) {
            //
        });
    }
}
