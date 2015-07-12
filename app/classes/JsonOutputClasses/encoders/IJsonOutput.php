<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace JsonOutputClasses\encoders;

/**
 * This covers both functions which echo a json encoded string
 * into the page and which send it via ajax.
 *
 * Anything creating any json output should implement this interface.
 *
 * @author adam
 */
interface IJsonOutput
{
    /**
     * This takes care of all the encoding, escaping, etc. Give it the result array from the db and call this. It sends to the client.
     * @param array $result
     */
    public function encode_and_send(array $result);
}
