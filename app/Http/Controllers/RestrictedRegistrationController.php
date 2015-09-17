<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
     * @param Request $request
     */
    public function recordInterestToWaitlist(Request $request)
    {
        return $this->notifyRecorded();

    }

    /**
     * Sets the message into the session and returns them to the page
     * @return \Illuminate\View\View
     */
    protected function notifyRecorded()
    {
//        return view('account.permittedInstitutions')->with('message', self::SUCCESS_MESSAGE);
        return redirect('registrationRestrictions')->with('message', self::SUCCESS_MESSAGE);
//        return back();
//        return back()->with(['message' =>self::SUCCESS_MESSAGE]);

    }
}
