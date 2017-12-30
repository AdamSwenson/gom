<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Models\Preferences\UserPreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPreferencesController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();

    }

    /**
     * @return UserPreferences
     */
    protected function initializePreferences()
    {
        //if no preferences object exists, make one with defaults
        $p = new UserPreferences();
        $p->preferences = UserPreferences::$defaultPreferences;
        $p->save();
        return $p;
    }

    /**
     * @return $this|UserPreferences
     */
    protected function loadPreferences()
    {
        $p = UserPreferences::where('user_id', Auth::id())->first();
        if ( is_null($p) ) {
            //if no preferences object exists, make one with defaults
            $p = $this->initializePreferences();
        }
        return $p;
    }

    /**
     * Returns json of the preferences
     * for the grading page.
     *
     * @return UserPreferencesController|UserPreferences
     */
    public function index()
    {
        $p = $this->loadPreferences();
        return $p->preferences;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function store( Request $request )
    {
        //we will be receiving a payload object
        //with updateProp and updateVal
        //containing the relevant data

        //get existing preferences or initialized to defaults
        $p = $this->loadPreferences();

        $pl = $request->input('payload');
        $preferenceToUpdate = $pl['updateProp'];
        $newValue = $pl['updateVal'];

        $p->setPreference($preferenceToUpdate, $newValue);

        $p->save();

        return $this->sendAjaxSuccess();

    }
}
