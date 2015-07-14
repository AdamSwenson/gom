<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/6/15
 * Time: 10:12 AM
 */

namespace App\classes\SecurityClasses\cleaning;


use App\classes\MockParent;

class ICleanerFactoryMock extends MockParent implements ICleanerFactory
{

    public function validate($to_validate, $type)
    {
        $this->record_call(__FUNCTION__, array($to_validate, $type));
        return $this->response;
    }

    public function sanitize($to_clean, $type)
    {
        $this->record_call(__FUNCTION__, array($to_clean, $type));
        return $this->response;
    }
}