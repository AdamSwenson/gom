<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/2/15
 * Time: 12:46 PM
 */

namespace TagClasses\dao;


class TagAssignmentDao 
{

    protected $tagRelation;

    /**
     * Creates an association between a tag and an item
     * @param $item
     * @param $tag
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function assignTag($item, $tag)
    {
        switch(true)
        {
            case $item instanceof \Question:
                $q = \TaggedQuestionQuery::create()
                ->filterByQuestion($item)
                ->filterByTag($tag)
                ->findOneOrCreate();
                $q->save();
                break;

            case $item instanceof \Element:
                $q = \TaggedElementQuery::create()
                    ->filterByElement($item)
                    ->filterByTag($tag)
                    ->findOneOrCreate();
                $q->save();
                break;

            default:
                throw new \Exception();
        }
    }

    /**
     * Loads all tags for a given item
     * @param $item
     * @return \Propel\Runtime\Collection\ObjectCollection|\TaggedElement[]|\TaggedQuestion[]
     * @throws \Exception
     * @throws \Propel\Runtime\Exception\PropelException
     */
    public function loadTagsForItem($item)
    {
        switch(true)
        {
            case $item instanceof \Question:
                return \TaggedQuestionQuery::create()
                    ->filterByQuestion($item)
                    ->find();
                break;

            case $item instanceof \Element:
                return \TaggedElementQuery::create()
                    ->filterByElement($item)
                    ->find();
                break;

            default:
                throw new \Exception();
        }
    }

    /**
     * Loads tags which have at least one assignment
     */
    public function loadAllAssignedTags()
    {}

    /**
     * Deletes the association between a tag and an item (question, element, etc)
     * @param $item
     * @param $tag
     */
    public function removeTagAssignment($item, $tag)
    {}

}