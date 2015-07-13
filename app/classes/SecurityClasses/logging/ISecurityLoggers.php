<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\SecurityClasses\logging;

/**
 * This is the generic interface that loggers used in security functions will
 * implement.
 *
 * @author adam
 */
interface ISecurityLoggers
{
    public function infoEvent($to_log);

    public function securityEvent($to_log);

    public function criticalEvent($to_log);
}
