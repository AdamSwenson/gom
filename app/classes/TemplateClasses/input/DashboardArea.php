<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/2/15
 * Time: 2:23 PM
 */

namespace TemplateClasses\input;


class DashboardArea extends \TemplateClasses\Controller
{

    static public $baseTemplate = "input.dashboard.base.twig";


    static public function factory()
    {
        return new DashboardArea();
    }

    public function make($options = array())
    {
        $this->render(self::$baseTemplate);
    }

}