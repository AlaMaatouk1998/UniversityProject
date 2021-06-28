<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mention extends Model
{
    protected $fillable = [
        'titre', 'titre_ar', 'domaine_id'
    ];
    public function Domaine()
    {
        return $this->belongsTo('App\Domaine');
    }
    public function Specialites()
    {
        return $this->hasMany('App\Specialite');
    }
}
