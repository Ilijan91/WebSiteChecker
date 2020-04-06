<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $table;

    protected $fillable = ['name', 'owner_id'];

    public function user(){
        return $this->belongsTo('App\User');
    }



}
