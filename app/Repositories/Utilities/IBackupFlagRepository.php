<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/21/16
 * Time: 3:37 PM
 */
namespace App\Repositories\Utilities;


/**
 * This handles checking whether the database has been flagged
 * for backup and altering these flags
 * @package App\Repositories\Utilities
 */
interface IBackupFlagRepository
{
    /**
     * Sets a flag to indicate that the db needs backing up
     */
    public function setFlag();

    /**
     * Removes the flag so that the db is not purporting to need
     * backing up
     */
    public function removeFlag();

    /**
     * Checks whether the database has been flagged for d
     * @return boolean
     */
    public function isFlagged();
}