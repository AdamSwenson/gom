<?php

namespace App\Http\Controllers;

use App\Exam;
use App\Jobs\AsyncStorage\UpdateAllStoredExamStats;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Jobs\Export\ExportScores;

/**
 * Controls utility functions which can be activated
 * by hitting a public route.
 * @package App\Http\Controllers
 */
class UtilityController extends Controller
{
    protected static $numRuns = 0;
    protected static $lastRun = null;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dispatches the job to update all stored exam stats
     */
    public function updateExamCounts(){
        if(Auth::user() && $this->throttleRequests()){
            $this->dispatch(new UpdateAllStoredExamStats());
            Log::info('updateExamCounts ran from manual request by user #' . Auth::user()->id);
        }
    }

    public function exportExamScores(Exam $exam){
        $user = Auth::user();
        if($user->owns($exam))
        {
            $exporter = app()->make('ExportScores');
//            dispatch(new ExportScores($exam));

            $exporter->handle($exam);
        }
    }

    /**
     * Will prevent expensive jobs from being called
     * multiple times within a short timeframe
     * TODO Implement throttling for utility controller
     */
    protected function throttleRequests(){
        return true;
    }

}
