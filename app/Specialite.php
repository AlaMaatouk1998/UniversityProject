<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $fillable = [
        'titre', 'titre_ar', 'diplome_id', 'mention_id', 'code'
    ];
    public function Diplome()
    {
        return $this->belongsTo('App\Diplome');
    }
    public function Mention()
    {
        return $this->belongsTo('App\Mention');
    }
    public function Etablissements()
    {
        return $this->belongsToMany('App\Etablissement');
    }
}
