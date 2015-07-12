<?php
namespace OutputClasses;
/**
 * Covers the classes which make the chart for the student output viewer
 */
abstract class StudentChart extends \DAO\BaseDao
{
    protected $questionAverages;
    protected $elementAverages;

    public function __construct()
    {
        #Create PDO connection
        parent::__construct();
        }//construct
}
