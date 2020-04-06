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
    public function __construct(Invite $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $invite=$this->invite;
        $team=Team::findOrFail($this->invite->team_id);
        $user=User::findOrFail($this->invite->user_id);
        return $this->from($user->email)
                    ->view('emails.invite',compact('user','invite','team'));
        
    }
}
