<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests, AuthorizesRequests;


    public function __construct()
    {
        //Make a $signedIn boolean available in every view
        //as long as the controller which returns it calls parent::__construct()
        view()->share('signedIn', Auth::check());
        //Make a $user model available in every view
        view()->share('user', Auth::user());
    }

    /**
     * Sends standard ajax request failure response with optional message string.
     * @param null|string $message
     * @param null|array $otherItems Array of items to include in the response
     * @return \Illuminate\Http\JsonResponse|boolean
     */
    public function sendAjaxFailure($message = null, $otherItems = null)
    {
        $sendMessage = $message ? $message : 'failure';
        $response = [
            'status' => 'fail',
            'message' => $sendMessage
        ];

        if ( ! is_null($otherItems) && is_array($otherItems) )
        {
            foreach ( $otherItems as $k => $v )
            {
                $response[ $k ] = $v;
            }
        }

        if ( Request::ajax() )
        {
            return Response::json($response);
        }
        return false;
    }

    /**
     * Sends standard ajax request success response with optional message string
     * @param null|string $message
     * @param null|array $otherItems Array of items to include in the response
     * @return \Illuminate\Http\JsonResponse|boolean
     */
    public function sendAjaxSuccess($message = null, $otherItems = null)
    {
        $sendMessage = $message ? $message : 'success';
        $response = [
            'status' => 'success',
            'message' => $sendMessage
        ];

        if ( ! is_null($otherItems) && is_array($otherItems) )
        {
            foreach ( $otherItems as $k => $v )
            {
                $response[ $k ] = $v;
            }
        }
        if ( Request::ajax() )
        {
            return Response::json($response);
        }
        return false;
    }


    /**
     * Call this inside a method that is still being developed.
     * Returns an abort message if the environment is production.
     * Should never really be necessary to use this if git is managed
     * properly. But just in case....
     */
    public
    function featureInDevelopment()
    {
        if ( env('APP_ENV') == 'production' )
        {
            abort(403);
        }
    }

//    protected function checkAuthorizationAndSmiteEvilDoers($objectOrArrayOfObjectsWhichIsOwned)
//    {
//        //Normalize
//        if( ! is_array($objectOrArrayOfObjectsWhichIsOwned) )
//        {
//            $objectOrArrayOfObjectsWhichIsOwned = [$objectOrArrayOfObjectsWhichIsOwned];
//        }
//
//        //Run gate check on each of the objects
//        foreach($objectOrArrayOfObjectsWhichIsOwned as $object)
//        {
//            if( Gate::denies('access-object', $object) )
//            {
//                abort(403);
//            }
//        }
//
//    }
}
