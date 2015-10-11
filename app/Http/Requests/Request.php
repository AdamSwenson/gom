<?php

namespace App\Http\Requests;

use App\Exceptions\SilentlyLoggedException;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{

    /** @var array This holds the validation rules which are constructed on the fly */
    protected $rulesArray = [];

    /** @var array Holds the messages for the rules which are generated on the fly */
    protected $messagesArray = [];

    /**
     * If the number of incoming items is less than the max allowed, iterate through
     * the count of the incoming items. Otherwise limit the iteration to the defined maximum.
     *
     * This will only really be important in the case of an attack where someone passes a huge incoming request to
     * eat up system resources.
     *
     * @param integer $maxItems The absolute maximum number of allowed items
     * @param null $type
     * @return int
     * @throws SilentlyLoggedException
     */
    protected function chooseLimit($maxItems, $type=null)
    {
        $incomingCount = count($this->all());
        if($incomingCount < $maxItems)
        {
            return $incomingCount;
        }
        throw new SilentlyLoggedException($type, " Incoming count was: $incomingCount. Allowed maximum was $maxItems");
        return $maxItems;
    }


}
