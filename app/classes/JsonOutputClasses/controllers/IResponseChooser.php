<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\JsonOutputClasses\controllers;

/**
 * This receives an associative array from a database query and determines whether to send the browswer a status message or data json
 * @author adam
 */
interface IResponseChooser
{
    /**
     * Call this on an associative array from the db. It figures out correct handling and sends to client
     * @param array $result_array
     */
    public function handle_response(array $result_array);
    public function handle_row_count($numrows);
}
