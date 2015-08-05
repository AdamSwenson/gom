<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\SecurityClasses\logging;

use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \Monolog\Handler\NativeMailerHandler;

/**
 * This handles logging operations for account setup processes
 *
 * @author adam
 */
class AccountSetupLogger
{
    public static $log;

    public static $mailer;

    protected $log_file = './././sql_log.html';

    protected $log_channel_name = "AccountCreation";

    /** @var $to_email The emails address to send creation messages to */
    protected $to_email = '';

    /** @var $from_email The emails address to send from */
    protected $from_email = '';

    /**
     * This creates the logger object if not already set.
     * Stores execption to error log, but should not take everything down
     */
    public function initialize_logger()
    {
        try {
            if (empty(self::$log)) {
                $formatter = new \Monolog\Formatter\HtmlFormatter();
                self::$log = new Logger($this->log_channel_name); // create a log channel for basedao
                $stream = new StreamHandler($this->log_file, Logger::INFO);
                $stream->setFormatter($formatter);
                self::$log->pushHandler($stream);
                self::$log->addInfo("Logger initialized");
            }
        } catch (\Exception $e) {
            error_log("Failed to initialize logger for $this->log_channel_name: " . $e);
        }
    }

    public function initialize_mailer()
    {
        try {
            if (empty(self::$mailer)) {
                $formatter = new \Monolog\Formatter\HtmlFormatter();
                self::$mailer = new \Monolog\Logger($this->log_channel_name);
                $mail_handler = new NativeMailerHandler($this->to_email, 'User logger message', $this->from_email);
                $mail_handler->setFormatter($formatter);
                self::$mailer->pushHandler($mail_handler);
            }
        } catch (\Exception $e) {
            error_log("Failed to initialize mail logger for $this->log_channel_name: " . $e);
        }
    }
    /**
     * Calls the logger after checking if logger is initialized. Should not fail process if logger doesn't initialize
     * @param string $query The query to log
     * @param array  $vals  The values to be put into the query
     */
    public function log_query($query, $vals)
    {
        try {
            if (empty(self::$log)) {
                $this->initialize_logger();
            }
            if (!empty($vals)) {
                self::$log->addInfo($query, $vals);
            } else {
                self::$log->addInfo($query);
            }
        } catch (\Exception $e) {
            error_log("Failed to use $this->log_channel_name logger for $query :" . $e);
        }
    }

    public function email($message)
    {
     $this->initialize_mailer();
     self::$mailer->addInfo($message);
    }
}
