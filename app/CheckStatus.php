<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class CheckStatus extends Model
{

    public function url(){
        return $this->belongsTo('App\Url');
    }
    
    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }













}
