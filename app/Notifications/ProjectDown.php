<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectDown extends Notification
{
    use Queueable;
    public $user;
   public $url;
   public $visibility;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user,$url,$visibility)
    {
        $this->user=$user;
        $this->url=$url;
        $this->visibility=$visibility;
       
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        
        return $notifiable->notification_preference;
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
            'user_id'=> $this->user->id,
            'username'=> $this->user->name,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
