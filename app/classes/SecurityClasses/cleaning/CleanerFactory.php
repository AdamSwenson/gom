<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

use App\classes\SecurityClasses\cleaning\EmailCleaner;
use App\classes\SecurityClasses\cleaning\FloatCleaner;
use App\classes\SecurityClasses\cleaning\IntegerCleaner;
use App\classes\SecurityClasses\cleaning\TextCleaner;
use Exceptions\InputTypeException;

/**
 * This will perform a validation or sanitization as needed
 *
 * @author adam
 */
class CleanerFactory implements ICleanerFactory
{

    const INTEGER = 100;
    const FLOAT = 101;
    const STRING = 102;
    const TEXT = 103;
    const EMAIL = 104;

    public function validate($to_validate, $type)
    {
        try
        {
            $cleaner = $this->make($type);
            if ($cleaner)
            {
                return $cleaner->validate($to_validate);
            } else
            {
                return false;
            }
        } catch (\Exception $e)
        {
            throw $e;
        }
    }

    public function sanitize($to_clean, $type, $max_length=null)
    {
        try
        {
            $cleaner = $this->make($type);
            if ($cleaner)
            {
                return $cleaner->sanitize($to_clean, $max_length);
            } else
            {
                return false;
            }
        } catch (\Exception $e)
        {
            throw $e;
        }
    }

    /**
     * This chooses the right ICleaner and instantiates
     * @param type $type
     * @return bool|EmailCleaner|FloatCleaner|IntegerCleaner|TextCleaner
     */
    public function make($type)
    {
        switch ($type)
        {
            case self::INTEGER:
                $cleaner = new IntegerCleaner();
                break;
            case 'integer':
                $cleaner = new IntegerCleaner();
                break;
            case self::FLOAT:
                $cleaner = new FloatCleaner();
                break;
            case 'float':
                $cleaner = new FloatCleaner();
                break;
            case self::STRING:
                $cleaner = new TextCleaner();
                break;
            case 'string':
                $cleaner = new TextCleaner();
                break;
            case self::TEXT:
                $cleaner = new TextCleaner();
                break;
            case 'text':
                $cleaner = new TextCleaner();
                break;
            case self::EMAIL:
                $cleaner = new EmailCleaner();
                break;
            case 'email':
                $cleaner = new EmailCleaner();
                break;
            default:
                return false;
        }

        return $cleaner;
    }

}
