<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/5/15
 * Time: 8:17 AM
 */

namespace classes;


trait MockTraits 
{

    public $caller;
    public $args;

    public function record($caller = __FUNCTION__, $args=array())
    {
        $this->caller = $caller;
        $this->args = $args;
    }


    public function __call($name, $args)
    {
        $this->record($name, $args);
        $this->$name($args);
    }
}