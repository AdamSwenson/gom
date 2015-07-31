<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/27/15
 * Time: 12:59 PM
 */

namespace HTTP\Controllers;


use App\Http\Controllers\GradingController;

class GradingControllerTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new GradingController();
    }

    public function testShowInputPage()
    {
        $this->markTestIncomplete();
//        $numberOfQuestions=5;
////        return 'input';
//        return view('input.main_input', [
//            'numberOfQuestions' => $numberOfQuestions]);
    }

    public function testShowExamManager()
    {
$this->markTestIncomplete();
    }


    public function setExamID()
    {
        $this->markTestIncomplete();
//        try
//        {
//            //TODO Return examid in json on success
//            $current_exam_manager = new CurrentExamManager();
//            $this->exam = $current_exam_manager->set_current_exam($request->input('examID'));
//
//            if (!empty($this->exam))
//            {
//                $this->response_handler->handle_response(array(
//                    'status' => 'success',
//                    'examID' => $this->exam->getId()
//                ));
//            } else
//            {
//                $this->response_handler->handle_row_count(0);
//            }
//        } catch (\Exception $exc)
//        {
//            $this->response_handler->handle_row_count(0);
//            $cnt = 0;
//            throw new \Exception('Error setting exam ' . $exc->getTraceAsString());
//        }

    }


    public function getAutoSID()
    {
        $this->markTestIncomplete();
//        $studentDao->lookup_autocomplete($this->exam, $request);
//        $autocomplete_handler = new AutocompleteService();
//        $autocomplete_handler->set_response_handler($this->response_handler);
//        $autocomplete_handler->process($this->exam, $request);
    }


    public function testSetTotalExams()
    {
        $this->markTestIncomplete();
    }

}
