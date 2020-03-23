<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckStatus extends Model
{

    public function url(){
        return $this->belongsTo('App\Url');
    }


    public function checkUrl($url){
        $timeout=10;
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
        $http_respond = curl_exec($ch);
        $http_respond = trim( strip_tags( $http_respond ) );
        $http_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
        if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
            echo $http_code;
        } else {
            echo $http_code;
        }
        curl_close( $ch );
        
     }

   


 















}
