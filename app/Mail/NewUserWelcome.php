<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Wrapper for the new user welcome email.
 * However, we are using the notification instead of this
 *
 *
 * Class NewUserWelcome
 * @package App\Mail
 */
class NewUserWelcome extends Mailable
{


    use Queueable, SerializesModels;

    const SUBJECT_LINE = 'Welcome to the Gradeomatic!';

    public $user;

    /**
     * Create a new message instance.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //from as the user's email?

//        Mail::send(self::EMAIL_TEMPLATE, ['user' => $user], function ($message) use($to_address, $to_name)
//        {
//            $message->to($to_address, $to_name)->subject(self::SUBJECT_LINE);
//        });

        return $this->subject(self::SUBJECT_LINE)
            ->view('emails.welcome');
    }
}
