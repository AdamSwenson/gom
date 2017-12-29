<?php

namespace App\Http\Controllers\Preferences;

use App\Http\Controllers\Controller;
use App\Models\Preferences\GradePreferences;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradePreferencesController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware('auth');
        $this->user = Auth::user();
    }

    /**
     * @return GradePreferences
     */
    protected function initializePreferences()
    {
        //if no preferences object exists, make one with defaults
        $p = new GradePreferences();
        $p->preferences = GradePreferences::$defaultPreferences;
        $p->save();
        return $p;
    }

    /**
     * @return $this|GradePreferences
     */
    protected function loadPreferences()
    {

        $p = GradePreferences::where('user_id', Auth::id())->first();
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
     * @return GradePreferencesController|GradePreferences
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
        //we will be recieving a payload object
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

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show( $id )
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit( $id )
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update( Request $request, $id )
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id )
    {
        //
    }
}
