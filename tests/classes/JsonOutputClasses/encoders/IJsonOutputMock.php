<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/5/15
 * Time: 8:15 AM
 */

namespace JsonOutputClasses\encoders;


class IJsonOutputMock extends \classes\MockParent implements IJsonOutput
{
    use \classes\MockTraits;

    /**
     * Give this the result and it will encode and echo it out.
     * @param array $result The result from the db
     */
    public function encode_and_send(array $result)
    {
        $this->record(__FUNCTION__, $result);
    }
}