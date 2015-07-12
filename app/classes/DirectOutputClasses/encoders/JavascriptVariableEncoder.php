<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace DirectOutputClasses\encoders;

/**
 * This safely encodes things which are to be echoed into the document as javascript variables
 * 
 * If the javascript variable name is legit but the php variable is unset, this will still return the assignment set to empty. 
 * If the javascript variable is illegit, it won't return an assignment or anything else;
 * 
 * @todo Perhaps add some logging for if illegitimate values are being passed around
 * @author adam
 * @since 17Feb2015
 */
class JavascriptVariableEncoder {

    /** @var $default What to return if the validation fails */
    static public $default = '';

    /**
     * Echoes a javascript variable assignment for the number
     * 
     * @param integer|float $php_variable The value to give the javascript variable
     * @param string $javascript_variable_name The name to give the javascript variable
     */
    public function encode_number($php_variable, $javascript_variable_name) {
        $clean = $this->sanitize_js_name($javascript_variable_name);
        if ($clean) {//js variable name is legit
            if (isset($php_variable) && is_numeric($php_variable)) {
                $number = $this->sanitize_number($php_variable);
                $this->format_and_output($clean, $number);
            } else {//php variable wasn't set or wasn't number
                $this->format_and_output($clean, self::$default);
            }
        }
    }

    /**
     * Create a javascript variable assignment for a string php value and echo it
     * 
     * @param string $php_variable The value to give the javascript variable
     * @param string $javascript_variable_name The name to give the javascript variable
     */
    public function encode_string($php_variable, $javascript_variable_name) {
        $clean = $this->sanitize_js_name($javascript_variable_name);
        if ($clean) {//js variable name is legit
            if (isset($php_variable) && is_string($php_variable)) {
                $escaped = $this->sanitize_string($php_variable);
                $this->format_and_output($clean, $escaped);
            } else {//php variable wasn't set or wasn't string
                $this->format_and_output($clean, self::$default);
            }
        }
    }
    
    public function encode_boolean($php_variable, $javascript_variable_name){
        $clean = $this->sanitize_js_name($javascript_variable_name);
        if ($clean) {//js variable name is legit
            if (is_bool($php_variable)) {
                $escaped = $this->sanitize_boolean($php_variable);
                $this->format_and_output($clean, $escaped);
            } else {//php variable wasn't set or wasn't string
                $this->format_and_output($clean, self::$default);
            }
        }
    }
    
    /**
     * Echoes the javascript opening tag
     */
    public function javascript_tag_open(){
        echo '<script type="text/javascript">';
    }
    
    /**
     * Echoes the closing tag for javascript
     */
    public function javascript_tag_close(){
        echo '</script>';
    }

    protected function sanitize_number($number) {
        if (\filter_var($number, \FILTER_VALIDATE_INT)) {
            return \filter_var($number, \FILTER_SANITIZE_NUMBER_INT);
        } elseif (\filter_var($number, \FILTER_VALIDATE_FLOAT)) {
            return \filter_var($number, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION);
        }
    }
    
    protected function sanitize_string($string){
        $escaped = \htmlentities($string, \ENT_QUOTES, 'UTF-8', false);
        return "'{$escaped}'";
    }
    
    protected function sanitize_boolean($php_boolean){
        if($php_boolean === TRUE){
            return true;
        }elseif($php_boolean === FALSE){
            return false;
        }
    }

    /**
     * Create the assignment and echo
     * @param type $clean_js_variable_string
     * @param type $value_to_set
     */
    protected function format_and_output($clean_js_variable_string, $value_to_set) {
        echo "var " . $clean_js_variable_string ." = " . $value_to_set . "; ";
    }

    /**
     * Makes sure the name for the javascript variable is legit and safe
     * 
     * @param string $javascript_variable_name
     * @return string|boolean
     */
    public function sanitize_js_name($javascript_variable_name) {
        try {
            $trimmed = \trim($javascript_variable_name);
            $stripped = \strip_tags($trimmed);
            $filtered = \filter_var($stripped, \FILTER_SANITIZE_STRING);
            $allowed = array("_");
            if(!ctype_alnum( str_replace($allowed, '', $filtered ))){
                return FALSE;
            }
            return $filtered;
        } catch (\Exception $e) {
            return FALSE;
        }
    }

}
