<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 1/9/17
 * Time: 9:41 PM
 */

namespace App\Http\ViewComposers\navigation;

use Illuminate\View\View;

/**
 * Class CrumbComposer
 * Injects the variables needed for the breadcrumbs into master blade
 * just before it renders
 *
 * @package App\Http\ViewComposers\navigation
 */
class CrumbComposer
{
    /** @var  The index for identifying which page we are on */
    public $activeIndex;

    /** @var  The set of links to display */
    public $group;

    /** @var array Valid values for 'group' */
    static public $groups = ['main', 'setup'];

    /**
     * Create a new profile composer.
     *

     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...

    }

    public function getActiveIndex()
    {
//somehow look up the appropriate index value for the request
        //set it as activeIndex

        //return it
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            'group' => $this->group,
            'activeIndex' => $this->activeIndex
        ]);
    }

}