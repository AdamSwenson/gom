<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/22/15
 * Time: 3:53 PM
 */

namespace App\Jobs\NewUser;

use App\Mail\NewUserWelcome;
use App\User;
use App\Jobs\Job;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;


/**
 * Sends the welcome email to the newly registered user.
 *
 * @package App\Jobs\NewUser
 */
class SendWelcomeEmail extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;



    /** @var User  */
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
        Mail::to($to_address)
            ->queue(new NewUserWelcome($this->user));

//        Mail::send(self::EMAIL_TEMPLATE, ['user' => $user], function ($message) use($to_address, $to_name)
//        {
//            $message->to($to_address, $to_name)->subject(self::SUBJECT_LINE);
//        });
    }
}