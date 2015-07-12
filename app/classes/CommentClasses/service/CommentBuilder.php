<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/3/15
 * Time: 2:47 PM
 */

namespace CommentClasses\service;


use CommentClasses\dao\StockTextDao;
use CommentClasses\errors\CommentException;

class CommentBuilder
{

    public $stockTextDao;

    /**
     * Combines the stock text and the comment text
     * @param $comment
     * @param $stock
     * @return string
     * @throws CommentException
     */
    public function build($comment, $stock)
    {
        $new = $this->addStockText($comment, $stock);
        return $new;
    }

    protected function addStockText($comment, $stock)
    {
        switch($stock->getType())
        {
            case StockTextDao::TYPE_PREPEND:
                return $this->cleanUp($stock) . ' ' . $this->cleanUp($comment);
                break;
            case StockTextDao::TYPE_APPEND:
                return $this->cleanUp($comment) . ' ' . $this->cleanUp($stock);
                break;
            case StockTextDao::TYPE_INJECT:
                break;
            default:
                throw new CommentException(CommentException::INVALID_TYPE);
        }
    }

    /**
     * This makes sure that any errant spaces at beginning or end
     * don't make things look weird.
     * @param $text
     * @return string
     */
    protected function cleanUp($text)
    {
        return trim($text);
    }
}