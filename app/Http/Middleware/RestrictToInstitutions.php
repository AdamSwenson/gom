<?php

namespace App\Http\Middleware;

use App\Exceptions\UnpermittedDomainException;
use Closure;

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
    const REDIRECT_TO_ROUTE = 'registrationRestrictions';
    /** The view to send rejected folks to  */
    const REDIRECT_VIEW = 'account.permittedInstitutions';

    /** @var array Institutions which are okay */
    public static $permittedDomains = [
        'csun.edu'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Only apply this middleware to registration requests
        if (! $request->is('auth/register')){ return $next($request); }

        //Only apply to post requests
        if(! $request->isMethod('post')){ return $next($request); }

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
            //If any of the conditions failed, redirect
            return $this->refuseRequest($request);
        }
    }


    /**
     * Set error message and redirect back to an information page
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function refuseRequest($request)
    {
        //Return the email address to pre populate the form on the waiting list page
        $email = $request->has('email') ? $request->input('email') : '';

        return view(self::REDIRECT_VIEW)->with('email', $email);
//        return redirect( self::REDIRECT_TO_ROUTE )->with('email', $email);
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
}
