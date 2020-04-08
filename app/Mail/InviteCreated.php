<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Invite;
use App\Team;
use App\User;

class InviteCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invite,$declinedByUser=null)
    {
        $this->invite = $invite;
        $this->declinedByUser=$declinedByUser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $invite=$this->invite;    
        $team=Team::findOrFail($invite->team_id);
        if($invite->user_id != null){
            $user=User::findOrFail($invite->user_id);
            return $this->from($user->email)
                        ->view('emails.invite',compact('user','invite','team'));
        }else{
            $user=User::select()->where('email', $this->declinedByUser->email)->get();
            
            if(!empty($user[0])){
                return $this->from($user[0]->email)
                            ->view('emails.deny',compact('user','team'));
            }else{
               return $this->from($this->declinedByUser->email)
                            ->view('emails.notRegistrated')->with('email',$this->declinedByUser->email); 
            }
            
        }

    }
}
