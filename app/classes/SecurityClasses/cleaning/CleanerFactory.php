<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace App\classes\SecurityClasses\cleaning;

/**
 * This will perform a validation or sanitization as needed
 *
 * @author adam
 */
class CleanerFactory implements ICleanerFactory {

    const INTEGER = 'integer';
    const FLOAT = 'float';
    const STRING = 'string';
    const TEXT = 'text';
    const EMAIL = 'email';

    public function validate($to_validate, $type) {
        $cleaner = $this->make($type);
        if ($cleaner) {
            return $cleaner->validate($to_validate);
        } else {
            return FALSE;
        }
    }

    public function sanitize($to_clean, $type) {
        $cleaner = $this->make($type);
        if ($cleaner) {
            return $cleaner->sanitize($to_clean);
        } else {
            return FALSE;
        }
    }

    /**
     * This chooses the right ICleaner and instantiates
     * @param type $type
     * @return bool|EmailCleaner|FloatCleaner|IntegerCleaner|TextCleaner
     */
    public function make($type) {
        switch ($type) {
            case self::INTEGER:
                $cleaner = new \App\classes\SecurityClasses\cleaning\IntegerCleaner();
                break;
            case self::FLOAT:
                $cleaner = new \App\classes\SecurityClasses\cleaning\FloatCleaner();
                break;
            case self::STRING:
                $cleaner = new \App\classes\SecurityClasses\cleaning\TextCleaner();
                break;
            case self::TEXT:
                $cleaner = new \App\classes\SecurityClasses\cleaning\TextCleaner();
                break;
            case self::EMAIL:
                $cleaner = new \App\classes\SecurityClasses\cleaning\EmailCleaner();
                break;
            default:
                return FALSE;
        }
        return $cleaner;
    }

}
