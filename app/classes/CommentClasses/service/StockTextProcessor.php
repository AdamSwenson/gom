<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/7/15
 * Time: 12:09 PM
 */

namespace CommentClasses\service;

/**
 * Class StockTextProcessor
 * This cleans and processes new stock text from user and stores it
 * @package classes\CommentClasses\service
 */
class StockTextProcessor
{

    public $dao;

    /**
     * @param mixed $dao
     */
    public function setDao(\CommentClasses\dao\IStockTextDao $dao)
    {
        $this->dao = $dao;
    }

    /** @var  $response_handler \JsonOutputClasses\controllers\IResponseChooser */
    public $response_handler;

    /** @var  $cleaner \SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    /**
     * @param \SecurityClasses\cleaning\ICleanerFactory $cleaner
     */
    public function load_cleaner(\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    public function set_response_handler(\JsonOutputClasses\controllers\IResponseChooser $response_handler)
    {
        $this->response_handler = $response_handler;
    }


    public function save_new_text($text, $valence)
    {
        $clean_text = $this->cleaner->sanitize($text, 'text');
        $result = $this->dao->saveNewText($clean_text, $valence, \CommentClasses\dao\StockTextDao::TYPE_PREPEND);
        if($result){
            $this->response_handler->handle_row_count(1);
        }else{
            $this->response_handler->handle_row_count(0);
        }
        return $result;
//        if($this->check_valence($valence)){
//            $clean_text = $this->cleaner->sanitize($text, 'text');
//            $st = new \StockText();
//            $st->setValence($valence);
//            $st->setContent($clean_text);
//            $st->save();
//            if($st->getId()){
//                $this->response_handler->handle_row_count(1);
//            }
//            else{
//                $this->response_handler->handle_row_count(0);
//            }
//            return $st;
//        }
    }

//    public function check_valence($valence)
//    {
//        return in_array($valence, \CommentClasses\dao\StockTextDao::$valences);
//    }
}