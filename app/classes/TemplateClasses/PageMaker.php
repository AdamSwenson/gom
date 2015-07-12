<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/1/15
 * Time: 6:14 PM
 */

namespace TemplateClasses;


class PageMaker extends Controller
{
    const HEAD_TEMPLATE = "html.base.head.twig";
//    const HEAD_W_NAVBAR_TEMPLATE = 'page.head_with_topbar.twig';
    const FOOT_TEMPLATE = 'html.base.pagebottom.twig';

    protected $pageName;

    protected $bodyRenderer;

    protected $jsIncludes = array();

    protected $stylesheets = array();

    /**
     * @param mixed $pageName
     */
    public function setPageName($pageName)
    {
        $this->pageName = $pageName;
        $this->add_variables(array('page_title' => $pageName));
    }

    public function addStyleSheets(array $sheets)
    {
        $this->stylesheets += $sheets;
    }

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Pushes the array of stylesheets into the variable array for the
     * renderer. Should be called right before render.
     */
    protected function pushStylesheets(){
        if(count($this->stylesheets) > 0){
            $this->add_variables(array('stylesheets' => $this->stylesheets));
        }
    }

//    /**
//     * Makes the page head with the nav bar
//     */
//    public function makePageTopWithNavBar()
//    {
//        $this->pushStylesheets();
//        $this->render(self::HEAD_W_NAVBAR_TEMPLATE);
//    }

    /**
     * Makes the page head and opening main body divs
     */
    public function makePageTop()
    {
        $this->pushStylesheets();
        $this->render(self::HEAD_TEMPLATE);
    }

    /**
     * Makes the closing div tags for the divs opened
     * by makePageTop, footer, and scriptbox
     * @param null $scripts
     * @param null $onload
     */
    public function makePageBottom($scripts = null, $onload = null)
    {
        if (!empty($scripts)) {
            $this->add_variables(array('scriptlist' => $scripts));
        }
        if(!empty($onload)){
            $this->add_variables(array('onload' => $onload));
        }
        $this->render(self::FOOT_TEMPLATE);
    }

}