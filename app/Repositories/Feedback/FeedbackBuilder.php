<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/31/15
 * Time: 5:55 PM
 */

namespace Repositories\Feedback;


class FeedbackBuilder
{

    public $feedback = [];


    public function __construct()
    {

    }

    /**
     * Creates the feedback structure
     */
    public function buildFeedback($accessKey)
    {
        $numberQuestions = 4;


        for ($i = 1; $i <= $numberQuestions; $i++)
        {
            $questionTitle = 'text';

            $feedback = [
                $accessKey => [
                ]
            ]
            ];

        }
    }

    /**
     * Builds an array of feedback for a single student on the exam
     */
    public function buildStudent($examName, $grade, $questionsArray)
    {

        $this->buildTopLevelContent($studentArray, $examName, $grade);
        foreach($questionsArray as $){
            $this->buildQuestion($studentArray, $q['questionNumber'], $q['questionTitle'], $q['commentsArray']);
        }

    }


    /**
     * Adds data to the outermost area of a student's array
     * @param $studentArray
     * @param $examName
     * @param $grade
     */
    public function buildTopLevelContent(&$studentArray, $examName, $grade)
    {
        $studentArray['examName'] = $examName;
        $studentArray['grade'] = $grade;
    }


    /**
     * Adds an entry for a question to the studentArray
     * @param $studentArray
     * @param $questionNumber
     * @param $questionTitle
     * @param $commentsArray
     * @return mixed
     */
    public function buildQuestion(&$studentArray, $questionNumber, $questionTitle, $commentsArray)
    {
        $studentArray["question_{$questionNumber}"] =
            [
                'questionTitle' => $questionTitle,
                'comments' => $commentsArray
            ];
        return $studentArray;
    }



}