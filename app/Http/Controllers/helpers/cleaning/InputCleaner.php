<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */
namespace App\HTTP\Controllers\helpers\cleaning;

/**
 * Description of InputCleaner
 * @deprecated
 * @author adam
 */
class InputCleaner
{
    /**
     * Validate Number
     */
    public function validateNumber1($number)
    {
        return is_numeric($number);
    }

    public function validateNumberFloat($number)
    {
        return filter_var($number, FILTER_VALIDATE_FLOAT);
    }

    public function validateNumberDouble($number)
    {
        return filter_var($number, FILTER_VALIDATE_DOUBLE);
    }

    public function validateNumberInt($number)
    {
        return filter_var($number, FILTER_VALIDATE_INT);
    }

    /**
     * Sanitize Number
     */
    public function sanitizeNumberIntNative($number)
    {
        return intval($number);
    }

    public function sanitizeNumberRegEx($number)
    {
        return preg_match('/[^0-9]/', '', $number);
    }

    public function sanitizeNumberFloat($number)
    {
//a selection of different number filters
        return filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT);
    }

    public function sanitizeNumberDouble($number)
    {
        return filter_var($number, FILTER_SANITIZE_NUMBER_DOUBLE);
    }

    public function sanitizeNumberInt($number)
    {
        return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * Validate String
     */
    public function validateString($string)
    {
        return preg_match('/^[A-Za-z\s,\.!]+$/', $string);
    }

    /**
     * Sanitize String
     */
    public function sanitizeStringRegEx($string)
    {
        return preg_replace('/[^A-Za-z\s,\.!]/', '', $string);
    }

    public function sanitizeString($string)
    {
        return filter_var($string, FILTER_SANITIZE_STRING);
    }

    /**
     * Validate AlphaNumeric String
     */
    public function validateAlphaNumeric($string)
    {
        return ctype_alnum($string);
    }

    /**
     * Sanitize AlphaNumeric String
     */
    public function sanitizeAlphaNumericRegEx($string)
    {
        return preg_replace('/[^a-zA-Z0-9]/', '', $string);
    }

    public function validateEmailRegEx($email)
    {
        return preg_match('/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/', $email);
    }

    public function validateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    
    public function sanitizeEmail($email)
    {
        return filter_var($email, \FILTER_SANITIZE_EMAIL);
    }
    
    public function sanitizeEmailForSQL($email)
    {
        $first = $this->sanitizeEmail($email);
        $first = \trim($first);
    }

    /**
     * Validate URL Format
     */
    public function validateURLRegEx($url)
    {
        return preg_match('/^(http(s?):\/\/|ftp:\/\/{1})((\w+\.)
    {1,})\w{2,}$/i', $url);
    }

    /**
     * Not Recommended—Fails on Certain URLs
     */
    public function validateURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * Sanitize URL
     */
    public function sanitizeURL($url)
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Validate IP Address
     */
    public function validateIPRegEx($ip) { //regex source Jan Goyvaerts @ regular-expression.info

        return preg_match('/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\. (25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\. (25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.
(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/', $ip);
    }

    public function validateIP($ip)
    {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /**
     * Validate Strong Password
     */
    public function validatePasswordStrengthRegEx($password)
    {
        //check that password contains at least
//minimum 10 characters
//1 uppercase character
//1 lowercase character
//1 number
        return preg_match('/^(? = ^.{10,}$) ((? =.*[A-z0-9])(? =.*[A-Z])(? =.*[a-z]))^.*$/', $password);
    }

    /**
     * Validate Strong Password
     */
    public function validatePasswordStrengthRegEx2($password)
    {
//check that password contains at least
//minimum 10 characters
//1 uppercase character
//1 lowercase character
//1 number
//1 special character
        return preg_match('/(? = ^.{10,}$)(? =.*\d)
            (? =.*[!@#$%^&*]+)(?![.\n])(? =.*[A-Z])
            (? =.*[a-z]).*$/', $password);
    }

    /**
     * Validate US Phone Number
     */
    public function validateUSPhoneRegEx($phone)
    {
        return preg_match('/\(?\d{3}\)?[-\s.]?\d{3}[-\s.]\d{4}/x', $phone);
    }

    /**
     * Validate US Zip Code
     */
    public function validateUSZipCodeRegEx($zip)
    {
        return preg_match('/^([0-9]{5})(-[0-9]{4})?$/', $zip);
    }

    /**
     * Validate Social Security Number
     */
    public function validateSSNumberRegEx($ssn)
    {
        return preg_match('/^[0-9]{3}-[0-9]{2}-[0-9]{4}$/', $ssn);
    }

    /**
     * Validate Credit Card
     */
    public function validateCCRegExRegEx($cc, $type)
    {
        switch ($type) {
            case 'visa':
                return preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $cc);
                break;
            case 'mastercard':
                return preg_match('/^5[1-5][0-9]{14}$/', $cc);
                break;
            case 'americanexpress':
                return preg_match('/^3[47][0-9]{13}$/', $cc);
                break;
        }
    }

    /**
     * Validate MM-DD-YY Date
     */
    public function validateMM_DD_YYDateRegEx($date)
    {
        return preg_match('/^((0?[1-9]|1[012])[-/.](0?[1-9]|[12][0-9]|3[01]) [-/.][0-9]?[0-9]?[0-9]{2})*$/', $date);
    }

}
