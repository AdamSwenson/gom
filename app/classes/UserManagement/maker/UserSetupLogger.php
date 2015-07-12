<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 6:32 PM
 */

namespace UserManagement\maker;


use SplSubject;

class UserSetupLogger implements \SplObserver
{

    /**
     * (PHP 5 &gt;= 5.1.0)<br/>
     * Receive update from subject
     * @link http://php.net/manual/en/splobserver.update.php
     * @param SplSubject $subject <p>
     * The <b>SplSubject</b> notifying the observer of an update.
     * </p>
     * @return void
     */
    public function update(SplSubject $subject)
    {
        $news_event = $subject->latest;

    }
}