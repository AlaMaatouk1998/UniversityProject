<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    protected $fillable = [
        'gouvernorat', 'latitude', 'longitude', 'code_postale', 'rue', 'numero', 'gouvernorat_id', 'ville'
    ];
    public function Gouvernorat()
    {
        return $this->belongsTo('App\Gouvernorat');
    }
    public function Universites()
    {
        return $this->hasMany('App\Universite');
    }
}
