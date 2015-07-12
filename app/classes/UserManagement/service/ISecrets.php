<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/9/15
 * Time: 5:29 PM
 */

namespace UserManagement\service;


interface ISecrets 
{


    public function getDsn();

    public function getUsername();

    public function getPassword();

}