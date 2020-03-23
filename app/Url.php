<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    public function project(){
        return $this->belongsTo('App\Project');
    }
    public function checkstatuses(){
        return $this->hasOne('App\CheckStatus');
    }
}
