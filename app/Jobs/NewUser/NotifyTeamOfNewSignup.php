<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 10/2/15
 * Time: 12:26 PM
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


/**
 * Notifies the production team that a new user has registered
 *
 * @package App\Jobs\NewUser
 */
class NotifyTeamOfNewSignup extends Job implements SelfHandling, ShouldQueue
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

    public function handle()
    {
        Mail::raw("new user {$this->user->name} signed up", function ($message){
            $message->to('gradeomatic@gmail.com', 'devteam')->subject('new registration');
        });
    }
}