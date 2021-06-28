<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diplome extends Model
{
    protected $fillable = [
        'titre', 'titre_ar', 'niveau', 'type'
    ];
    public function Specialites()
    {
        return $this->hasMany('App\Specialite');
    }    
}
