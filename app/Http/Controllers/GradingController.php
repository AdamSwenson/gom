<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/11/15
 * Time: 10:46 PM
 */

namespace App\Http\Controllers;


use App\classes\ExamClasses\service\CurrentExamManager;
use App\classes\ExamClasses\service\NumberExamsManager;
use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\classes\StudentClasses\service\AutocompleteService;
use App\Http\Requests\GradingRequest;
use App\Repositories\Student\IStudentRepository;

/**
 * Class GradingController
 *
 * Front controller for grading operations
 *
 *
 * Note: May be easiest if store question_assignment_id and element_assignment_id in the form
 *
 * @package App\Http\Controllers
 */
class GradingController extends Controller
{

    public function showInputPage(GradingRequest $request)
    {
        $numberOfQuestions=5;
//        return 'input';
        return view('input.main_input', [
            'numberOfQuestions' => $numberOfQuestions]);
    }

    public function showExamManager()
    {
        return "exam manager page here";
    }


    /**
     *
     * @param GradingRequest $request
     * @throws \Exception
     */
    public function setExamID(GradingRequest $request)
    {
        try
        {
            //TODO Return examid in json on success
            $current_exam_manager = new CurrentExamManager();
            $this->exam = $current_exam_manager->set_current_exam($request->input('examID'));

            if (!empty($this->exam))
            {
                $this->response_handler->handle_response(array(
                    'status' => 'success',
                    'examID' => $this->exam->getId()
                ));
            } else
            {
                $this->response_handler->handle_row_count(0);
            }
        } catch (\Exception $exc)
        {
            $this->response_handler->handle_row_count(0);
            $cnt = 0;
            throw new \Exception('Error setting exam ' . $exc->getTraceAsString());
        }

    }

    /**
     * Handles autocomplete request for student id
     * @param GradingRequest $request
     * @param IStudentRepository $studentDao
     */
    public function getAutoSID(GradingRequest $request, IStudentRepository $studentDao)
    {
        $studentDao->lookup_autocomplete($this->exam, $request);
//        $autocomplete_handler = new AutocompleteService();
//        $autocomplete_handler->set_response_handler($this->response_handler);
//        $autocomplete_handler->process($this->exam, $request);
    }


    public function setTotalExams(GradingRequest $request)
    {
        $manager = new NumberExamsManager();
        $manager->load_cleaner(new CleanerFactory());
        $manager->set_response_handler($this->response_handler);
        $manager->set_number_exams($request->input('totalExams'));
    }
}