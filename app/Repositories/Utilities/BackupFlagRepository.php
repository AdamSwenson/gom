<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 3/21/16
 * Time: 3:27 PM
 */

namespace App\Repositories\Utilities;

use Illuminate\Support\Facades\Redis;

/**
 * This handles checking whether the database has been flagged
 * for backup and altering these flags
 * 
 * @package App\Repositories\Utilities
 */
class BackupFlagRepository implements IBackupFlagRepository
{
    const BACKUP_FLAG_KEY = 'db-needs-backup';

    /**
     * Sets a flag to indicate that the db needs backing up
     */
    public function setFlag()
    {
        Redis::set(self::BACKUP_FLAG_KEY, 1);

        return true;
    }

    /**
     * Removes the flag so that the db is not purporting to need
     * backing up
     */
    public function removeFlag()
    {
        Redis::set(self::BACKUP_FLAG_KEY, 0);

        return true;
    }

    /**
     * Checks whether the database has been flagged for d
     * @return boolean
     */
    public function isFlagged()
    {
        return Redis::get(self::BACKUP_FLAG_KEY);
    }

}