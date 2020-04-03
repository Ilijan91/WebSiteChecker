<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
    public function urls(){
        return $this->hasMany('App\Url');
    }
    
    public function path(){
        return url("/projects/{$this->hash}");
    }
    
 
}
