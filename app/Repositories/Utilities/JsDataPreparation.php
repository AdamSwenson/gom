<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/16/16
 * Time: 4:08 PM
 */

namespace App\Repositories\Utilities;
use App\Exam;

use App\Comment;

use App\Repositories\Grade\GradeFactory;
use App\Repositories\Grade\IGradeAssignmentRepository;
use App\Repositories\Question\IQuestionAssignmentRepository;
use App\Repositories\Element\IElementAssignmentRepository;
use App\Repositories\Element\IElementRepository;
use App\Repositories\Score\IElementScoreRepository;
use App\Repositories\Score\IQuestionScoreRepository;
use App\Repositories\Student\IStudentRepository;
use App\Repositories\Time\IGradingTimeRepository;

use Illuminate\Database\Eloquent\Collection;

use Javascript;

/**
 * Class JsDataPreparation
 * Handles preparation of data into format expected by javascript
 *
 * @package App\Repositories\Utilities
 */
class JsDataPreparation implements IJsDataPreparation
{


    /**
     * Builds the json object containing questions which the page js expects
     * Also injects the object into the view as GOM.questions
     * @param \App\Repositories\Utilities\Exam $questionAssignments
     * @return string
     */
    public function makeQuestionsJson($questionAssignments)
    {

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

        Javascript::put(['questions' => $questions]);

        return json_encode($questions, JSON_FORCE_OBJECT);
    }


    /**
     * Builds the json object containing students which the page js expects
     * Also injects the object into the view as GOM.students
     * @param $students Collection
     * @return string
     */
    public function makeStudentJson($students)
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
        Javascript::put(['students' => $s]);

        return json_encode($s, JSON_FORCE_OBJECT);

        // load all question assignments and all elements for those questions

    }

    /**
     * Makes the object which the page's javascript expects.
     * Also injects the object into the view GOM.stockComments
     * @param $allElements
     * @return array
     */
    public function makeStockCommentsJson($allElements)
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
        Javascript::put(['stockComments' => $stockComments]);

        $stockComments = json_encode($stockComments, JSON_FORCE_OBJECT);

        return $stockComments;
    }

    /**
     * Makes json of standard grade values
     * Also injects into view as GOM.grades
     * @return string
     */
    public function makeGradesJson()
    {
        //send to page
        Javascript::put(['grades' => GradeFactory::gradeJson()]);

        return GradeFactory::gradeJson();
    }



}