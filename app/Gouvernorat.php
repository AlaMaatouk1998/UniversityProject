<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gouvernorat extends Model
{
    public function Adresses()
    {
        return $this->hasMany('App\Adresse');
    }
}
