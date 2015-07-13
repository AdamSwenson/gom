<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 5:15 PM
 */

namespace CommentClasses\dao;


class IStockTextDaoMock extends \classes\MockParent implements IStockTextDao
{

    /**
     * Saves the new stock text to the db
     * @param $content
     * @param $valence
     * @param $type
     * @return int
     */
    public function saveNewText($content, $valence, $type)
    {
        $this->record_call(__FUNCTION__, array($content, $valence, $type));
        return $this->response;
    }

    /**
     * Returns all stock text with the given valence
     * @param $valence
     * @param string $type
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getByValence($valence, $type = self::TYPE_PREPEND)
    {
        $this->record_call(__FUNCTION__, array($valence, $type));
        return $this->response;
    }

    /**
     * Returns all stock text of the given type
     * @param $type
     * @return mixed
     */
    public function getByType($type)
    {
        $this->record_call(__FUNCTION__, array($type));
        return $this->response;
    }

    /**
     * Returns stock text with the id
     * @param $id
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getById($id)
    {
        $this->record_call(__FUNCTION__, array($id));
        return $this->response;
    }

    /**
     * Returns all stock texts
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getAll()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;
    }
}