<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/22/15
 * Time: 9:55 AM
 */

namespace App\classes\RequestHandlers\dao;


class ElementDAO
{
    const VALENCE_ABSENT = 100;
    const VALENCE_POOR = 101;
    const VALENCE_OK = 102;
    const VALENCE_EXCELLENT = 103;

    /**
     * Load an element object by its id
     * @param $elementId
     */
    public function loadElementById($elementId)
    {}

    /**
     * Create a new element
     */
    public function createElement($elementName, $displayText, $commentText)
    {}

    /**
     * Remove an element
     * @param $elementId
     */
    public function deleteElement($elementId)
    {}

    /**
     * Alter the content of an existing element
     * @param $elementId
     * @param $elementName
     * @param $displayText
     * @param $commentText
     */
    public function editElement($elementId, $elementName, $displayText, $commentText)
    {}

    /**
     *
     * @param $elementId
     * @param $valence
     * @param $content
     */
    public function addValencedContent($elementId, $valence, $content)
    {

    }

}