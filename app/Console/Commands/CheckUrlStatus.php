<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CheckStatus;
use App\Url;

class CheckUrlStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        
     $checkStatus= new CheckStatus();
    

     // FIND URL

     $urls = Url::select('url')->get();
    
     // check all url-s
        $statusesCode=[];
     foreach($urls as $url){
        $statusesCode[]=$checkStatus->checkUrl($url->url);
     }
     
   
     
            
     


     


    }
}
