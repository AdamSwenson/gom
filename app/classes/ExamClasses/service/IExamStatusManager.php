<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 5:02 PM
 */

namespace App\classes\ExamClasses\service;

use App\classes\RequestClasses\IRequest;

/**
 * Interface IExamStatusManager
 * Managers for locked and released status changes on exams
 * @package App\classes\ExamClasses\service
 */
interface IExamStatusManager
{

    public function execute(IRequest $request);

}