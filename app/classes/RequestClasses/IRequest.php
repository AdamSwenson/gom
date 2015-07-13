<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\RequestClasses;

/**
 *
 * @author adam
 */
interface IRequest
{
    public function load_get();

    public function load_post();

    /**
     * This goes through the get and post arrays to put their contents into the generic array
     */
    public function combine();

    /**
     * Runs htmlspecialchars(), stripslashes(), and trim() on the field in the incoming array and returns the cleaned result or FALSE
     * @param  string               $fieldname The field in $_GET or $_POST to return
     * @return boolean|string|array
     */
    public function get_cleaned_value($fieldname);

    public function task();
}
