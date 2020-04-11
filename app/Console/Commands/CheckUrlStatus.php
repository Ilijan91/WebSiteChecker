<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Url;
use App\CheckStatus;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\TransferStats;

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
    public function handle(){
    
    $urls=Url::select('id','url','check_frequency')->get();

        foreach($urls as $url){       
            $statusTime= CheckStatus::latest()->where('url_id',$url->id)->first();
           
            if($statusTime == null){
               $this->saveStats($url);
            }else{
                $checkFrequency=$url->check_frequency;
                $currentTime= Carbon::parse(Carbon::now()->addSeconds(30));
                $updateTime=Carbon::parse($statusTime->updated_at);
                $differenceInMinutes=$currentTime->diffInMinutes($updateTime);
                //Log::debug($currentTime . ' and updated time is   ' . $updateTime . '    diference in minutes ' .$differenceInMinutes );
                if($differenceInMinutes == $checkFrequency){
                    $this->saveStats($url);
                } 
            }  
        }  
    }

    private function saveStats($url){
     
        $client = new \GuzzleHttp\Client();
           
           $client->request('GET', $url->url, [
            'http_errors' => false,
            'on_stats' => function (TransferStats $stats) use ($url, $client){
                try{
                    $request = $client->get($url->url);
                    $statusCode = $request->getStatusCode();
                    $statusReason= $request->getReasonPhrase();
                    $statusResponseTime= $stats->getTransferTime();
                }catch(RequestException $e){
                    if($e->getResponse()){
                        $statusCode = $stats->getResponse()->getStatusCode();
                        $statusReason = $stats->getResponse()->getReasonPhrase();
                        $statusResponseTime= $stats->getTransferTime();
                    }
                }
                $statusSave= new CheckStatus();
                $statusSave->url_id = $url->id;
                $statusSave->status = $statusCode;
                $statusSave->reason = $statusReason;
                $statusSave->time = $statusResponseTime;
                $statusSave->save();  

                $url=Url::find($url->id);
                    if($statusCode != 200 && $url->project->user->notification_preference != 'Do not notify'){
                        $user = $url->project->user;
                        $project=$url->project->name;
                        $user->notify(new \App\Notifications\ProjectDown($user,$url->url,$statusReason,$project));
                    }  
            }    
        ]);
    }

    

  

    
}
