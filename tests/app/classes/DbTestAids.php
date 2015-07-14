<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 1:17 PM
 */

namespace App\classes;

use Propel\Runtime\ActiveQuery\Criteria;

/**
 * Class DbTestAids
 * These are tools for putting the database into a known state
 */
class DbTestAids
{
// Hopefully someday the faker library will be fixed so that we can just do:
//        $populator = new \Faker\ORM\Propel\Populator($faker);
//        $populator->addEntity('Exam', 100, array(
//            'CreatedAt' => null,
//            'UpdatedAt' => null
//        ));
//        $this->inserted_examids = $populator->execute();

    public static function populate_all()
    {
        self::populate_item_assignments();
        self::populate_restrictors();
        self::populate_students();
        self::populate_classes();
    }

    /**
     * Creates fake elements, comments, questions
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public static function populate_items($num = 10)
    {
        try {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < $num; $i++) {
                $el = new \Element();
                $el->setElementname($faker->word());
                $el->setCommenttext($faker->text(900));
                $el->setDisplaytext($faker->text(15));
                $el->save();

                $q = new \Question();
                $q->setQuestionname($faker->word());
                $q->setQuestiontext($faker->text(50));
                $q->save();
            }
        } catch (\Exception $e) {
        }
    }


    public static function populate_restrictors($num = 10)
    {
        try {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < $num; $i++) {
                $t = new \Term();
                $t->setContent($faker->word());
                $t->save();

                $y = new \Year();
                $y->setContent($faker->year);
                $y->save();

                $p = new \Topic();
                $p->setContent($faker->word());
            }
        } catch (\Exception $e) {
        }
    }

    public static function make_exam($term, $year, $topic)
    {
        $yr = \YearQuery::create()->filterByContent($year)->findOneOrCreate();
        $tm = \TermQuery::create()->filterByContent($term)->findOneOrCreate();
        $tc = \TopicQuery::create()->filterByContent($topic)->findOneOrCreate();
        $ex = new \Exam();
        $ex->setTopic($tc);
        $ex->setTerm($tm);
        $ex->setYear($yr);
        $ex->save();
        return $ex;
    }


    public static function populate_exams($num = 10)
    {
        try {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < $num; $i++) {
                self::make_exam($faker->word(), $faker->year(), $faker->word());
            }
        } catch (\Exception $e) {
        }
    }

    public static function populate_students()
    {
        $faker = \Faker\Factory::create();
        try {
            for ($i = 0; $i < 10; $i++) {
                $s = new \Student();
                $s->setEmail($faker->email());
                $s->setSid($faker->unique()->numberBetween(111111111, 999999999));
                $s->setStudentname($faker->name());
                $s->save();
            }
        } catch (\Exception $e) {
        }
    }

//    public static function populate_item_assignments($num_exams = 5, $num_questions = 5, $num_subtasks = 5)
//    {
//        self::populate_exams();
//        self::populate_items();
//        try {
//            $exams = \ExamQuery::create()->find();
//            $questions = \QuestionQuery::create()->find();
//            $elements = \ElementQuery::create()->find();
//            for ($j = 0; $j < $num_exams; $j++) {
//                $exam = $exams[$j];
//                for ($i = 1; $i <= $num_questions; $i++) {
//                    $qa = \QuestionAssignerQuery::create()
//                        ->filterByExam($exam)
//                        ->filterByQuestionnumber($i)
//                        ->findOneOrCreate();
//                    $qa->setQuestion($questions[$i]);
//                    $qa->save();
//
//                    for ($k = 0; $k < $num_subtasks; $k++) {
//                        $ea = \ElementAssignmentQuery::create()
//                            ->filterByExam($exam)
//                            ->filterByQuestion($questions[$i])
//                            ->filterBySubtask($k)->findOneOrCreate();
//                            $ea->setElement($elements[$k]);
//                        $ea->save();
//                    }
//                }
//            }
//        } catch (\Exception $e) {
//        }
//    }

    /**
     * Improved version which won't assign the same element to multiple questions
     * @param int $num_exams
     * @param int $num_questions
     * @param int $num_subtasks
     */
    public static function populate_item_assignments2($num_exams = 5, $num_questions = 5, $num_subtasks = 5)
    {
        self::populate_exams();
        self::populate_items(30);

        try {
            $exams = \ExamQuery::create()->find();
            $questions = \QuestionQuery::create()->find();
            $elements = \ElementQuery::create()->find();

            for ($j = 0; $j < $num_exams; $j++) {
                $exam = $exams[$j];
                $element_counter = 0;
                for ($i = 1; $i <= $num_questions; $i++) {
                    try {
                        $qa = \QuestionAssignerQuery::create()
                            ->filterByExam($exam)
                            ->filterByQuestionnumber($i)
                            ->findOneOrCreate();
                        $qa->setQuestion($questions[$i]);
                        $qa->save();

                        for ($k = 1; $k <= $num_subtasks; $k++) {
                            $ea = \ElementAssignmentQuery::create()
                                ->filterByExam($exam)
                                ->filterByQuestion($questions[$i])
                                ->filterBySubtask($k)->findOneOrCreate();
                            $ea->setElement($elements[$element_counter]);
                            $ea->save();
                            $element_counter += 1;
                        }
                    }catch(\Exception $e){}
                }
            }
        } catch (\Exception $e) {
        }
    }

