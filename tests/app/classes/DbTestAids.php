<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 1:17 PM
 */

namespace App\classes;

use Base\User;
use Map\UserTableMap;
use Propel\Runtime\ActiveQuery\Criteria;

use Propel\Runtime\Propel;


//require_once '../../../vendor/autoload.php';

function run()
{

}

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

    public static $user;

    public static function populate_all()
    {
        //

        //DbTestAids::populate_restrictors();
        DbTestAids::populate_item_assignments2();
        DbTestAids::populate_students();
        DbTestAids::populate_classes();

//\classes\DbTestAids::populate_scores();
        DbTestAids::populate_element_scores();
        DbTestAids::populate_question_scores();
       // DbTestAids::populate_pseudoids();
        DbTestAids::populate_times();

//\classes\DbTestAids::populate_tags();

    }

    public static function add_user()
    {
        $result = \UserQuery::create()->filterById(1)->findOne();
        if (!$result)
        {
            $con = Propel::getWriteConnection(UserTableMap::DATABASE_NAME);
            $query = "INSERT INTO `users` (`id`, `username`, `displayname`, `password`, `email`, `activation_token`, `last_activation_request`, `lost_password_request`, `active`, `title`, `sign_up_stamp`, `last_sign_in_stamp`)
        VALUES (1, 'scratchuser1', 'scratchUser1', 'd673ce55ca650ab8fd9be35be51c8cd2a40884b7aa3d8192aebad52fafb77d041', 'nicomachus@gmail.com', 'c279f3d4272d2a4bf0f9cf54712ba766', 1433864705, 0, 0, 'Teacher', 1433864705, 0)";
            $stmt = $con->prepare($query);
            $stmt->execute();
        }
        self::$user = \UserQuery::create()->filterById(1)->findOne();
    }

    public static function get_user()
    {
        if (empty(self::$user))
        {
            self::add_user();
        }

        return self::$user;
    }

    /**
     * Creates fake elements, comments, questions
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public static function populate_items($num = 10)
    {
        try
        {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < $num; $i++)
            {
                $el = new \Element();
                $el->setUser(self::get_user());
                $el->setElementname($faker->word());
                $el->setCommenttext($faker->text(900));
                $el->setDisplaytext($faker->text(15));
                $el->save();

                $q = new \Question();
                $q->setUser(self::get_user());
                $q->setQuestionname($faker->word());
                $q->setQuestiontext($faker->text(50));
                $q->save();
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }


    public static function populate_restrictors($num = 10)
    {
        try
        {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < $num; $i++)
            {
                $t = \TermQuery::create()
                    ->filterByUser(self::get_user())
                    ->filterByContent($faker->word())
                    ->findOneOrCreate();
                $t->save();
//                $t = new \Term();
//                $t->setUser(self::get_user());
//                $t->setContent($faker->word());
//                $t->save();

                $y = \YearQuery::create()
                    ->filterByUser(self::get_user())
                    ->filterByContent($faker->year())
                    ->findOneOrCreate();
                $y->save();
//                $y = new \Year();
//                $y->setUser(self::get_user());
//                $y->setContent($faker->year);
//                $y->save();

                $p = \TopicQuery::create()
                    ->filterByUser(self::get_user())
                    ->filterByContent($faker->word())
                    ->findOneOrCreate();
                $p->save();
//                $p = new \Topic();
//                $p->setUser(self::get_user());
//                $p->setContent($faker->word());
//                $p->save();
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }

    public static function make_exam($term, $year, $topic)
    {
        $user = self::get_user();
        $yr = \YearQuery::create()->filterByContent($year)->findOneOrCreate();
        $tm = \TermQuery::create()->filterByContent($term)->findOneOrCreate();
        $tc = \TopicQuery::create()->filterByContent($topic)->findOneOrCreate();
        $ex = \ExamQuery::create()
            ->filterByUser($user)
//        ->filterByExamtopic($tc)
//            ->filterByExamyear($yr)
//            ->filterByExamterm($tm)
            ->filterByExamyear($year)
        ->filterByExamterm($term)
        ->filterByExamtopic($topic)
        ->findOneOrCreate();
        $ex->save();
//        $ex->setUser($user);
//        $ex->setTopic($tc);
//        $ex->setTerm($tm);
//        $ex->setYear($yr);
//        $ex->save();

        return $ex;
    }


    public static function populate_exams($num = 10)
    {
        try
        {
            $faker = \Faker\Factory::create();
            for ($i = 0; $i < $num; $i++)
            {
                self::make_exam($faker->word(), $faker->year(), $faker->word());
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }

    public static function populate_students()
    {
        $faker = \Faker\Factory::create();
        try
        {
            for ($i = 0; $i < 10; $i++)
            {
                $s = new \Student();
                $s->setUser(self::get_user());
                $s->setEmail($faker->email());
                $s->setSid($faker->unique()->numberBetween(111111111, 999999999));
                $s->setStudentname($faker->name());
                $s->save();
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
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
        $user = self::get_user();
        try
        {
            $exams = \ExamQuery::create()->find();
            $questions = \QuestionQuery::create()->find();
            $elements = \ElementQuery::create()->find();

            for ($j = 0; $j < $num_exams; $j++)
            {
                $exam = $exams[$j];
                $element_counter = 0;
                for ($i = 1; $i <= $num_questions; $i++)
                {
                    try
                    {
                        $qa = \QuestionAssignerQuery::create()
                            ->filterByUser($user)
                            ->filterByExam($exam)
                            ->filterByQuestionnumber($i)
                            ->findOneOrCreate();
                        $qa->setQuestion($questions[$i]);
                        $qa->save();

                        for ($k = 1; $k <= $num_subtasks; $k++)
                        {
                            $ea = \ElementAssignmentQuery::create()
                                ->filterByUser($user)
                                ->filterByExam($exam)
                                ->filterByQuestion($questions[$i])
                                ->filterBySubtask($k)->findOneOrCreate();
                            $ea->setElement($elements[$element_counter]);
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
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage(). " " . $e->getLine();
        }
    }

    public static function populate_classes($num = 4)
    {
        $exams = \ExamQuery::create()->orderById()->find();
        $students = \StudentQuery::create()->orderByStudentname()->find();
        $faker = \Faker\Factory::create();
        try
        {
            for ($i = 0; $i < 10;)
            {
                $kumi = new \Kumi();
                $kumi->setUser(self::get_user());
                $kumi->setNickname($faker->word());
                $kumi->setYear($faker->year());
                $kumi->save();

                $eca = \ExamClassAssignmentQuery::create()
                    ->filterByUser(self::get_user())
                    ->filterByExam($exams[$i])
                    ->filterByKumi($kumi)
                    ->findOneOrCreate();
                $eca->save();
                foreach ($students as $s)
                {
                    $sca = \StudentClassAssignmentQuery::create()
                        ->filterByUser(self::get_user())
                        ->filterByStudent($s)
                        ->filterByKumi($kumi)
                        ->findOneOrCreate();
                    $sca->save();
                }
                $i++;
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }

    static public function populate_element_scores($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        try
        {
            for ($i = 0; $i < $num_exams;)
            {
                $eaq = \ElementAssignmentQuery::create()
                    ->filterByUser(self::get_user())
                    ->filterByExam($exams[$i])->find();
                foreach ($students as $s)
                {
                    foreach ($eaq as $ea)
                    {
                        try
                        {
                            $eee = \ElementScoreQuery::create()
                                ->filterByUser(self::get_user())
                                ->filterByExam($exams[$i])
                                ->filterByStudent($s)
                                ->filterByElement($ea->getElement())
                                ->findOneOrCreate();
                            $eee->setElementscore(self::rand_float(0, 10, 2));
                            $eee->save();
                        } catch (\Exception $e)
                        {
                            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
                        }
                    }
                }
                $i++;
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }

    static public function populate_question_scores($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        try
        {
            for ($i = 0; $i < $num_exams;)
            {
                $qaq = \QuestionAssignerQuery::create()->filterByExam($exams[$i])->find();
                foreach ($students as $s)
                {
                    foreach ($qaq as $qa)
                    {
                        try
                        {
                            $eee = \QuestionScoreQuery::create()
                                ->filterByUser(self::get_user())
                                ->filterByExam($exams[$i])
                                ->filterByStudent($s)
                                ->filterByQuestion($qa->getQuestion())
                                ->findOneOrCreate();
                            $eee->setQuestionscore(self::rand_float(0, 10, 2));
                            $eee->save();
                        } catch (\Exception $e)
                        {
                        }
                    }
                }
                $i++;
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
//            echo $e->getMessage();
            // error_log($e);
        }
    }

    static public function populate_pseudoids($num_exams = 4, $num_students = 4)
    {
        $exams = \ExamQuery::create()->limit($num_exams)->orderById()->find();
        $students = \StudentQuery::create()->limit($num_students)->orderByStudentname()->find();
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < $num_exams; $i++)
        {
            try
            {
                foreach ($students as $s)
                {
                    $piq = \PseudoIDQuery::create()
                        ->filterByUser(self::get_user())
                        ->filterByExam($exams)
                        ->filterByStudent($s)
                        ->filterByPseudoid($faker->unique()->md5())
                        ->findOneOrCreate();
                    $piq->save();
                }
            } catch (\Exception $e)
            {
                echo $e->getMessage();
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
        try
        {
            for ($i = 0; $i < $num_exams;)
            {
                $qaq = \QuestionAssignerQuery::create()->filterByExam($exams[$i])->find();
                $eaq = \ElementAssignmentQuery::create()->filterByExam($exams[$i])->find();
                foreach ($students as $s)
                {
                    foreach ($eaq as $ea)
                    {
                        $qqq = \QuestionScoreQuery::create()
                            ->filterByUser(self::get_user())
                            ->filterByExam($exams[$i])
                            ->filterByStudent($s)
                            ->filterByQuestion($ea->getQuestion())
                            ->filterByQuestionscore(self::rand_float(0, 10, 2))->findOneOrCreate();
                        $qqq->save();
                        $eee = \ElementScoreQuery::create()
                            ->filterByUser(self::get_user())
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

        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
        }
    }


    public static function populate_times($num_exams = 3, $num_students = 10, $num_groups = 10)
    {
        $exams = \ExamQuery::create()->orderById()->limit($num_exams)->find();
        $students = \StudentQuery::create()->orderById()->limit($num_students)->find();
        $faker = \Faker\Factory::create();

        try
        {
            foreach ($exams as $ex)
            {
                foreach ($students as $s)
                {
                    try
                    {
                        $gtq = \GradingTimeQuery::create()
                            ->filterByUser(self::get_user())
                            ->filterByExam($ex)
                            ->filterByStudent($s)
                            ->findOneOrCreate();
                        $gtq->setSeconds(self::rand_float(1, 20));
                        $gtq->save();
                    } catch (\Exception $e)
                    {
                        error_log($e);
                    }
                    try
                    {
                        $eiq = \ExamInfoQuery::create()
                            ->filterByUser(self::get_user())
                            ->filterByExam($ex)
                            ->filterByStudent($s)->findOneOrCreate();
                        $eiq->setCompletionorder($faker->numberBetween(1, 100));
                        $eiq->setNotecard($faker->numberBetween(0, 2));
                        $eiq->setPages(self::rand_float(0.5, 10));
                        $eiq->save();
                    } catch (\Exception $e)
                    {
//                    error_log($e);
                    }
                }
                for ($i = 1; $i <= $num_groups; $i++)
                {
                    try
                    {
                        $gq = \GroupTimeQuery::create()->filterByUser(self::get_user())
                            ->filterByExam($ex)->filterByGroupid($i)->findOneOrCreate();
                        $gq->setSeconds(self::rand_float(1, 30));

                        $gq->save();
                    } catch (\Exception $e)
                    {
                        echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
//                        error_log($e);
                    }
                }
            }
        } catch (\Exception $e)
        {
            echo "\n Error with " . __FUNCTION__ . " " . $e->getMessage();
//            error_log($e);
        }
    }

    public static function populate_tags($num = 10)
    {
        $questions = \QuestionQuery::create()->find();
        $elements = \ElementQuery::create()->find();
        for ($i = 0; $i <= $num; $i++)
        {
            $t = \TagQuery::create()
                ->filterByUser(self::get_user())
                ->filterByTag(\Faker\Factory::create()->word())
                ->findOneOrCreate();
            $t->save();
            if ($i & 1)
            {
                //odd
                foreach ($questions as $q)
                {
                    $z = \TaggedQuestionQuery::create()
                        ->filterByUser(self::get_user())
                        ->filterByQuestion($q)
                        ->filterByTag($t)
                        ->findOneOrCreate();
                    $z->save();
                }
            } else
            {
                foreach ($elements as $e)
                {
                    $user = self::get_user();
                    $z = \TaggedElementQuery::create()
                        ->filterByUser($user)
                        ->filterByElement($e)
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

        $user = self::get_user();
        $el = \ElementQuery::create()
            ->filterByUser($user)
            ->filterByElementname($elementname)
            ->findOneOrCreate();
        $el->save();

        return $el;
    }

    public static function make_question($questiontext)
    {
        $user = self::get_user();
        $q = \QuestionQuery::create()
            ->filterByUser($user)
            ->filterByQuestiontext($questiontext)
            ->findOneOrCreate();
        $q->save();

        return $q;
    }
}

//DbTestAids::populate_all();