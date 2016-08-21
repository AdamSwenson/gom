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

use App\Repositories\Element\IElementRepository;

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
    protected $elementDao;


    /**
     * Builds the json object containing questions which the page js expects
     * Also injects the object into the view as GOM.questions
     * @param \App\Repositories\Utilities\Exam $questionAssignments
     * @param bool $encode
     * @param bool $inject
     * @return string
     */
    public function makeQuestionsJson($questionAssignments, $encode = true, $inject = false)
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

        if ( $inject )
        {
            Javascript::put(['questions' => $questions]);
        }

        $questions = $encode ? json_encode($questions, JSON_FORCE_OBJECT) : $questions;

        return $questions;
    }


    /**
     * Builds the json object containing students which the page js expects
     * Also injects the object into the view as GOM.students
     * @param $students Collection
     * @param bool $encode
     * @param bool $inject
     * @return string
     */
    public function makeStudentJson($students, $encode = true, $inject = false)
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

        if ( $inject )
        {
            Javascript::put(['students' => $s]);
        }

        $s = $encode ? json_encode($s, JSON_FORCE_OBJECT) : $s;

        return $s;
    }

    /**
     * Makes the object which the page's javascript expects.
     * Also injects the object into the view GOM.stockComments
     * @param $allElements
     * @param bool $encode
     * @param bool $inject
     * @return array
     */
    public function makeStockCommentsJson($allElements, $encode = true, $inject = false)
    {
        $this->elementDao = app()->make(IElementRepository::class);

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

        if ( $inject )
        {
            Javascript::put(['stockComments' => $stockComments]);
        }

        $stockComments = $encode ? json_encode($stockComments, JSON_FORCE_OBJECT) : $stockComments;

        return $stockComments;
    }

    /**
     * Makes json of standard grade values
     * Also injects into view as GOM.grades
     * @param bool $encode
     * @param bool $inject
     * @return string
     */
    public function makeGradesJson($encode = true, $inject = false)
    {
        if ( $inject )
        {
            Javascript::put(['grades' => GradeFactory::gradeJson()]);
        }

        return $encode ?  GradeFactory::gradeJson() : GradeFactory::$grades;
    }


}