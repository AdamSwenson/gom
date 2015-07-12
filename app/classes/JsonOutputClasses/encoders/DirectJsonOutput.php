<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/10/15
 * Time: 8:44 AM
 */

namespace JsonOutputClasses\encoders;


class DirectJsonOutput extends JsonEncoderParent implements IJsonOutput
{

    /**
     * This is used to create an array with the structure the javascript making the request is expecting
     * of the proper format the results in the way javascript is expecting oconstruct json objects for things expecting a report of whether a request
     * executed properly
     *
     * @param  array $array_to_package
     * @return array
     */
    protected function package(array $array_to_package)
    {

    }

    /**
     * Give this the result and it will encode and echo it out.
     * @param array $result The result from the db
     */
    public function encode_and_send(array $result)
    {
        $this->encode($result);
        if($this->encoded){
            echo $this->encoded;
        }
    }
}