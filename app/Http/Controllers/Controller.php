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
     * @return mixed
     */
    public function sendAjaxFailure($message=null)
    {
        $sendMessage = $message ? $message : 'failure';

        if (Request::ajax())
        {
            return Response::json(['status' => 500, 'message' => $sendMessage]);
        }
    }

    /**
     * Sends standard ajax request success response with optional message string
     * @param null|string $message
     * @return mixed
     */
    public function sendAjaxSuccess($message=null)
    {
        $sendMessage = $message ? $message : 'success';
        if (Request::ajax())
        {
            return Response::json(['status' => 200, 'message' => $sendMessage]);
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
