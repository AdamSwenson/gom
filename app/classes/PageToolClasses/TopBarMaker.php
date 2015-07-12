<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 * 
 */

namespace PageToolClasses;

/**
 * This creates the top bar element of most pages. 
 * The top bar element holds the page title and other items. It goes inside the container element and below the nav bar
 *
 * @author adam
 */
class TopBarMaker 
{
    /** @var $left_html The html to be displayed on the left portion of topbar */
    public $left_html = '';
    /** @var $title_html The html to be displayed in the title portion */
    public $title_html = '';
    /** @var $right_html The html to be displayed in the right portion */
    public $right_html = '';
    
    public function set_left($left_html){
        $this->left_html = $left_html;
    }
    
    public function set_title($title_html){
       $this->title_html = $title_html;
    }
    
    public function set_right($right_html){
        $this->right_html = $right_html;
    }
    
    public function make(){
        echo <<<OUT
        <div id="topbar" class="pageComponent">
            <div class='leftside'>$this->left_html</div>
            <div class='titlebar'><span class="pageTitle">$this->title_html</span></div>
            <div class="rightside">$this->right_html</div>
        </div>
OUT;
    }
    
}
