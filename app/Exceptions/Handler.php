<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
//            ModelNotFoundException::class,
        ValidationException::class,

    ];

    /**
     * Sends notification of the exception to slack
     * via our webhook (configured in the env file)
     *
     * @param Exception $e
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function notifySlackOfException( Exception $e )
    {
        //See https://api.slack.com/docs/messages/builder
        //for documentation
        $params = [
            "icon_emoji" => ":ghost:",
            'attachments' => [
                [
                    'fallback' => $e->getMessage(),
                    'title' => $e->getFile() . ' ' . $e->getLine(),
                    'pretext' => $e->getMessage(),
                    'text' => $e->getTraceAsString(),
                    'color' => 'danger'
                ]
            ],
        ];

        //Send it
        $client = new Client();
        $url = env('SLACK_HOOK_ERRORS');
        $res = $client->request('POST', $url, ['json' => $params]);
    }


    public function emailAboutException( Exception $e )
    {
        $msg = $e->getMessage() . ' \n ' . $e->getTraceAsString();

        Mail::raw($msg, function ( $message ) {
            $message->to('gradeomatic@gmail.com', 'devteam')
                ->subject('Exception');
        });

    }

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return void
     * @throws Exception
     */
    public function report( Exception $e )
    {
        $this->emailAboutException($e);
        $this->notifySlackOfException($e);
//        $msg = $e->getMessage() . ' \n ' . $e->getTraceAsString();
//
//        Mail::raw($msg, function ( $message ) {
//            $message->to('gradeomatic@gmail.com', 'devteam')->subject('Exception');
//        });
//
//        $client = new Client();
//
//        $params = [
//            "icon_emoji" => ":ghost:",
//            'attachments' => [
//                [
//                    'fallback' => $e->getMessage(),
//                    'title' => $e->getFile() . ' ' . $e->getLine(),
//                    'pretext' => $e->getMessage(),
//                    'text' => $e->getTraceAsString(),
//                    'color' => 'danger'
//                ]
//            ],
//        ];
//
//        $url = env('SLACK_HOOK_ERRORS');
//        $res = $client->request('POST', $url, ['json' => $params]);
//

        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render( $request, Exception $e )
    {
        //Respond via ajax if was an ajax request
        if ( $request->ajax() ) {
//            ['status' => 'fail', 'message' => 'There was a problem'];
//            redic
//            return
        }

        return parent::render($request, $e);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated( $request, AuthenticationException $exception )
    {
        if ( $request->expectsJson() ) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest('login');
    }
}
