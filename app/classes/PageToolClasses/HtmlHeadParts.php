<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace PageToolClasses;

/**
 * This makes various components of an html page head section
 *
 * @author adam
 */
class HtmlHeadParts
{
    public function opening_header()
    {
        header('Content-type: text/html; charset = UTF-8');
    }

    public function metaTags()
    {
        $out = '<!DOCTYPE html>' .
                '<head>' .
                    '<meta http-equiv="Content-Type" content = "text/html; charset = utf-8" />' .
                    '<meta name=viewport content="width=device-width, initial-scale=1">';
        echo $out;
    }

    public function favicon()
    {
        echo \classes\Navigation::FAVICON;
    }

    public function title($page_name)
    {
        echo "<title>$page_name    Grade-o-matic v." . CURRENTVERSION . "</title>";
    }
}
