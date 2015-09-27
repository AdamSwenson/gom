<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 9/27/15
 * Time: 3:08 PM
 */

namespace App\Repositories\Question;

use App\Exam;
use App\QuestionAssignment;

/**
 * Generator for getting all questions associated with an exam
 *
 * @package QuestionClasses\service
 */
class QuestionsForExamGenerator
{

    /**
     * Returns a generator object with each question assigned to the exam
     * @param Exam $exam
     * @return \Generator
     */
    public function __invoke(Exam $exam)
    {
        $questionAssignments = QuestionAssignment::onExam($exam->getId())
            ->orderBy('question_number')
            ->get();

        foreach ($questionAssignments as $qa) {
            yield $qa->getQuestion();
        }
    }
}