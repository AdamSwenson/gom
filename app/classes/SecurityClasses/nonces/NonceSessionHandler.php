<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\SecurityClasses\nonces;

/**
 * This handles interaction with the session variables holding nonces
 * The $_SESSION array will hold an array 'nonces'. Each key is a page name. The value of that
 * key is an array with keys 'nonce' and 'nonceTime'
 *
 * @author adam
 */
class NonceSessionHandler implements INonceSessionHandler
{
    const PAGE_EXAM_MANAGER = 'examManager';
    const PAGE_COMMENT_SETUP = 'commentsetup';
    const PAGE_INPUT = 'input';
    const PAGE_QUESTION_SETUP = 'questionsetup';


    /**
     * Checks whether session contains an array for nonces, creates it if not
     */
    public function initialize_session()
    {
        if (!isset($_SESSION['nonces'])) {
            $_SESSION['nonces'] = array();
        }
    }

    /**
     * Stores nonce value for the page in session
     * @param type $page_name
     * @param \App\classes\SecurityClasses\nonces\Nonce $nonce
     * @return bool
     * @throws \Exception
     */
    public function store_nonce($page_name, \App\classes\SecurityClasses\nonces\Nonce $nonce)
    {
        try {
        $this->initialize_session();
//        $array_to_store = array('nonce' => $nonce->token, 'nonceTime' => $nonce->time);
        $_SESSION['nonces'][$page_name] = $nonce;

        return TRUE;
        } catch (\Exception $e) { throw $e;}
    }

    /**
     * Retrieves nonce and timestamp for a page
     * @param  type                          $page_name
     * @return \App\classes\SecurityClasses\nonces\Nonce A nonce object with token and time set
     */
    public function get_nonce($page_name)
    {
        $this->initialize_session();
        if (array_key_exists($page_name, $_SESSION['nonces'])) {
            $nonce = $_SESSION['nonces'][$page_name];
            //$nonce = new \Nonce();
            //$nonce->token = $stored['nonce'];
            //$nonce->time = $stored['nonceTime'];
            return $nonce;
    }
    }

    /**
     * Removes a nonce set
     * @param type $page_name
     */
    public function remove_page_nonce($page_name)
    {
        $this->initialize_session();
        if (array_key_exists($page_name, $_SESSION['nonces'])) {
            unset($_SESSION['nonces'][$page_name]);
        }
    }
}
