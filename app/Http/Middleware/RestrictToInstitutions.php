<?php

namespace App\Http\Middleware;

use App\Exceptions\UnpermittedDomainException;
use App\Http\Requests\AuthRequest;
use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * This prevents sign up attempts from succeeding if the person enters an
 * email address from a non-permitted institution.
 *
 * If they are not from a permitted institution, they are redirected to a page where they can sign
 * up to be notified when access is expanded.
 *
 * @package App\Http\Middleware
 */
class RestrictToInstitutions
{
    /** The file holding a list of permitted domains */
    const PERMITTED_DOMAINS_CSV = 'permittedDomains.csv';
    /** The route to call to send rejected folks to  */
    const REDIRECT_TO_ROUTE = 'show-restricted-registration-page'; //'registrationRestrictions';
    //returning a view from middleware creates problems. don't do this
//    const REDIRECT_VIEW = 'account.permitted_institutions';


    /** @var array Institutions which are okay */
    public static $permittedDomains = [];

    protected $validator;

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->readPermittedList();

        //Only apply this middleware to registration requests
        if (! $request->is('register')){ return $next($request); }

        //Only apply to post requests
        if(! $request->isMethod('post')){ return $next($request); }

        //Make sure the request contains a valid email,
        //otherwise pass it on so that the main validator can handle it
        $this->validate($request);
        if(isset($this->validator) && $this->validator->fails())
        {
            return $next($request);
        }

        try
        {
            if (!$request->has('email')) { throw new UnpermittedDomainException('none-email_not_set'); }

            //extract the domain from the incoming email
            $domain = $this->extractDomain($request->input('email'));

            if (empty($domain)) { throw new UnpermittedDomainException('none-no_domain'); }

            //check whether domain is in list of permitted domains
            //return the request if it is
            if (in_array($domain, self::$permittedDomains))
            {
                return $next($request);
            }

            //Log the attempted domain
            throw new UnpermittedDomainException($domain);

        } catch (UnpermittedDomainException $e)
        {
//            Log::info($e->getMessage());
            //If any of the conditions failed, redirect
            return $this->refuseRequest($request);
        }
    }

    /**
     * Get a validator for an incoming registration request.
     * This duplicates what the authController does.
     *
     * This is necessary because this middleware runs before the authController
     * validation. There is no sense rewriting the controller logic, since eventually
     * this middleware step will be removed.
     *
     * The problem that this addresses is that, without it: If the email address is invalid,
     * this middleware will interpret the address as a restricted institution and send the
     * user to that informational page. That could be confusing if they were from the acceptable
     * institutions and just mistyped.
     *
     * Thus this is responsible for sending them back to the account creation page if the email address is wonky.
     *
     * @param  $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validate($request)
    {
        $rules = [
            'email' => 'required|email|max:255|unique:users'
        ];

        $messages = [
        ];

        $this->validator = Validator::make($request->all(), $rules, $messages);
        
    }


    /**
     * Set error message and redirect back to an information page
     * @param $request
     * @return $this
     */
    protected function refuseRequest($request)
    {
        //Return the email address to pre populate the form on the waiting list page
        $email = $request->has('email') ? $request->input('email') : '';

//        return redirect()->action('RestrictedRegistrationController@showRestrictedAccessPage', ['email' => $email]);
return redirect()->route(self::REDIRECT_TO_ROUTE)->withInput(); //['email' => $email] ); //->with();

       // return view(self::REDIRECT_VIEW)->with('email', $email);
 //f       return redirect( self::REDIRECT_TO_ROUTE )->with(['email' => $email]);
    }


    /**
     * Extracts the domain from a string email, casts it to lower case, trims whitespace
     * and returns it
     * @param $emailString
     * @return string
     */
    protected function extractDomain($emailString)
    {
        list($user, $domain) = explode('@', $emailString);
        if ($domain)
        {
            return mb_strtolower(trim($domain));
        }
    }

    /**
     * Checks whether the list of permitted domains is empty. If it is, it reads the file
     * holding the list of permitted email domains into the array
     */
    protected static function readPermittedList()
    {
        if(empty(self::$permittedDomains))
        {
            self::$permittedDomains = str_getcsv(Storage::get(self::PERMITTED_DOMAINS_CSV), "\n");
        }
    }
}
