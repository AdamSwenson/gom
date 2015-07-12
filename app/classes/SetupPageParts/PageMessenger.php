<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/5/15
 * Time: 2:20 PM
 */

namespace SetupPageParts;


use PHPMD\Renderer\HTMLRendererTest;

class PageMessenger
{

    /**
     * Displays error message if page is unset
     */
    static public function exam_unset()
    {
        echo <<<HTML
        <div class="pageError warning examUnset">Please choose an exam to set up using the menu to the right. </div>
HTML;

    }
}