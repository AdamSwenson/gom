<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 8/2/15
 * Time: 3:40 PM
 */
namespace App\Repositories\Feedback;

interface IFeedbackBuilder
{
    /**
     * Creates the feedback structure
     * This is the main publicly called method
     * @param integer $examId
     */
    public function buildFeedback($examId);
}