    public static function populate_classes($num = 4)
    {
        $exams = \ExamQuery::create()->orderById()->find();
        $students = \StudentQuery::create()->orderByStudentname()->find();
        $faker = \Faker\Factory::create();
        try {
            for ($i = 0; $i < 10;) {
                $kumi = new \Kumi();
                $kumi->setNickname($faker->word());
                $kumi->setYear($faker->year());
                $kumi->save();

                $eca = \ExamClassAssignmentQuery::create()->filterByExam($exams[$i])->filterByKumi($kumi)->findOneOrCreate();
                $eca->save();
                foreach ($students as $s) {
                    $sca = \StudentClassAssignmentQuery::create()->filterByStudent($s)->filterByKumi($kumi)->findOneOrCreate();
                    $sca->save();
                }
                $i++;
            }
        } catch (\Exception $e) {
        }
    }

    static public function populate_element_scores($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        try {
            for ($i = 0; $i < $num_exams;) {
                $eaq = \ElementAssignmentQuery::create()->filterByExam($exams[$i])->find();
                foreach ($students as $s) {
                    foreach ($eaq as $ea) {
                        try {
                            $eee = \ElementScoreQuery::create()
                                ->filterByExam($exams[$i])
                                ->filterByStudent($s)
                                ->filterByElement($ea->getElement())
                                ->filterByElementscore(self::rand_float(0, 10, 2))
                                ->findOneOrCreate();
                            $eee->save();
                        } catch (\Exception $e) {
                        }
                    }
                }
                $i++;
            }
        } catch (\Exception $e) {
        }
    }

    static public function populate_question_scores($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        try {
            for ($i = 0; $i < $num_exams;) {
                $qaq = \QuestionAssignerQuery::create()->filterByExam($exams[$i])->find();
                foreach ($students as $s) {
                    foreach ($qaq as $qa) {
                        try {
                            $eee = \QuestionScoreQuery::create()
                                ->filterByExam($exams[$i])
                                ->filterByStudent($s)
                                ->filterByQuestion($qa->getQuestion())
                                ->filterByQuestionscore(self::rand_float(0, 10, 2))
                                ->findOneOrCreate();
                            $eee->save();
                        } catch (\Exception $e) {
                        }
                    }
                }
                $i++;
            }
        } catch (\Exception $e) {
           // error_log($e);
        }
    }

