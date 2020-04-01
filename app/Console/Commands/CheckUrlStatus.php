<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Url;
use App\CheckStatus;
use GuzzleHttp\Exception\RequestException;
use Response;
use Carbon\Carbon;



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
    $statusTime= CheckStatus::select('id','url_id','updated_at')->get();

        foreach($urls as $url){     
            $checkFrequency=$url->check_frequency;
            if(count($statusTime) == 0){
                try {
                    $client = new \GuzzleHttp\Client([
                        'timeout' => 3.14,
                        'allow_redirects' => false,]);
                    $response = $client->request('GET', $url->url);
                    $status=$response->getStatusCode();
                    $reason=$response->getReasonPhrase();
                    }catch (RequestException $e) {
                        if ($e->hasResponse()) {
                            $response = $e->getResponse();
                            $status=$response->getStatusCode();
                            $reason=$response->getReasonPhrase();
                        } else {
                            $status=503;
                        }
                    }
                    $statusSave= new CheckStatus();
                    $statusSave->url_id = $url->id;
                    $statusSave->status = $status;
                    $statusSave->reason = $reason;
                    $statusSave->save();

                    $url=Url::find($url->id);
            
                    if($status != 200 && $url->project->user->notification_preference != 'Do not notify'){
                        $user = $url->project->user;
                        $project=$url->project->name;
                        $user->notify(new \App\Notifications\ProjectDown($user,$url->url,$reason,$project));
                    }
                    
                    $this->info("status saved for $url->url"); 
            }else{
                foreach($statusTime as $time){
                    if($url->id == $time->url_id){
                    $statusUpdated=Carbon::parse($time->updated_at);
                    $currentTime= Carbon::now();
                    $differenceInTime=$currentTime->diffInMinutes($statusUpdated);
                        if($differenceInTime == $checkFrequency){
                            try {
                                $client = new \GuzzleHttp\Client([
                                    'timeout' => 3.14,
                                    'allow_redirects' => false,]);
                                $response = $client->request('GET', $url->url);
                                $status=$response->getStatusCode();
                                $reason=$response->getReasonPhrase();
                                }catch (RequestException $e) {
                                    if ($e->hasResponse()) {
                                        $response = $e->getResponse();
                                        $status=$response->getStatusCode();
                                        $reason=$response->getReasonPhrase();
                                    } else {
                                        $status=503;
                                    }
                                }
                                $statusUpdate= new CheckStatus();
                                $statusUpdate->url_id = $url->id;
                                $statusUpdate->status = $status;
                                $statusUpdate->reason = $reason;
                                $statusUpdate->updated_at =$currentTime ;
                                $statusUpdate->save();

                            
                                $url=Url::find($url->id);
                                if($status != 200 && $url->project->user->notification_preference != 'Do not notify'){
                                    $user = $url->project->user;
                                    $project=$url->project->name;
                                    $user->notify(new \App\Notifications\ProjectDown($user,$url->url,$reason,$project));
                                }
                                
                                $this->info("status updated for $url->url"); 
                        }
                    }
                } 
            }
        }  
    }



  

    
}
