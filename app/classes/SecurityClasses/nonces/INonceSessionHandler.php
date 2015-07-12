<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SecurityClasses\nonces;

/**
 *
 * @author adam
 */
interface INonceSessionHandler
{
    /**
     * Stores nonce value for the page in session
     * @param type                          $page_name
     * @param \SecurityClasses\nonces\Nonce $nonce
     */
    public function store_nonce($page_name, \SecurityClasses\nonces\Nonce $nonce);

    /**
     * Retrieves nonce and timestamp for a page
     * @param  type                          $page_name
     * @return \SecurityClasses\nonces\Nonce A nonce object with token and time set
     */
    public function get_nonce($page_name);

    /**
     * Removes a nonce set
     * @param type $page_name
     */
    public function remove_page_nonce($page_name);

}
