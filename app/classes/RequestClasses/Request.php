<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\RequestClasses;

/**
 * This grabs and holds the incoming http request arrays ($_GET and $_POST) and amalgamates them into one array
 *
 * @author adam
 */
class Request implements IRequest
{
    /** @var $get $_GET The get array */
    public $get = array();

    /** @var $post $_POST The post array */
    public $post = array();

    /** @var $http array The generic array that can be called regardless of the request type */
    public $http = array();
    public $tasknames = array('task', 'please');

    /**
     * Factory method. Loads the incoming and returns a Request instance
     */
    static public function create()
    {
        $obj = new Request();
        $obj->load();
        return $obj;
    }

    /**
     * This handles all loading. It should be the main method publicly called
     */
    public function load()
    {
        $this->load_get();
        $this->load_post();
        $this->combine();
        $this->unset_incoming();
    }

    /**
     * After the $_get and $_post hve been processed, unset the arrays so they can't be used accidentally
     */
    public function unset_incoming()
    {
        if (isset($_POST)) {
            unset($_POST);
        }
        if (isset($_GET)) {
            unset($_GET);
        }
        if (isset($_REQUEST)) {
            unset($_REQUEST);
        }
    }

    public function load_get()
    {
        if (isset($_GET)) {
            $this->get = $_GET;
        }
    }

    public function load_post()
    {
        if (isset($_POST)) {
            $this->post = $_POST;
        }
    }

    /**
     * This goes through the get and post arrays to put their contents into the generic array
     */
    public function combine()
    {
        $this->http = array_merge($this->post, $this->get);
    }

    /**
     * Runs htmlspecialchars(), stripslashes(), and trim() on the field in the incoming array and returns the cleaned result or FALSE
     * @param  string $fieldname The field in $_GET or $_POST to return
     * @return boolean|string|array
     */
    public function get_cleaned_value($fieldname)
    {
        if (isset($this->http[$fieldname])) {
            return \htmlspecialchars(\stripslashes(\trim($this->http[$fieldname])));
        } else {
            return false;
        }
    }

    /**
     * This will parse out task requests from the array and return it. It will search through the task name array and return the first one it finds.
     * @return string
     */
    public function task()
    {
        foreach ($this->tasknames as $name) {
            if (isset($this->http[$name])) {
                return $this->http[$name];
            }
        }
    }

    /**
     * If a nonce was included in the incoming, this will get it
     * @return string Nonce from incoming
     */
    public function nonce()
    {
        if (array_key_exists(\App\classes\SecurityClasses\nonces\NonceMaker::FIELD_NAME, $this->http)) {
            return $this->http[\App\classes\SecurityClasses\nonces\NonceMaker::FIELD_NAME];
        } elseif (array_key_exists('nonce', $this->http)) {
            return $this->http['nonce'];
        }
    }

    /**
     * This checks whether the incoming request has the field name set (which is correlated to the nonce)
     * @return type
     */
    public function page_name()
    {
        if (array_key_exists('pageName', $this->http)) {
            return $this->http['pageName'];
        }
    }

}
