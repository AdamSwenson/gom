<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 6:22 PM
 */

namespace UserManagement\maker;


use SplObserver;

class SetupWatcher implements \SplSubject, ISetupWatcher
{
    const USER_RECORD_FOUND = "Located user record from token";

    const USER_RECORD_NOT_FOUND = "Could not locate user from token submitted.";

    const DB_CREDENTIALS_CREATED  = "User db credentials created";

    const DB_CREDENTIALS_NOT_CREATED  = "Could not create db credentials";

    const TABLES_CREATED = "User schema created";

    const TABLES_NOT_CREATED = "Could not create user schema";

    const GOM_USER_COMPLETE = "Operations on gom user complete";


    public $latest;

    public $kill = false;

    private $storage;

    public function __construct()
    {
        $this->storage = new \SplObjectStorage();
    }

    public function update($message)
    {
        $this->latest = $message;
        $this->notify();
    }

    /**
     * If a process fails, it will hand an exception to the watcher. This
     * handles the logging and user notification in that event.
     * @param $exception
     */
    public function handleException($exception)
    {

    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Attach an SplObserver
     * @link http://php.net/manual/en/splsubject.attach.php
     * @param SplObserver $observer <p>
     * The <b>SplObserver</b> to attach.
     * </p>
     * @return void
     */
    public function attach(SplObserver $observer)
    {
        $this->storage->attach($observer);

    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Detach an observer
     * @link http://php.net/manual/en/splsubject.detach.php
     * @param SplObserver $observer <p>
     * The <b>SplObserver</b> to detach.
     * </p>
     * @return void
     */
    public function detach(SplObserver $observer)
    {
        $this->storage->detach($observer);
    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Notify an observer
     * @link http://php.net/manual/en/splsubject.notify.php
     * @return void
     */
    public function notify()
    {
        foreach($this->storage as $obs)
        {
            $obs->update($this);
        }
    }
}