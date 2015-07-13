<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\JsonOutputClasses\encoders;

/**
 * This encodes, packages, and sends a response to javascript requests expecting a report on the status of a request.
 * Such applications are expecting a json object with the form
 *  {"data":[{Array full of data},{Maybe another array full of data},{You get the idea}]}
 *
 * @author adam
 */
class SendDataJson extends JsonEncoderParent implements IJsonOutput
{

    /**
     * Give this the result and it will encode and send it, all done.
     *
     * @param array $result
     */
    public function encode_and_send(array $result)
    {
        if (count($result) > 0) {
            $escaped = $this->escape_array_contents($result);
            $packaged = $this->package($escaped);
            $this->encode($packaged);
            $this->send();
        }else{
            $packaged = $this->package(array());
            $this->encode($packaged);
            $this->send();
        }
    }

    /**
     * This creates json objects for things which are expecting data to be returned to them
     * @param array $array_to_package
     * @return array
     */
    protected function package(array $array_to_package)
    {
        $packaged = array(parent::DATA_RESPONSE_KEY => $array_to_package);
        return $packaged;
    }

}
