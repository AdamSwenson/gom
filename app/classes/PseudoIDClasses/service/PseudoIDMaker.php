<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/31/15
 * Time: 12:22 PM
 */

namespace PseudoIDClasses\service;

/**
 * Class PseudoIDMaker
 * Handles creating pseudoIDs (temporary access codes for students to access exams)
 * @package PseudoIDClasses\service
 */
class PseudoIDMaker implements IPseudoIDMaker
{

    /** The number of random bytes to create for lookup id  */
    const LOOKUP_SIZE = 225;

    /**
     * Generates the random value for the pseudoID
     * @return string The candidate pseudoID
     */
    public function make()
    {
        $candidate = sha1(\openssl_random_pseudo_bytes(self::LOOKUP_SIZE));
        return $candidate;
    }
}