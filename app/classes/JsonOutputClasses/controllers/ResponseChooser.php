<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\JsonOutputClasses\controllers;

/**
 * This receives an associative array from a database query and
 * determines whether to send the browser a status message or data
 *
 * @author adam
 * @since Feb2015
 */
class ResponseChooser implements IResponseChooser, IHandler
{

    /**
     * This is the key that should be present in any database response which is
     * to be returned as a status message. This should be absent in all those which
     * are to be returned as data
     */
    const STATUSFLAG = "numrows";

    /**
     * The key of the response array if a message is to be returned to the browser
     */
    const MESSAGEFLAG = 'message';

    /** @var $dbresponse  The assoc array returned from the database */
    protected $dbresponse = array();

    /** @var $type ResponseHandler Stfing of either 'data' or 'status' */
    protected $type;

    /** @var $message ResponseChooser */
    protected $message;
    protected $handler;

    /**
     * Call this on an associative array from the db. It figures out correct handling and sends to client
     * @param array $result_array
     * @throws \Exception
     */
    public function handle_response(array $result_array)
    {
        if (count($result_array) > 0) {
            $this->type = $this->choose_type($result_array);
            $this->handler = $this->load_appropriate_handler($this->type);
            $this->handler->encode_and_send($result_array);
        } else {
            throw new \Exception("Empty array passed to load_db_response");
        }
    }
    
    /**
     * Shortcut function for handling the count of num rows affected
     * @param integer $numrows
     */
    public function handle_row_count($numrows){
        $result = array(self::STATUSFLAG => $numrows);
        $this->handle_response($result);
    }

    /**
     * Determine what type of handler to use for the response
     *
     * @param  array  $dbresponse
     * @return string
     */
    public function choose_type(array $dbresponse)
    {
        $type = '';
        if (array_key_exists(self::STATUSFLAG, $dbresponse)) {
            $type = 'status';

        } else {
            $type = 'data';
        }
        return $type;
    }

    /**
     * Once the type has been determined, this returns either a data handler or a status handler
     *
     * @param  type                                                                            $type String of the type of handler to load
     * @return \App\classes\JsonOutputClasses\encoders\SendDataJson | \App\classes\JsonOutputClasses\encoders\SendStatusJson
     * @throws \Exception
     */
    public function load_appropriate_handler($type)
    {
        switch ($type) {
            case 'status':
                return new \App\classes\JsonOutputClasses\encoders\SendStatusJson();
                break;
            case 'data':
                return new \App\classes\JsonOutputClasses\encoders\SendDataJson();
                break;
            default:
                throw new \Exception("Type not correct ");
        }
    }
    
    public function status_flag()
    {
        return self::STATUSFLAG;
    }

}
