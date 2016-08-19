<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/16/16
 * Time: 4:10 PM
 */
namespace App\Repositories\Utilities;



/**
 * Class JsDataPreparation
 * Handles preparation of data into format expected by javascript
 *
 * @package App\Repositories\Utilities
 */
interface IJsDataPreparation
{
    /**
     * Builds the json object containing questions which the page js expects
     * Also injects the object into the view as GOM.questions
     * @param Exam $exam
     * @return string
     */
    public function makeQuestionsJson($questionAssignments);

    /**
     * Builds the json object containing students which the page js expects
     * Also injects the object into the view as GOM.students
     * @param Exam $exam
     * @return string
     */
    public function makeStudentJson($students);

    /**
     * Makes the object which the page's javascript expects.
     * Also injects the object into the view GOM.stockComments
     * @param $allElements
     * @return array
     */
    public function makeStockCommentsJson($allElements);

    /**
     * Makes json of standard grade values
     * Also injects into view as GOM.grades
     * @return string
     */
    public function makeGradesJson();
}