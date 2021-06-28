<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Domaine extends Model
{
    protected $fillable = [
        'titre', 'titre_ar'
    ];
    public function Mentions()
    {
        return $this->hasMany('App\Mention');
    } 
    public function Specialites()
    {
        return $this->hasManyThrough('App\Specialite', 'App\Mention');
    }
}
