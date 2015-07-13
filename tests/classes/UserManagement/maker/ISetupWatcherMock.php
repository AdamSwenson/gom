<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/15
 * Time: 10:53 AM
 */

namespace UserManagement\maker;


class ISetupWatcherMock extends \classes\MockParent implements ISetupWatcher
{

    public function update($message)
    {
        $this->record_call(__FUNCTION__, array($message));
        return $this->response;
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
    public function attach(\SplObserver $observer)
    {
        $this->record_call(__FUNCTION__, array($observer));
        return $this->response;
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
    public function detach(\SplObserver $observer)
    {
        $this->record_call(__FUNCTION__, array($observer));
        return $this->response;

    }

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Notify an observer
     * @link http://php.net/manual/en/splsubject.notify.php
     * @return void
     */
    public function notify()
    {
        $this->record_call(__FUNCTION__, array());
        return $this->response;

    }

    /**
     * If a process fails, it will hand an exception to the watcher. This
     * handles the logging and user notification in that event.
     * @param $exception
     * @return bool|\classes\The
     */
    public function handleException($exception)
    {
        $this->record_call(__FUNCTION__, array($exception));
        return $this->response;
    }
}