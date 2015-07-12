<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace JsonOutputClasses\controllers;

/**
 * This is the most generic of the handler interfaces
 * @author adam
 * @since 16Feb2015
 */
interface IHandler
{
    public function handle_response(array $result_array);

}
