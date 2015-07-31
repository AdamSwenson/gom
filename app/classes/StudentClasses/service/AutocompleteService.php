<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 2:55 PM
 */

namespace App\classes\StudentClasses\service;

use App\classes\JsonOutputClasses\controllers\IResponseChooser;
use App\classes\RequestClasses\IRequest;
use App\classes\StudentClasses\dao\StudentDao;
use \Propel\Runtime\Propel;

/**
 * Class AutocompleteService
 * Handles lookup of student id from autocomplete on main input page
 * @package App\classes\StudentClasses\service
 */
class AutocompleteService
{

    const INCOMING_KEY = 'term';

    /** @var  StudentDao */
    public $dao;

    public $results;

    /** @var  $response_handler IResponseChooser */
    public $response_handler;

    public function __construct()
    {
        $this->dao = new StudentDao();
    }

    /**
     * @param IResponseChooser $response_handler
     */
    public function set_response_handler(IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    /**
     * @param \Exam $exam
     * @param IRequest $request
     */
    public function process(\Exam $exam, IRequest $request)
    {
        if (isset($request->http[self::INCOMING_KEY])) {
            $param = $request->http[self::INCOMING_KEY];
            $this->lookup($exam, $param);
            $this->send();
        }
    }


    public function lookup(\Exam $exam, $param)
    {
        $this->results = $this->dao->lookup_autocomplete($exam, $param);
    }

    /**
     * Formats into response expected by client
     */
    public function send()
    {
        if (count($this->results) > 0) {
            $ids = array();
            foreach ($this->results as $r) {
                array_push($ids, array("label" => $r['sid'], "value" => $r['sid']));
            }
            //encode and send $ids
            $this->response_handler->handle_response($ids);
        }
    }


}