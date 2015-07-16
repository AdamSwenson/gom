<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/2/15
 * Time: 12:46 PM
 */

namespace App\classes\TagClasses\dao;

use App\classes\Traits\UserTraits;

/**
 * Class TagDao
 * Handles creating, editing, and deleting tags which are applied to
 * questions, elements, etc
 * @package App\classes\TagClasses\dao
 */
class TagDao 
{
    use UserTraits;

    /** @var \User */
    public $user;

    function __construct()
    {
        $this->user = $this->getUser();
    }

    /**
     * Creates a new tag with the specified text
     * @param $tagtext
     */
    public function createTag($tagtext)
    {}

    /**
     * Edits an existing tag
     * @param $tag
     */
    public function editTag($tag)
    {}

    /**
     * Deletes a tag from the database
     * Also removes all its associations via cascade
     * @param $tag
     */
    public function deleteTag($tag)
    {}

}