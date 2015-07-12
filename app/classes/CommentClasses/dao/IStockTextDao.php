<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 5:06 PM
 */

namespace CommentClasses\dao;


interface IStockTextDao 
{


    /**
     * Saves the new stock text to the db
     * @param $content
     * @param $valence
     * @param $type
     * @return int
     */
    public function saveNewText($content, $valence, $type);


    /**
     * Returns all stock text with the given valence
     * @param $valence
     * @param string $type
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getByValence($valence, $type=self::TYPE_PREPEND);


    /**
     * Returns all stock text of the given type
     * @param $type
     * @return mixed
     */
    public function getByType($type);


    /**
     * Returns stock text with the id
     * @param $id
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getById($id);

    /**
     * Returns all stock texts
     * @return \Propel\Runtime\Collection\ObjectCollection|\StockText[]
     */
    public function getAll();

}