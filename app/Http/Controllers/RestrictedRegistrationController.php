<?php

namespace App\Http\Controllers;

use App\Http\Requests\WaitlistRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Since at the outset we will be restricting who can register,
 * this controller will handle notifying the poor souls who must wait
 * and recording email addresses from those interested in a waitlist.
 *
 * It does not handle checking permission to register. That is done by
 * middleware applied to AuthController
 *
 * @package App\Http\Controllers
 */
class RestrictedRegistrationController extends Controller
{
    const SUCCESS_MESSAGE = "Thank you! We will notify you when the gradeomatic is available.";

    /**
     * Displays the restricted access page with information about
     * who may register and a form with which to be wait listed
     */
    public function showRestrictedAccessPage()
    {
        return view('account.permittedInstitutions');
    }

    /**
     * Records those wishing to be notified of expanded access to
     * the database
     * @param WaitlistRequest|Request $request
     * @return \Illuminate\View\View
     */
    public function recordInterestToWaitlist(WaitlistRequest $request)
    {
        //Check optional fields
        $name =  $request->has('name') ? $request->input('name') : null;
        $institution = $request->has('institutionType') ? $request->input('institutionType') : null;
        //Write to db
        $this->record($request->input('email'), $name, $institution);
        //Notify of success (even if failed)
        return $this->notifyRecorded();
    }

    /**
     * Sets the message into the session and returns them to the page
     * @return \Illuminate\View\View
     */
    protected function notifyRecorded()
    {
        return redirect('registrationRestrictions')->with('message', self::SUCCESS_MESSAGE);
    }

    /**
     * Handles actual recording to the database
     *
     * @param $email
     * @param null $name
     * @param null $institutionType
     */
    protected function record($email, $name=null, $institutionType=null)
    {
        DB::table('waitlist')->insert(
            [
                'email' => $email,
                'requesterName' => $name,
                'institutionType' => $institutionType
            ]);
    }
}
