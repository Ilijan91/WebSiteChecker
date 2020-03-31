<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\SlackMessage;


class ProjectDown extends Notification
{
    use Queueable;
    public $user;
    public $url;
    public $visibility;
    public $project;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$url,$visibility,$project)
    {
        $this->user=$user;
        $this->url=$url;
        $this->visibility=$visibility;
        $this->project=$project;
       
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        
        return explode(',', $notifiable->notification_preference);
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
       
        return (new MailMessage)
                    ->line($this->user->name)
                    ->line($this->url)
                    ->line($this->visibility)
                    ->action('Check your url', $this->url)
                    ->line('Thank you for using our WebSiteChecker!');
    }


    public function toDatabase($notifiable)
    {
       
        return [
            'project'=>$this->project,
            'url'=>$this->url,
            'status'=> $this->visibility,
        ];
    }

    public function toSlack($notifiable)
    {
        $project=$this->project;
        $user=$this->user;
        $url = $this->url;
        $visibility=$this->visibility;

        return (new SlackMessage)
                    ->success()
                    ->content('One of your project went down!')
                    ->attachment(function ($attachment) use ($project,$url,$user,$visibility) {
                        $attachment->title($project, $url)
                                    ->fields([
                                            'User' => $user->name,
                                            'Url' => $url,
                                            'Reason' => $visibility ,
                                            'Status' => ':-1:',
                                        ]);
                    });
    }

    
}


