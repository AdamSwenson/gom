<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/25/15
 * Time: 7:47 PM
 */

namespace App\Repositories\Element;

use App\classes\SecurityClasses\cleaning\ICleanerFactory;
use App\classes\SecurityClasses\cleaning\CleanerFactory;
use App\Comment;
use App\Element;

class ElementRepository implements IElementRepository
{
    const MAX_COMMENT_LENGTH = 2000;
    const MAX_NAME_LENGTH = 200;
    const MAX_DISPLAY_LENGTH = 200;

    /** @var  $cleaner ICleanerFactory */
    public $cleaner;

    /**
     * Loads the class which handles cleaning before query
     * @param ICleanerFactory $cleanerFactory
     */
    public function set_cleaner(ICleanerFactory $cleanerFactory)
    {
        $this->cleaner = $cleanerFactory;
    }

    /**
     * Load an element object by its id
     * @param $elementId
     */
    public function loadElementById($elementId)
    {
        return Element::findOrFail($elementId);
//        $clean_id = $this->cleaner->sanitize($elementId, CleanerFactory::INTEGER);
//        if (!empty($clean_id))
//        {
//            return Element::findOrFail($clean_id);
//        }
    }

    /**
     * Create a new element
     * @param $elementName
     * @param $displayText
     * @param $commentText
     * @return Element
     */
    public function createElement($elementName, $displayText, $commentText)
    {
        $clean_name = $elementName;
        $clean_display = $displayText;
        $clean_comment = $commentText;

//        $clean_name = $this->cleaner->sanitize($elementName, CleanerFactory::TEXT, self::MAX_NAME_LENGTH);
//        $clean_display = $this->cleaner->sanitize($displayText, CleanerFactory::TEXT, self::MAX_DISPLAY_LENGTH);
//        $clean_comment = $this->cleaner->sanitize($commentText, CleanerFactory::TEXT, self::MAX_COMMENT_LENGTH);
//
        $element = new Element();
        $element->setElementName($clean_name);
        $element->setDisplayText($clean_display);
        $element->setCommentText($clean_comment);

        $element->save();

        return $element;
    }

    /**
     * Remove an element
     * @param Element|integer $element
     * @return bool|null
     */
    public function deleteElement($element)
    {
        if (!($element instanceof Element))
        {
            $element = Element::findOrFail($element);
        }
//            $clean_id = $this->cleaner->sanitize($element, CleanerFactory::INTEGER);
//            if (!empty($clean_id))
//            {
//                $element = Element::findOrFail($clean_id);
//            }
        return $element->delete();

    }

    public function updateElement($elementId, $elementName, $displayText, $commentText)
    {
        return $this->editElement($elementId, $elementName, $displayText, $commentText);
    }

    /**
     * Alter the content of an existing element
     * TODO Refactor out displayText
     * @param $elementId
     * @param $elementName
     * @param $displayText
     * @param $commentText
     */
    public function editElement($elementId, $elementName, $displayText, $commentText)
    {
        $clean_id = $elementId;
        $clean_name = $elementName;
        $clean_display = $displayText;
        $clean_comment = $commentText;

//        $clean_id = $this->cleaner->sanitize($elementId, CleanerFactory::INTEGER);
//        $clean_name = $this->cleaner->sanitize($elementName, CleanerFactory::TEXT, self::MAX_NAME_LENGTH);
//        $clean_display = $this->cleaner->sanitize($displayText, CleanerFactory::TEXT, self::MAX_DISPLAY_LENGTH);
//        $clean_comment = $this->cleaner->sanitize($commentText, CleanerFactory::TEXT, self::MAX_COMMENT_LENGTH);


        $element = Element::findOrFail($clean_id);;
        $element->setElementName($clean_name);
        $element->setDisplayText($clean_display);
        $element->setCommentText($clean_comment);

        $element->update();

        return $element;
    }

    /**
     * Loads a comment object given the element id it is associated with
     * and the valence
     *
     * @param $elementId
     * @param $valence
     * @return Comment
     */
    public function loadCommentByElementIdAndValence($elementId, $valence)
    {
        return Comment::where('element_id', $elementId)->where('valence', $valence)->first();
    }

    /**
     * Adds a comment to the comments table and associates it with an
     * element assignment. If the valence and element id are already in the table,
     * updates the associated body text
     *
     *
     * @param $elementId
     * @param $valence
     * @param $content
     * @return Comment
     * @throws \Exception
     */
    public function addValencedContent($elementId, $valence, $content)
    {
        $clean_body = $content;
        //$clean_body = $this->cleaner->sanitize($content, CleanerFactory::TEXT, Comment::MAX_BODY_LENGTH);

        $preExisting = $this->loadCommentByElementIdAndValence($elementId, $valence);

        if($preExisting)
        {
            $preExisting->setBody($clean_body);
            $preExisting->update();
            return $preExisting;
        }else{
            $comment = new Comment();
            $comment->setValence($valence);
            $comment->setBody($clean_body);
            $element = $this->loadElementById($elementId);
            $comment->element()->associate($element);
            $comment->save();
            return $comment;
        }
    }
}