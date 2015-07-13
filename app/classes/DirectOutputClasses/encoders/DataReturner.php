<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\DirectOutputClassesencoders;

/**
 * This is used when the handler needs to pass the raw data to something
 *
 * @author adam
 */
class DataReturner
{
    public function encode_and_display($result_array)
    {
        return $result_array;
    }

}
