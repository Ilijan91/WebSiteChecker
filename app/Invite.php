<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = [
        'email', 'accept_token','deny_token','user_id','team_id'
    ];


    





    
}
