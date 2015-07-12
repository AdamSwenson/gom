<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/4/15
 * Time: 7:00 AM
 */

namespace OutputClasses\dao;


interface ICredentialLookup 
{

    public function authenticate($access_token);

    /**
     * Returns the student object that has been created
     */
    public function get_student();

    public function get_exam();
}