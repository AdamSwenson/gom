<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/22/15
 * Time: 3:53 PM
 */

namespace App\Jobs\NewUser;

use App\User;
use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;


class SendWelcomeEmail extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param  User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $to_address = $this->user->email;
        $to_name = $this->user->name;
        $user = $this->user;

        Mail::queue('emails.welcome', ['user' => $user], function ($message) use($to_address, $to_name)
        {
            $message->to($to_address, $to_name)->subject('Welcome to the Gradeomatic!');
        });
    }
}