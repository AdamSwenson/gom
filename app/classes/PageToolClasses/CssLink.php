<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace PageToolClasses;

/**
 * Echos the start and finish of a stylesheet link around the link text
 *
 * @author adam
 */
class CssLink
{
    public static function link($link)
    {
       echo "<link rel='stylesheet' type='text/css' href='$link' />";
    }
}