    static public function populate_pseudoids($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->limit($num_exams)->orderById()->find();
        $students = \StudentQuery::create()->limit($num_students)->orderByStudentname()->find();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $num_exams; $i++) {
            try {
                foreach ($students as $s) {
                    $piq = \PseudoIDQuery::create()
                        ->filterByExam($exams)
                        ->filterByStudent($s)
                        ->filterByPseudoid($faker->unique()->md5())
                        ->findOneOrCreate();
                    $piq->save();
                }

            } catch (\Exception $e) {
                //error_log($e);
            }
        }
    }

    /**
     * THIS DOESN'T WORK
     * @param int $num_exams
     * @param int $num_students
     */
    static public function populate_scores($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        try {
            for ($i = 0; $i < $num_exams;) {
                $qaq = \QuestionAssignerQuery::create()->filterByExam($exams[$i])->find();
                $eaq = \ElementAssignmentQuery::create()->filterByExam($exams[$i])->find();
                foreach ($students as $s) {
                    foreach ($eaq as $ea) {
                        $qqq = \QuestionScoreQuery::create()
                            ->filterByExam($exams[$i])
                            ->filterByStudent($s)
                            ->filterByQuestion($ea->getQuestion())
                            ->filterByQuestionscore(self::rand_float(0, 10, 2))->findOneOrCreate();
                        $qqq->save();
                        $eee = \ElementScoreQuery::create()
                            ->filterByExam($exams[$i])
                            ->filterByStudent($s)
                            ->filterByElement($ea->getElement())
                            ->filterByElementscore(self::rand_float(0, 10, 2))
                            ->findOneOrCreate();
                        $eee->save();
                    }
//                    foreach ($qaq as $q) {
//                        $qqq = \QuestionScoreQuery::create()
//                            ->filterByExam($exams[$i])
//                            ->filterByStudent($s)
//                            ->filterByQuestion($q->getQuestion())
//                            ->filterByQuestionscore(self::rand_float(0, 10, 2))->findOneOrCreate();
//                        $qqq->save();
//                    }
                }
                $i++;
            }

        } catch (\Exception $e) {
        }
    }


    public static function populate_times($num_exams = 3, $num_students = 10, $num_groups = 10)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        $faker = \Faker\Factory::create();

        try {
            foreach ($exams as $ex) {
                foreach ($students as $s) {
                    try {
                        $gtq = \GradingTimeQuery::create()
                            ->filterByExam($ex)
                            ->filterByStudent($s)
                            ->findOneOrCreate();
                        $gtq->setSeconds(self::rand_float(1, 20));
                        $gtq->save();
                    } catch (\Exception $e) {
                        error_log($e);
                    }
                    try{
                    $eiq = \ExamInfoQuery::create()
                        ->filterByExam($ex)
                        ->filterByStudent($s)->findOneOrCreate();
                    $eiq->setCompletionorder($faker->numberBetween(1,100));
                    $eiq->setNotecard($faker->numberBetween(0, 2));
                    $eiq->setPages(self::rand_float(0.5, 10));
                    $eiq->save();
                    } catch (\Exception $e) {
//                    error_log($e);
                }
                }
                for ($i = 1; $i <= $num_groups; $i++) {
                    try {
                        $gq = \GroupTimeQuery::create()->filterByExam($ex)->filterByGroupid($i)->findOneOrCreate();
                        $gq->setSeconds(self::rand_float(1, 30));

                        $gq->save();
                    } catch (\Exception $e) {
//                        error_log($e);
                    }
                }
            }
        } catch (\Exception $e) {
//            error_log($e);
        }
    }

    public static function populate_tags($num=10)
    {
        $questions = \QuestionQuery::create()->find();
        $elements = \ElementQuery::create()->find();
        for($i=0; $i <=$num; $i++)
        {
            $t = \TagQuery::create()
                ->filterByTag(\Faker\Factory::create()->word())
                ->findOneOrCreate();
            $t->save();
            if( $i & 1 ) {
                //odd
                foreach($questions as $q)
                {
                    $z = \TaggedQuestionQuery::create()->filterByQuestion($q)
                        ->filterByTag($t)
                        ->findOneOrCreate();
                    $z->save();
                }
            }else{
                foreach($elements as $e)
                {
                    $z = \TaggedElementQuery::create()->filterByElement($e)
                        ->filterByTag($t)
                        ->findOneOrCreate();
                    $z->save();
                }

            }

        }

//
//        foreach($questions as $q)
//        {
//            $g = rand(1,10);
//            if( $i & 1 ) {
//                //odd
//                $tag = \TagQuery::create()->filterById($g)->findOne();
//                $z = \TaggedQuestionQuery::create()->filterByQuestion($q)
//                    ->filterByTag($tag)
//                    ->findOneOrCreate();
//                $z->save();
//            } else {
//                $z = \TaggedElementQuery::create()->filterByElement($q)
//                    ->filterByTag($t)
//                    ->findOneOrCreate();
//                $z->save();
//            }
//        }
//        foreach($elements as $e)
//        {
//            $g = rand(1,10);
//            if( $i & 1 ) {
//            } else {
//                //odd
//                $tag = \TagQuery::create()->filterById($g)->findOne();
//                $z = \TaggedElementQuery::create()->filterByElement($q)
//                    ->filterByTag($tag)
//                    ->findOneOrCreate();
//                $z->save();
//            }
//        }
    }

    public static function rand_float($min, $max, $decimals = 0)
    {
        $scale = pow(10, $decimals);

        return mt_rand($min * $scale, $max * $scale) / $scale;
    }

    public static function make_element($elementname)
    {
        $el = \ElementQuery::create()->filterByElementname($elementname)->findOneOrCreate();
        $el->save();

        return $el;
    }

    public static function make_question($questiontext)
    {
        $q = \QuestionQuery::create()->filterByQuestiontext($questiontext)->findOneOrCreate();
        $q->save();

        return $q;
    }
}