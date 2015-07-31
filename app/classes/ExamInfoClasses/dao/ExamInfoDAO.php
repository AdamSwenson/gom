<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/21/15
 * Time: 12:55 PM
 */

namespace App\classes\ExamInfoClasses\dao;


class ExamInfoDAO implements IExamInfoDAO
{
    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

    /** @var  $exam_info_obj \ExamInfo */
    public $exam_info_obj;

    public function update(\Exam $exam, \Student $student, array $exam_info_array)
    {
        $this->retrieve($exam, $student);
    }

    public function update_pages(\Exam $exam, \Student $student, $pages)
    {
        $this->retrieve($exam, $student);
        $this->exam_info_obj->setPages($pages);
        $this->exam_info_obj->save();
        return $this->exam_info_obj;
    }

    public function update_notecard(\Exam $exam, \Student $student, $notecard)
    {
        $this->retrieve($exam, $student);
        $this->exam_info_obj->setNotecard($notecard);
        $this->exam_info_obj->save();
        return $this->exam_info_obj;
    }

    public function update_completion_order(\Exam $exam, \Student $student, $completion_order)
    {
        $this->retrieve($exam, $student);
        $this->exam_info_obj->setCompletionOrder($completion_order);
        $this->exam_info_obj->save();
        return $this->exam_info_obj;
    }

    public function load(\Exam $exam, \Student $student)
    {
        $this->retrieve($exam, $student);
        return $this->exam_info_obj;
    }

    protected function retrieve(\Exam $exam, \Student $student)
    {
        if(empty($this->exam_info_obj)){
            $this->exam_info_obj = \ExamInfoQuery::create()->filterByExam($exam)->filterByStudent($student)->findOneOrCreate();
        }
    }
}