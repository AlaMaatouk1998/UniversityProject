<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtablissementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etablissements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('code')->nullable();
            $table->string('titre')->nullable();
            $table->string('titre_ar')->nullable();
            $table->text('presentation')->nullable();
            $table->string('fax')->nullable();
            $table->string('telephone')->nullable();
            $table->string('url')->nullable();
            $table->string('type')->nullable();
            $table->string('categorie')->nullable();
            $table->string('nb_etudiants')->nullable();
            $table->integer('universite_id')->nullable();

            $table->foreign('universite_id')->references('id')->on('universites')->onDelete('cascade');
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
        Schema::dropIfExists('etablissements');
    }
}
