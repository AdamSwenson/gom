<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class UserLoginNotification extends Notification
{
    use Queueable;
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', 'https://laravel.com')
//                    ->line('Thank you for using our application!');
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


    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->user->id,
            'name'    => $this->user->name,
        ];
    }

    public function toSlack($notifiable)
    {
        $prefix = env("APP_ENV") != "production" ? '[DEV] ' : '';
        return (new SlackMessage)
            ->content($prefix . 'User logged in . ' . $this->user->name . " userid:" . $this->user->id);
    }

}
