<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeEmail extends Notification
{
    use Queueable;

    const SUBJECT_LINE = 'Welcome to the Gradeomatic!';
    /**
     * @var User
     */
    private $user;

    /**
     * Create a new notification instance.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'slack'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject(self::SUBJECT_LINE)
            ->greeting("Hello {$this->user->name},")
            ->line("Welcome to the Gradeomatic! ")
            ->line("Soon you'll be grading faster, giving your students helpful comments, and collecting the data that will help you teach better . ")
            ->action("View getting started guide", "https://www.gradeomatic.net/gettingStarted");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
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
            ->content($prefix . 'New user signed up. ' . $this->user->name);
    }


}
