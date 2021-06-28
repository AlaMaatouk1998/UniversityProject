<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    protected $fillable = [
        'titre', 'titre_ar', 'presentation', 'telephone', 'fax', 'adresse_id', 'url', 'universite_id', 'type', 'categorie',
        'nb_etudiants'
    ];
    public function Universite()
    {
        return $this->belongsTo('App\Universite');
    }
    public function Adresse()
    {
        return $this->belongsTo('App\Adresse');
    }
    public function Specialites()
    {
        return $this->belongsToMany('App\Specialite')->withPivot('habilitation_debut', 'habilitation_fin', 'code_dossier');
    }
}
