<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/17/16
 * Time: 12:45 PM
 */

namespace App\Repositories\Utilities;

use Javascript;

/**
 * Makes the objects expected by the client's javascript
 * @package App\Repositories\Utilities
 */
class JsDataHandler
{

    /**
     * Injects the array into the page using laracasts/utilities
     * javascript tool.
     * @param $dataArray
     * @param $key
     */
    protected function inject($dataArray, $key)
    {
        Javascript::put([$key => $dataArray]);
    }

    /**
     * Encodes the array as Json
     * @param $dataArray
     * @return string
     */
    protected function encode($dataArray)
    {
        return json_encode($dataArray, JSON_FORCE_OBJECT);
    }

    /**
     * Builds the json object containing questions which the page js expects
     * Also injects the object into the view as GOM.questions
     * @return string
     */
    public function makeQuestions($questionAssignments,  $encode = false, $inject = false)
    {
//        $questionAssignments = $this->questionAssignmentDao->load_all_for_exam($exam->getId());

        $questionIndex = 0;
        $questions = [];
        foreach ( $questionAssignments as $qa )
        {
            $questions[ $questionIndex ] = [
                'questionIndex'        => $questionIndex,
                'questionName'         => $qa->getQuestionName(),
                'questionNumber'       => $qa->getQuestionNumber(),
                'maxScore'             => $qa->getQuestion()->getMaxScore(),
                'questionAssignmentId' => $qa->id,
            ];
            $questionIndex++;
        }

        //send to page
        if ( $inject )
        {
            $this->inject($questions, 'questions');
        }

        //encode if requested
        $questions = $encode ? $this->encode($questions) : $questions;

        return $questions;
    }


    /**
     * Builds the json object containing students which the page js expects
     * Also injects the object into the view as GOM.students
     * @return string
     */
    public function makeStudent($students, $encode = false, $inject = false)
    {
        $studentIndex = 0;
        $s = [];
        foreach ( $students as $student )
        {
            $s[ $studentIndex ] = [
                'studentIndex'      => $studentIndex, //this is here so can use with component
                'studentId'         => $student->id,
                'studentIdentifier' => $student->student_identifier,
                'firstName'         => $student->first_name,
                'lastName'          => $student->last_name,
            ];
            $studentIndex++;
        }

            //send to page
            if ( $inject )
            {
                $this->inject($s, 'students');
            }

        //encode if requested
        $s = $encode ? $this->encode($s) : $s;

        return $s;

    }

    /**
     * Makes the object which the page's javascript expects.
     * Also injects the object into the view GOM.stockComments
     * @param $allElements
     * @return array
     */
    public function makeStockComments($allElements, $encode = false, $inject = false)
    {
        // load stock comments for each element
        $stockComments = [];
        foreach ( $allElements as $aQuestion )
        {
            foreach ( $aQuestion as $element )
            {
                $defaultComments = null;
                for ( $i = 0; $i < count(Comment::$valences); $i++ )
                {
                    $defaultComments[] = $this->elementDao->loadCommentByElementIdAndValence($element->getId(), $i)->getBody();
                }
                $stockComments[] = $defaultComments;
            }
        }

        //send to page
        if($inject){
            $this->inject($stockComments, 'stockComments');
        }

        //encode if requested
        $stockComments = $encode ? $this->encode($stockComments) : $stockComments;

        return $stockComments;
    }

    /**
     * Makes json of standard grade values
     * Also injects into view as GOM.grades
     * @return string
     */
    public function makeGrades( $encode = false, $inject = false)
    {
        //send to page
//        Javascript::put(['grades' => GradeFactory::gradeJson()]);

        return GradeFactory::gradeJson();
    }


//
//foreach ( $questionAssignments as $qAssignment )
//{
//$qNumber = $qAssignment->getQuestionNumber();
//$qIndex = $qNumber - 1;
//$allElements[] = $this->elementAssignmentDao->load_elements($exam->getId(), $qNumber);
//    // load maxQuestionScores
//$maxQuestionScores[ $qIndex ] = $qAssignment->getQuestion()->getMaxScore();
//
//}
//
//// load all current student scores & comments
//$allElementAssignments = $this->elementAssignmentDao->load_by_exam($exam->getId());
//foreach ( $students as $student )
//{
//    // load element scores & element comments for each student
//    $elementScores = null;
//    $elementComments = null;
//    foreach ( $allElementAssignments as $eleAssignment )
//    {
//        $aCommentScore = $this->elementScoreDao->load($eleAssignment->getElementAssignmentId(), $student->getId());
//        if ( isset($aCommentScore->score) )
//        {
//            $aScore = $aCommentScore->getScore();
//        } else
//        {
//            $aScore = null;
//        }
//        $elementScores[] = $aScore;
//
//        // grab the student-specific comment for this element
//        if ( isset($aCommentScore->comment_text) )
//        {
//            $aCommentText = $aCommentScore->comment_text;
//        } else
//        {
//            $aCommentText = "";
//        }
//        $elementComments[] = $aCommentText;
//    }
//    $studentElementScores[] = $elementScores;
//    $studentElementComments[] = $elementComments;

    public function makeQuestionScores($questionAssignments)
{
//    // load question scores for each student
//    $questionScores = null;
//    foreach ( $questionAssignments as $questionAssignment )
//    {
//        $aScore = $this->questionScoreDao->load($questionAssignment->getId(), $student->getId());
//        if ( isset($aScore->score) )
//        {
//            $aScore = $aScore->getScore();
//        } else
//        {
//            $aScore = null;
//        }
//        $questionScores[] = $aScore;
//    }
//    $studentQuestionScores[] = $questionScores;
}

    public function makeGradingTimes($examGradingTimes, $encode = false, $inject = false )
{

//        $examGradingTimes[] = $this->gradingTimeDao->load($exam->getId(), $student->getId())->seconds;

}

}