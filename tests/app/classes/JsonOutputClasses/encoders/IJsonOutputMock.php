<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/5/15
 * Time: 8:15 AM
 */

namespace App\classes\JsonOutputClasses\encoders;


use App\classes\MockParent;
use App\classes\MockTraits;

class IJsonOutputMock extends MockParent implements IJsonOutput
{
 //   use MockTraits;

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
    /**
     * Give this the result and it will encode and echo it out.
     * @param array $result The result from the db
     */
    public function encode_and_send(array $result)
    {
        $this->record(__FUNCTION__, $result);
    }
}