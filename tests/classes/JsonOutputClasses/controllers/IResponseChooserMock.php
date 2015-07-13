<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace JsonOutputClasses\controllers;

/**
 * Description of IResponseChooserMock
 *
 * @author adam
 */
class IResponseChooserMock extends \classes\MockParent implements IResponseChooser
{
    public $been_called = false;
    public $loaded = array();

    public function set_response($response)
    {
        $this->response = $response;
    }
    
    

    public function handle_response_called()
    {
        return $this->been_called;
//        if (array_key_exists('handle_response', $this->called)) {
//            return $this->called['handle_response'];
//        }
//        else{
//            return FALSE;
//        }
    }

    public function handle_response(array $result_array)
    {
        $this->record_call(__FUNCTION__, array($result_array));
        $this->loaded = $result_array;
        $this->been_called = true;
//        array_push($this->called, array('handle_response' => TRUE));
        if (isset($this->response)) {
            return $this->response;
        }
    }

    public function handle_row_count($numrows)
    {
        $this->record_call(__FUNCTION__, array($numrows));
    }

}
