<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SecurityClasses\nonces;

/**
 * Class for generating nonces to protect against attack
 * Based on Secure Development for mobile Apps, pp.243ff
 *
 * @author adam
 */
class NonceMaker
{
    /** @var FIELD_NAME The name to be used in the form field for nonce tokens */
    const FIELD_NAME = 'formToken';

    public $logger;

    /** @var $session_handler \SecurityClasses\nonces\INonceSessionHandler This handles storage in session*/
    protected $session_handler;

    public function set_logger(\SecurityClasses\logging\ISecurityLoggers $logger)
    {
        $this->logger = $logger;
    }

    public function set_session_handler(\SecurityClasses\nonces\INonceSessionHandler $handler)
    {
        $this->session_handler = $handler;
    }

    /**
     * Generates a string to use as a new nonce
     *
     * Alternatively can use mt_rand() as fallback if openssl not available or too slow to create a suitably random seed
     * with a suitably large number collision space CSPRNG not absolutely necessary because the lifespan for the encryption isn’t long
     * That would use: return hash('sha256', uniqid(mt_rand(), true));
     */
    public function createNonceToken()
    {
        //return hash('sha256', openssl_random_pseudo_bytes(\OPEN_SSL_RANDOM_BYTES_SIZE));
        return hash('sha256', uniqid(mt_rand(), true));
    }

    /**
     * Creates a new nonce and inserts it on the page
     * This is the main publically called method.
     * @param type $page_name
     */
    public function createNonce($page_name)
    {
        if (ctype_alnum($page_name)) {
            $nonce = new Nonce();
            $nonce->token = $this->createNonceToken();
            $nonce->time = time();
            //Store in session
            if ($this->session_handler->store_nonce($page_name, $nonce)) {
                //successfully stored, add form field to page
                $this->make_form_field($nonce, $page_name);
            }
        }
    }

    /**
     * Echos form field containing nonce
     * @param \SecurityClasses\nonces\Nonce $nonce
     */
    public function make_form_field(\SecurityClasses\nonces\Nonce $nonce, $page_name)
    {
        echo "<input type='hidden' id='" . self::FIELD_NAME . "' name='" . self::FIELD_NAME . "' data='$page_name' value='{$nonce->token}' />";
    }

//    /**
//     * Checks session for existing nonces and stores them internally after verifying valid characters
//     */
//    public function initialize_nonces() {
//        if (isset($_SESSION['formNonce']) && !empty($_SESSION['formNonce'])) {
//            if (ctype_alnum($_SESSION['formNonce'])) {
//                $this->nonces['previous'] = $_SESSION['formNonce'];
//            }
//        }
//    }
//
//    /**
//     * Function to create nonce, store in session and output nonce to form
//     */
//    public function getNonce() {
//        $_SESSION['formNonce'] = $this->nonces['current'] = $this->createNonce();
//        //send just created once time nonce to form
//        return $this->nonces['current'];
//    }
//
//    /**
//     *  This checks if the incoming nonce matches the one created for the form
//     * @return boolean True if good, means form was requested from this site; false if invalid, form was not requested from this site
//     * @param string $nonce
//     */
//    protected function checkNonce($nonce = "") {
//        return ($this->nonces['previous'] == $nonce) ? true : false;
//    }
//
//    /**
//     * This wraps the checkNonce function to do error handling and deal with the result.
//     * this is what gets publically called;
//     * @param string $nonce
//     */
//    public function validateFormNonce($page_name, $nonce = "") {
//
//        if (!self::checkNonce($nonce)) {
//            //invalid nonce
//            $nonceErr = 'Invalid Or Non-existent Form Nonce!';
//            $this->noncelogger->log("Nonce failed validation");
//
//            //possibly log out current session for safety
//            //Redirect the user to private page and exit script to stop processing
//            //redirectIt(SECURELOGIN);
//            //important to exit script and to stop any further processing
//            exit();
//        }
//    }
//
//    /**
//     * Test for presence of valid form key, on error will redirect to
//     * secure login page with new key and exit
//     */
//    public function processFormNonce() {
//        $nonce = (isset($_POST['formNonce'])) ? $_POST['formNonce'] : "";
//
//        self::validateFormNonce($nonce);
//    }

}
