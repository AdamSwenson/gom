<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class errorNotification extends Mailable
{
    use Queueable, SerializesModels;
const EMAIL_VIEW = 'emails.internal.errorNotification';
    const DESTINATION_ADDRESS = 'gradeomatic@gmail.com';
    const RECIPIENT = 'devteam-alert';

    public $file;
    public $msg;
    public $trace;
    /**
     * @var string
     */
    public $url;
    /**
     * @var string
     */
    public $method;
    /**
     * @var string
     */
    public $ip;
    /**
     * @var array
     */
    public $ips;
    /**
     * @var string
     */
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $exception )
    {
        $request = request();
        $this->name = get_class($exception);

        $this->subject = 'Exception: ' . $this->name;

        $this->msg = $exception->getMessage();
        $this->trace = $exception->getTraceAsString();
        $this->file = $exception->getFile();
        $this->url = $request->fullUrl();
        $this->method = $request->method();
        $this->ip = $request->ip();
        $this->ips = $request->ips();


//        $this->payload = [
//            'msg' => $exception->getMessage(),
//        'trace' => $exception->getTraceAsString(),
//        'file' => $exception->getFile(),
//        'name' => $name,
//            'url' => $request->fullUrl(),
//        'method' => $request->method(),
//        'ip' => $request->ip(),
//        'ips' => $request->ips()
//];

//        $ips = 's'; //$request->ips();
//        var_dump($e)


        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(self::EMAIL_VIEW)
            ->from(self::DESTINATION_ADDRESS, self::RECIPIENT)
            ->subject($this->subject);
    }
}
