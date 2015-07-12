<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/15
 * Time: 10:52 AM
 */

namespace UserManagement\maker;


interface ISetupWatcher 
{

    public function update($message);

    /**
     * If a process fails, it will hand an exception to the watcher. This
     * handles the logging and user notification in that event.
     * @param $exception
     */
    public function handleException($exception);

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Attach an SplObserver
     * @link http://php.net/manual/en/splsubject.attach.php
     * @param \SplObserver $observer <p>
     * The <b>SplObserver</b> to attach.
     * </p>
     * @return void
     */
    public function attach(\SplObserver $observer);

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Detach an observer
     * @link http://php.net/manual/en/splsubject.detach.php
     * @param \SplObserver $observer <p>
     * The <b>SplObserver</b> to detach.
     * </p>
     * @return void
     */
    public function detach(\SplObserver $observer);

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Notify an observer
     * @link http://php.net/manual/en/splsubject.notify.php
     * @return void
     */
    public function notify();


}