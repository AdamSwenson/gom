<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace DirectOutput\controllers;

/**
 * This handles html encoding and escaping for processes that output data and text directly to the user
 *
 *
 * @author adam
 * @since 15Feb2015
 */
class DirectOutputController implements \App\classes\JsonOutputClasses\controllers\IHandler
{

    /** @var $dbresponse  The assoc array returned from the database */
    protected $dbresponse = array();

    /** @var $type ResponseHandler Stfing of either 'data' or 'status' */
    protected $type;

    /** @var $result_data array This holds the result array. Can be accessed publically if need be*/
    public $result_data;

    /** @var $message ResponseChooser */
    protected $message;

    protected $handler;

    /**
     * Call this on an associative array from the db. It figures out correct handling and sends to client. This can take an empty array
     * as a result
     * @param array $result_array
     */
    public function handle_response(array $result_array)
    {
            $this->result_data = $result_array;
            $this->type = $this->choose_type($result_array);
            $this->handler = $this->load_appropriate_handler($this->type);
            $this->handler->encode_and_display($result_array);
    }

    /**
     * Determine what type of handler to use for the response
     *
     * @param  array  $dbresponse
     * @return string
     */
    public function choose_type(array $dbresponse)
    {
        $type = 'question';
        if (key_exists('questionID', $dbresponse)) {
            $type = 'question';
        }

        return $type;
    }

    /**
     * If a question array, no handler will be needed since the db result will be directly requested
     *
     *
     * @param  type $type String of the type of handler to load
     * @return \App\classes\DirectOutputClassesencoders\DataReturner|string
     * @throws \Exception
     */
    public function load_appropriate_handler($type)
    {
        $handler = '';
        switch ($type) {
            case 'question':
                $handler = new \App\classes\DirectOutputClassesencoders\DataReturner();
                break;
        }

        return $handler;
    }

}
