<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 2:46 PM
 */

namespace App\classes\CommentClasses\dao;


use App\classes\CommentClasses\errors\CommentException;

class StockTextDao implements IStockTextDao
{

    const TYPE_PREPEND = "pre";
    const TYPE_INJECT = "mid";
    const TYPE_APPEND = "post";

    const VALENCE_MISSING = "missing";
    const VALENCE_POOR = "poor";
    const VALENCE_COMPETENT = "competent";
    const VALENCE_EXCELLENT = "excellent";

    public static $valences = array(self::VALENCE_MISSING, self::VALENCE_MISSING, self::VALENCE_POOR, self::VALENCE_COMPETENT, self::VALENCE_EXCELLENT);

    public static $types = array(self::TYPE_PREPEND, self::TYPE_INJECT, self::TYPE_APPEND);

    /**
     * Saves the new stock text to the db
     * @param $content
     * @param $valence
     * @param $type
     * @return int
     */
    public function saveNewText($content, $valence, $type=self::TYPE_PREPEND)
    {
        $this->validateValence($valence);
        $this->validateType($type);

        $txt = new \StockText();
        $txt->setContent($content);
        $txt->setValence($valence);
        $txt->setType($type);
        return $txt->save();
    }

    /**
     * Returns all stock text with the given valence
     * @param $valence
     * @param string $type
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getByValence($valence, $type=self::TYPE_PREPEND)
    {
        return \StockTextQuery::create()
            ->filterByValence($valence)
            ->filterByType($type)
            ->find();
    }

    /**
     * Returns all stock text of the given type
     * @param $type
     * @return mixed
     */
    public function getByType($type)
    {
        return \StockTextQuery::create()->filterByType($type)->find();
    }

    /**
     * Returns stock text with the id
     * @param $id
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getById($id)
    {
        return \StockTextQuery::create()->filterById($id)->find();
    }

    /**
     * Returns all stock texts
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getAll()
    {
        return \StockTextQuery::create()->find();
    }

    protected function validateValence($valence)
    {
        if(in_array($valence, self::$valences))
        {
            return $valence;
        }
        else{
            throw new CommentException(CommentException::INVALID_VALENCE);
        }
    }

    /**
     * Makes sure the alleged type is expected
     * @param $type
     * @return mixed
     * @throws CommentException
     */
    protected function validateType($type)
    {
        if(in_array($type, self::$types))
        {
            return $type;
        }
        else{
            throw new CommentException(CommentException::INVALID_VALENCE);
        }
    }

}