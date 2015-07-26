<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:53 PM
 */
namespace App\Repositories\Element;

use App\Comment;
use App\Element;

interface IElementRepository
{
    /**
     * Load an element object by its id
     * @param $elementId
     */
    public function loadElementById($elementId);

    /**
     * Create a new element
     * @param $elementName
     * @param $displayText
     * @param $commentText
     * @return Element
     */
    public function createElement($elementName, $displayText, $commentText);

    /**
     * Remove an element
     * @param $elementId
     */
    public function deleteElement($elementId);

    /**
     * Alter the content of an existing element
     * @param $elementId
     * @param $elementName
     * @param $displayText
     * @param $commentText
     */
    public function editElement($elementId, $elementName, $displayText, $commentText);

    /**
     * Adds a comment to the comments table and associates it with an
     * element assignment.
     *
     * @param $elementId
     * @param $valence
     * @param $content
     * @return Comment
     * @throws \Exception
     */
    public function addValencedContent($elementId, $valence, $content);
}