<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 3:22 PM
 */

namespace App\Http\Controllers;


class SetupController extends Controller
{

    public function showExamCreate()
    {
        return view('setup/exam_create',
            [
                'pageTitle' => 'Create new exam'
            ]);
    }

    public function showQuestionCreate($numQuestions = 5)
    {
        return view('setup/question_create', [
            'numberOfQuestions' => $numQuestions,
            'pageTitle' => 'Setup questions',
            'inPageTitle' => "Create questions",
            'currentExamId' => 3,
            'currentExamString' => "Fake exam 3",
            'examOptions' => [
                ['optionId' => 1, 'optionValue' => 1, 'optionText' => 'display string for exam 1'],
                ['optionId' => 2, 'optionValue' => 2, 'optionText' => 'display string for exam 2']
            ]

        ]);
    }


    public function showElementCreate($numQuestions=5, $numSubtasks=3)
    {
        return view('setup/element_create', [
            'pageTitle' => 'Set up elements',
            "inPageTitle" => "Create questions tasks and configure comments",
            'currentExamId' => 3,
            'currentExamString' => "Fake exam 3",
            'examOptions' => [
                ['optionId' => 1, 'optionValue' => 1, 'optionText' => 'display string for exam 1'],
                ['optionId' => 2, 'optionValue' => 2, 'optionText' => 'display string for exam 2']
            ],
            'numberOfQuestions' =>$numQuestions,
            'numberOfSubtasks' =>$numSubtasks
        ]);
    }

}