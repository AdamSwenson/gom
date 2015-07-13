<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/31/15
 * Time: 1:29 PM
 */

namespace App\classes\PseudoIDClasses\service;


interface IPseudoIDMaker
{
    /**
     * Generates the random value for the pseudoID
     * @return string The candidate pseudoID
     */
    public function make();
}