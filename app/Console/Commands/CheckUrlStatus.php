<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Url;
use App\CheckStatus;


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




        $urls=Url::select('id','url','check_frequency')->get();

        foreach($urls as $url){

            if (! filter_var($url->url, FILTER_VALIDATE_URL)) {
                throw new \Exception("Invalid URL '$url->url'");
            }

            if($url->check_frequency == 1){
                try {

                    $response = Http::get($url->url);
                    $expected = $response->successful();;
                    $status = $response->status();
                    
                } catch (\Exception $e) {
                    $this->error("Response status failed with an exception");
                     $this->error($e->getMessage());
                     return 2;
                    
                }
        
                if (1 != $expected) {
                     $this->error("Response status failed  with a status of '$status' (expected '$expected')");
                     return 1;
                    
                }
        
                 $this->info("Response status passed for $url->url");
               
                $statusSave= new CheckStatus();
                $statusSave->url_id = $url->id;
                $statusSave->status = $status;
                $statusSave->save();
            }
        } 
    }



  

    
}
