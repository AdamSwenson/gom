<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 3:32 PM
 */

namespace App\classes\RequestClasses;


interface IFileRequest
{

    /**
     * Captures any files that came in with the request
     */
    public function load_files();

    /**
     * Checks whether loaded valid files
     * @return boolean
     */
    public function received_files();



}