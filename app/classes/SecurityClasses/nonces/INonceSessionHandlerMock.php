<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace SecurityClasses\nonces;

/**
 * Description of INonceSessionHandlerMock
 *
 * @author adam
 */
class INonceSessionHandlerMock implements INonceSessionHandler
{
    public function set_response($response)
    {
        $this->response = $response;
    }
    public function get_nonce($page_name)
    {
        return $this->response;
    }

    public function remove_page_nonce($page_name)
    {
        return $this->response;
    }

    public function store_nonce($page_name, Nonce $nonce)
    {
        return $this->response;
    }

}
