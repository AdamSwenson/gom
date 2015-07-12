<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 2:55 PM
 */

namespace StudentClasses\service;

use \Propel\Runtime\Propel;

/**
 * Class AutocompleteService
 * Handles lookup of student id
 * @package StudentClasses\service
 */
class AutocompleteService
{

    const INCOMING_KEY = 'term';

    public $results;

    /** @var  $response_handler \JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /**
     * @param \JsonOutputClasses\controllers\IResponseChooser $response_handler
     */
    public function set_response_handler(\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }

    /**
     * @param \Exam $exam
     * @param \RequestClasses\IRequest $request
     */
    public function process(\Exam $exam, \RequestClasses\IRequest $request)
    {
        if (isset($request->http[self::INCOMING_KEY])) {
            $param = $request->http[self::INCOMING_KEY];
            $this->lookup($exam, $param);
            $this->send();
        }
    }


    public function lookup(\Exam $exam, $param)
    {
        try {
            $examid = $exam->getId();
            $query = "SELECT s.studentName, s.sid
		          FROM students s
                  INNER JOIN studentsXclasses sxc ON s.id = sxc.studentID
                  INNER JOIN examsXclasses exc ON exc.classID = sxc.classID
                  WHERE examID = :examID AND sid REGEXP '^{$param}'";

            $con = Propel::getWriteConnection(\Map\StudentTableMap::DATABASE_NAME);
            $stmt = $con->prepare($query);
            $stmt->execute(array(':examID' => $examid));
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $this->results = $stmt->fetchAll();
            return $this->results;
        } catch (\PDOException $e) {
            throw new \Exception('error');

        }
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