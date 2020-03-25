<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Url;
use App\CheckStatus;
use GuzzleHttp\Exception\RequestException;


class CheckUrlStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'checkstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Runs an HTTP checkstatus to verify the url is available';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    $urls=Url::select('id','url')->get();

    foreach($urls as $url){
        try {
            $client = new \GuzzleHttp\Client([
                'timeout' => 20,
                'allow_redirects' => false,]);
            $response = $client->request('GET', $url->url);
            $status= $response->getStatusCode();
                
            } catch (RequestException $ex) {
                $status=$ex->getCode();
            }
            $statusSave= new CheckStatus();
            $statusSave->url_id = $url->id;
            $statusSave->status = $status;
            $statusSave->save();

            $this->info("status saved for $url->url"); 
           
        } 
         
    }



  

    
}
