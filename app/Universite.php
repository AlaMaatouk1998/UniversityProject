<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universite extends Model
{
    protected $fillable = [
        'titre', 'titre_ar', 'presentation', 'telephone', 'fax', 'adresse_id', 'url', 'type'
    ];

    public function Etablissements()
    {
        return $this->hasMany('App\Etablissement');
    }
    public function Adresse()
    {
        return $this->belongsTo('App\Adresse');
    }

}
