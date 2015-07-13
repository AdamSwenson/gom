<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/14/15
 * Time: 1:19 PM
 */

namespace App\classes\ElementClasses\service;


class ElementFactory
{
    /** @var  $cleaner \App\classes\SecurityClasses\cleaning\ICleanerFactory */
    public $cleaner;

    /**
     * @param \App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner
     */
    public function set_cleaner(\App\classes\SecurityClasses\cleaning\ICleanerFactory $cleaner)
    {
        $this->cleaner = $cleaner;
    }

    /**
     * @param \App\classes\RequestClasses\IRequest $request
     * @return bool|\Element
     */
    public function load(\App\classes\RequestClasses\IRequest $request)
    {
        if(isset($request->http['elementID']))
        {
            $id = $this->cleaner->sanitize($request->http['elementID'], 'integer');
            if($id)
            {
                return \ElementQuery::create()->filterById($id)->findOne();
            }
        }else{
            return FALSE;
        }
    }


}