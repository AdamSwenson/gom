<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Models\Preferences\SetupPreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetupPreferencesController extends Controller
{



    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    /**
     * @return SetupPreferences
     */
    protected function initializePreferences()
    {
        //if no preferences object exists, make one with defaults
        $p = new SetupPreferences();
        $p->preferences = SetupPreferences::$defaultPreferences;
        $p->save();
        return $p;
    }

    /**
     * @return $this|SetupPreferences
     */
    protected function loadPreferences()
    {
        $p = SetupPreferences::where('user_id', Auth::id())->first();
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
     * @return SetupPreferencesController|SetupPreferences
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
