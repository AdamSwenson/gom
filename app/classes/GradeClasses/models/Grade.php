<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 10:41 AM
 */

namespace GradeClasses\models;

/**
 * Class Grade
 * This is the object which represents a grade or evaluation
 *
 * Note that displayText need not be a letter. Could be 'good', 'poor', et cetera.
 *
 * Also, this class has no need to know its own criteria
 *
 * @package GradeClasses
 */
class Grade 
{

    /** @var  string The text grade to be displayed to user */
    protected $displayText;

    /** @var  float The numeric grade to be displayed to user or used in calculations */
    protected $displayNumeric;

    /** @var  int The order from best to worst that this grade sorts */
    protected $sortOrder;

    /**
     * @return mixed
     */
    public function getSortOrder()
    {
        return $this->sortOrder;
    }

    /**
     * @param mixed $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    /**
     * @return mixed
     */
    public function getDisplayText()
    {
        return $this->displayText;
    }

    /**
     * @param mixed $displayText
     */
    public function setDisplayText($displayText)
    {
        $this->displayText = $displayText;
    }

    /**
     * @return mixed
     */
    public function getDisplayNumeric()
    {
        return $this->displayNumeric;
    }

    /**
     * @param mixed $displayNumeric
     */
    public function setDisplayNumeric($displayNumeric)
    {
        $this->displayNumeric = $displayNumeric;
    }

    public function __clone(){}
}