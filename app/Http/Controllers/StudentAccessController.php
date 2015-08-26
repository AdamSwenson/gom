<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAccessRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class StudentAccessController
 *
 * Ummm actually, this may be deprecated.....
 * Probably should be using publicFeedbackController
 *
 *
 *
 *
 *
 * This handles the events when a student logs in to see their feedback.
 *
 * It corresponds to the old OutputClasses stuff.
 *
 * @package App\Http\Controllers
 */
class StudentAccessController extends Controller
{
    const QUESTION_CHART_HEIGHT = '400px';
    const QUESTION_CHART_WIDTH = '800px';

    /**
     * Returns the landing page for student access
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Display the feedback for the student.
     *
     * @param StudentAccessRequest $request
     * @return Response
     */
    public function show(StudentAccessRequest $request)
    {
        try
        {
//            throw new \Exception('jjj');
            $data = [
                'grade' => 'B-',
                'questions' => [
                    0 => [
                        'questionName' => "Question name text",
                        'questionNumber' => "4",
                        'comparisonMean' => 5.4,
                        'score' => 4.5,
                        'elements' => [
                            0 => [
                                'elementName' => 'Element name text',
                                'commentText' => 'Comment text for this element is this paragraph. It is.',
                                'comparisonMean' => 3.3,
                                'score' => 4.2
                            ],
                            1 => [
                                'elementName' => 'Element name text for second',
                                'commentText' => 'Comment text for this second element is this paragraph. It is.',
                                'comparisonMean' => 6.3,
                                'score' => 4.56
                            ]
                        ]
                    ]
                ]
            ];
            return view('feedback.feedback', compact('data'));


        } catch (\Exception $e)
        {

            return $this->notLoggedIn();
        }
    }

    /**
     * Directs to form where can enter the id and credentials
     */
    public function notLoggedIn()
    {
        return view('feedback.login');
    }

}
