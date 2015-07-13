<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 1:11 PM
 */

namespace App\Http\Controllers;



use App\classes\RequestHandlers\MasterRequestHandler;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function handleRequest(Request $request)
    {
        $task = $request->input('task');
        $this->chooseAction($task, $request);
    }

    protected function chooseAction($task, $request)
    {
        switch ($task) {
            case 'getAllTags':
                MasterRequestHandler::handle(MasterRequestHandler::TAGS, $request);
                break;

            case 'createExam': //create new exam and restrictors
                MasterRequestHandler::handle(MasterRequestHandler::EXAM, $request);
                break;

            case 'setUpQuestions': //edit question contents
                MasterRequestHandler::handle(MasterRequestHandler::QUESTION, $request);
                break;

            case 'assignElements':
                MasterRequestHandler::handle(MasterRequestHandler::SETUP, $request);
                break;

            case 'setUpComments':
                MasterRequestHandler::handle(MasterRequestHandler::SETUP, $request);
                break;

            case 'getCurrentExamComments':
                MasterRequestHandler::handle(MasterRequestHandler::ELEMENT, $request);
                break;

            case 'getAllComments':
                MasterRequestHandler::handle(MasterRequestHandler::ELEMENT, $request);
                break;

            case 'getElements': //Request to refresh the existing elements and comments
                MasterRequestHandler::handle(MasterRequestHandler::ELEMENT, $request);
                break;

            case 'getStockText': //For refreshing stock text
                break;

            case 'newStockText': //Create new stock text item
                break;

            case 'setExamID': //set the current exam id for everything
                MasterRequestHandler::handle(MasterRequestHandler::INPUT, $request);
                break;

            case 'setTotalExams': //update the total exams to grade
                MasterRequestHandler::handle(MasterRequestHandler::GRADE, $request);
                break;

            case 'lockExam':
                MasterRequestHandler::handle(MasterRequestHandler::EXAM, $request);
                break;

            case 'unlockExam':
                MasterRequestHandler::handle(MasterRequestHandler::EXAM, $request);
                break;

            case 'releaseExam':
                MasterRequestHandler::handle(MasterRequestHandler::EXAM, $request);
                break;

            case 'unreleaseExam':
                MasterRequestHandler::handle(MasterRequestHandler::EXAM, $request);

                break;


# Input actions
            case 'getAutoSID': //autocomplete request for student id
                MasterRequestHandler::handle(MasterRequestHandler::INPUT, $request);
                break;

            case 'getRecord': //once autocomplete has been selected, this is the request for the record
                MasterRequestHandler::handle(MasterRequestHandler::SCORE, $request);

                break;

            case 'recordQuestionScore': //record an incoming question score
                MasterRequestHandler::handle(MasterRequestHandler::SCORE, $request);

                break;

            case 'recordElementScore': //record an incoming element score
                MasterRequestHandler::handle(MasterRequestHandler::SCORE, $request);

                break;

            case 'getExamInfo':
                MasterRequestHandler::handle(MasterRequestHandler::SCORE, $request);
                break;

            case 'recordExamInfo':
                MasterRequestHandler::handle(MasterRequestHandler::SCORE, $request);
                break;

            case 'backupDB':
                break;

# dashboard
            case 'getGroupTime':
                MasterRequestHandler::handle(MasterRequestHandler::TIME, $request);
                break;

            case 'setGroupTime':
                MasterRequestHandler::handle(MasterRequestHandler::TIME, $request);
                break;

            case 'getExamTime':
                MasterRequestHandler::handle(MasterRequestHandler::TIME, $request);
                break;

            case 'setExamTime':
                MasterRequestHandler::handle(MasterRequestHandler::TIME, $request);
                break;

            case 'getAllStats':
                MasterRequestHandler::handle(MasterRequestHandler::STATS, $request);
                break;

            #Output
            case 'getElementAverages':
                MasterRequestHandler::handle(MasterRequestHandler::STATS, $request);
                break;

            case 'getQuestionAverages':
                MasterRequestHandler::handle(MasterRequestHandler::STATS, $request);
                break;

# Grade assigner
            case 'assignCalcGrade':
                MasterRequestHandler::handle(MasterRequestHandler::GRADE, $request);
                break;

            case 'assignDirectGrade':
                MasterRequestHandler::handle(MasterRequestHandler::GRADE, $request);
                break;

            case 'getGradeAssignments':
                break;


            case 'createClass':
                break;


            #Create an association between an exam and an existing class
            case 'associateExamClass':
                break;

            #Clone an existing exam
            case 'cloneExamination': //$_Post should contain 'examID_to_clone' for exam to clone
                break;
            default:
                throw new \Exception('bad task request');
        }
    }
}