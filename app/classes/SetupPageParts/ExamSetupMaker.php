<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/1/15
 * Time: 4:32 PM
 */

namespace SetupPageParts;

/**
 * Class ExamSetupMaker
 * Tools for making the components of the setup pages
 * @package SetupPageParts
 */
class ExamSetupMaker
{
    const SELECT_CLASS = 'newExamSelect';
    const DIV_CLASS = 'examCreationDiv';

    public static $default_years = array(2014, 2015, 2016, 2017, 2018, 2019, 2020);
    public static $default_terms = array('Spring', 'Fall', 'Winter');
    public static $default_topics = array();

    public $options = array();

    public $id;

    public $name;
    public $class;
    public $title;

    public function __set($name, $value)
    {
        //add string filter
        $this->name = $value;
    }

    public function set_properties($id = '', $name = '', $title = '', $class = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->class = $class;
    }

    public function set_options(array $options)
    {
        $this->options = $options;
    }


    public function make_div_open()
    {
        return "<div class='" . self::DIV_CLASS . "'>";
    }

    public function make_div_close()
    {
        return "</div>";
    }

    public function make_label()
    {
        return "<label class='creationSelectorLabel' for='{$this->id}'>{$this->title}</label> <br />";
    }

    public function make_box()
    {
        return "<input type='text' id='{$this->id}' name='{$this->name}' class='{$this->class}' /> <br />";
    }

    public function make_selector()
    {
        $out = "<select id='{$this->id}_select' data='{$this->id}' class='" . self::SELECT_CLASS . " {$this->class}' >";
        if (count($this->options) > 0) {
            foreach ($this->options as $opt) {
                $out .= "<option data='{$opt}' value='{$opt}'>{$opt}</option>";
            }
        }
        $out .= "</select>";
        return $out;
    }

    public function make_input($id = '', $name = '', $title = '', $class = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->class = $class;

        $out = $this->make_div_open();
        $out .= $this->make_label();
        $out .= $this->make_box();
        $out .= $this->make_selector();
        $out .= $this->make_div_close();
        echo $out;
    }


}