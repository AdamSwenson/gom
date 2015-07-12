<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 5:02 PM
 */

namespace ExamClasses\service;

/**
 * Interface IExamStatusManager
 * Managers for locked and released status changes on exams
 * @package ExamClasses\service
 */
interface IExamStatusManager
{

    public function execute(\RequestClasses\IRequest $request);

}