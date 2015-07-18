<?php

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/17/15
 * Time: 2:28 PM
 */
use Illuminate\Database\Seeder;


/**
 * Class ItemAssignmentSeeder
 * Seeds the questionAssigner and elementAssigner tables
 */
class ItemAssignmentSeeder extends Seeder
{
    use SeederTraits;

    public $exams;
    public $questions;
    public $elements;

    public function run()
    {
        $this->setUp();
        $this->load();
        $this->populate_item_assignments();
    }

    public function load()
    {
        $this->exams = \ExamQuery::create()->find();
        $this->questions = \QuestionQuery::create()->find();
        $this->elements = \ElementQuery::create()->find();

        if ((!count($this->exams) > 0) || (!count($this->questions) > 0) || (!count($this->elements)))
        {
            throw new \Exception('could not load for assignment population');
        }
    }

    /**
     * Improved version which won't assign the same element to multiple questions
     * @param int $num_exams
     * @param int $num_questions
     * @param int $num_subtasks
     */
    public function populate_item_assignments($num_exams = 5, $num_questions = 5, $num_subtasks = 5)
    {
        try
        {
            for ($j = 0; $j < $num_exams; $j++)
            {
                $exam = $this->exams[$j];
                $element_counter = 0;
                for ($i = 1; $i <= $num_questions; $i++)
                {
                    try
                    {
                        $qa = \QuestionAssignerQuery::create()
                            ->filterByUser($this->user)
                            ->filterByExam($exam)
                            ->filterByQuestionnumber($i)
                            ->findOneOrCreate();
                        $qa->setQuestion($this->questions[$i]);
                        $qa->save();

                        for ($k = 1; $k <= $num_subtasks; $k++)
                        {
                            $ea = \ElementAssignmentQuery::create()
                                ->filterByUser($this->user)
                                ->filterByExam($exam)
                                ->filterByQuestion($this->questions[$i])
                                ->filterBySubtask($k)->findOneOrCreate();
                            $ea->setElement($this->elements[$element_counter]);
                            $ea->save();
                            $element_counter += 1;
                        }
                    } catch (\Exception $e)
                    {
                        echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage() . " " . $e->getLine();
                    }
                }
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage() . " " . $e->getLine();
        }
    }

}