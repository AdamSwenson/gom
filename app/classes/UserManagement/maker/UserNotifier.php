<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/11/15
 * Time: 6:30 PM
 */

namespace App\classes\UserManagement\maker;

use SplSubject;

/**
 * Class UserNotifier
 * Handles status messages to the user as the creation
 * process unfolds.
 * @package lib\classes\UserManagement\maker
 */
class UserNotifier implements \SplObserver
{
    const MESSAGE_COMPLETE_FAILURE = "We are very sorry. An error prevented us from finishing the set up of your account.";

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
        if($subject->kill)
        {
            $this->bailOut();
        }
        echo $news_event;
    }

    /**
     * Notify user that fatal error has occurred.
     */
    protected function bailOut()
    {
        $this->display_status(self::MESSAGE_COMPLETE_FAILURE);
    }

    /**
     * Manages updates to user of progress as setup
     * @param type $result
     * @param string $message Message to be displayed to user
     */
    public function updateuser($result, $message) {
        if (isset($result)) {
            $this->display_status($message);
        } else {
            $this->display_status("An error occurred in the process that would have resulted in telling you :" . $message);
        }
    }

    /**
     * Displays a status update
     * @param string $message Message to output
     */
    public function display_status($message) {
        echo "<p class='statusMessage'>$message</p>";
    }

}