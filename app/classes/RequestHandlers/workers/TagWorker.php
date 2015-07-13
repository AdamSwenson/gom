<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/12/15
 * Time: 2:56 PM
 */

namespace App\classes\RequestHandlers\workers;


class TagWorker extends IRequestWorker
{

    public function handle($request)
    {

        $this->loadHelpers();

        switch($request->task())
        {
            case 'getAllTags':
                $this->getAllTags();
                break;
            default:
                throw new \Exception('bad tag request');
        }
    }


    public function getAllTags()
    {
    }
}