<?php

namespace App\Http\Controllers\Feedback;

use App\AccessKey;

use App\Feedback;
use App\Http\Controllers\Controller;
use App\Student;
use Illuminate\Http\Request;

class PublicFeedbackControllerNew extends Controller
{

    /**
     * NewFeedbackController constructor.
     * @param ITotalScoreRepository $totalScoreRepository
     * @param INewFeedbackRepository $feedbackBuilder
     */
    public function __construct()
    {
        $this->middleware('guest');

    }


    public function show($accessKey){

        $f = Feedback::where('access_key', $accessKey)->first();
//        $out = $this->feedbackRepository->buildDataOutput($exam, $student);
        if($f){
            return view('new.newfeedback', $f->content);
        }else{
            echo('uh oh');
        }



    }


}
