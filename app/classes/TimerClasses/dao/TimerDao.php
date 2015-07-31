<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/16/15
 * Time: 2:16 PM
 */

namespace classes\TimerClasses\dao;


use App\classes\Traits\UserTraits;

class TimerDao
{
    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

    public function loadGroupTime(\Exam $exam, $groupID)
    {
        $time = \GroupTimeQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
            ->filterByGroupid($groupID)
            ->findOneOrCreate();
        $time->save();
        return $time;
    }

    public function loadGradingTime(\Exam $exam, \Student $student)
    {
        return \GradingTimeQuery::create()
            ->filterByUser($this->user)
            ->filterByExam($exam)
            ->filterByStudent($student)
            ->findOneOrCreate();
    }
}