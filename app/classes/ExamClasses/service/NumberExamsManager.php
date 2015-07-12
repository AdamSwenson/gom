<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 9:57 AM
 */

namespace ExamClasses\service;

/**
 * This sets the session cookie with number of exams to be graded after sanitizing the incoming string
 *
 * @author adam
 */
class NumberExamsManager implements INumberExamsManager
{
    /** The session variable in which store total exams */
    const KEY = 'totalExams';

    /** var MAX_EXAMS defines the upper limit of how many */
    const MAX_EXAMS = 1000;

    /** @var  $cleaner \SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    /**
     * @param \SecurityClasses\cleaning\ICleanerFactory $cleaner
     */
    public function load_cleaner(\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }

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
     * Sets the total number of exams in a session variable
     * @param $numExams Integer The number of exams to set
     * @return bool
     * @throws \Exception
     */
    public function set_number_exams($numExams)
    {
        $cleaned = $this->cleaner->sanitize($numExams, 'integer');
        if ($cleaned) {
            if ($cleaned < self::MAX_EXAMS) {
                $_SESSION[self::KEY] = $cleaned;
                $_COOKIE[self::KEY] = $cleaned;
                $this->response_handler->handle_row_count(1); //send success
                return TRUE;
            }
            else{
                $this->response_handler->handle_row_count(0); //send failure
                throw new \Exception("Too large a number of exams attempted to be set");
            }
        }
        else{
            $this->response_handler->handle_row_count(1); //send failure
            throw new \Exception("Failed to clean number of exams");
        }
    }

    /**
     * Returns the number of exams stored in the session
     * @return bool|integer
     */
    public function get_number_exams()
    {
        if(isset($_SESSION) && isset($_SESSION[self::KEY]))
        {
            return $_SESSION[self::KEY];
        }
        else{
            return FALSE;
        }
    }
}