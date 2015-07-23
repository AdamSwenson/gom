<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\SecurityClasses\logging;

use App\classes\MockParent;

/**
 * Description of ISecurityLoggersMock
 *
 * @author adam
 */
class ISecurityLoggersMock extends MockParent implements ISecurityLoggers
{
    public $logged = '';
    public function criticalEvent($to_log)
    {
        $this->logged = $to_log;
    }

    public function infoEvent($to_log)
    {
        $this->logged = $to_log;
    }

    public function securityEvent($to_log)
    {
        $this->logged = $to_log;
    }

}
