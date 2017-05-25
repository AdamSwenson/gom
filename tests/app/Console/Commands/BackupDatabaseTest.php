<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/20/17
 * Time: 3:23 PM
 */

namespace App\Console\Commands;

/**
 * Class BackupDatabaseTest
 *
 * Main cases:
 *      Called with --force
 *          Happy path
 *          Sad paths
 *
 *      Called without --force
 *          Flag set
 *              Happy path
 *              Sad paths
 *          Flag not set
 *              Happy path
 *              Sad paths
 *
 * @package App\Console\Commands
 */
class BackupDatabaseTest extends \TestCase
{

    protected $object;

    public function setUp()
    {
        parent::setUp();
        $this->object = new BackupDatabase;
    }



}
