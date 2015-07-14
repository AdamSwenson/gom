<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\RequestClasses;

/**
 * Description of IRequestMock
 *
 * @author adam
 */
class IRequestMock extends \classes\MockParent implements IRequest
{
    public $http = array();

    public function set_response($response)
    {
        $this->response = $response;
    }
    public function combine()
    {
        return $this->response;
    }

    public function get_cleaned_value($fieldname)
    {
        if (isset($this->response)) {
            return $this->response;
        } else {
        return $fieldname;
        }
    }

    public function load_get()
    {
        return $this->response;
    }

    public function load_post()
    {
        return $this->response;
    }

    public function task()
    {
        return $this->response;
    }

}
