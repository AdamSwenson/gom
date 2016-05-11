<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAccessRequest;
use App\Repositories\Feedback\FeedbackBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Feedback\IAccessKeyRepository;
use Laracasts\Flash\Flash;

/**
 * Class PublicFeedbackController
 *
 * This handles requests from students who are trying to see their feedback
 *
 * @package App\Http\Controllers
 */
class PublicFeedbackController extends Controller
{
    /** The main feedback view which displays the feedback for the student */
    const FEEDBACK_DISPLAY_VIEW = 'feedback.feedback';

    /** The log in page for viewing feedback */
    const FEEDBACK_LOGIN = 'feedback.login';

    /**
     * @var IAccessKeyRepository
     */
    private $accessKeyRepository;

    /**
     * @param IAccessKeyRepository $accessKeyRepository
     */
    public function __construct(IAccessKeyRepository $accessKeyRepository)
    {
        $this->accessKeyRepository = $accessKeyRepository;
    }

    /**
     * Retrieves and shows the feedback for the student
     *
     * @param StudentAccessRequest $request
     * @return \Illuminate\View\View
     */
    public function showFeedback(StudentAccessRequest $request)
    {
        $accessKey = $request->input('accessKey');
        if (empty($accessKey))
        {
            //they somehow did not hae an accessKey in the get request, so
            //redirect them to the login page where they can paste it into
            //the login form
            return $this->showLogin();
        }
        try
        {
            $fb = $this->accessKeyRepository->retrieveFeedback($accessKey);

            //this shouldn't be necessary because the StudentAccessRequest checks that the
            //key is present in the db. Keeping it here just in case.
            if(empty($fb)){ throw new \Exception("Invalid access key provided"); }

            $info = $this->accessKeyRepository->getStudentInfo($accessKey);

            $data = [];
            $data['content'] = $fb->content; //stored as array so should cast to array
            //add the access key to the content array so can just return that.
            $data['accessKey'] = $accessKey;
            $data['studentName'] = $info['studentName'];
            $data['studentIdentifier'] = $info['studentIdentifier'];
            $data['grade'] = $fb->grade_display;

            return View::make(self::FEEDBACK_DISPLAY_VIEW)
                ->with(['data' =>  $data]);
//            return view(self::FEEDBACK_DISPLAY_VIEW, compact('data'));
        } catch (\Exception $e)
        {
            Log::warning("Error retrieving feedback " . $e, ['accessKey' => $accessKey]);
            Flash::error("There was a problem retrieving your feedback. Please try again");
            return $this->showLogin();
        }
    }

    /**
     * Redirects to student arrival page where they can enter in their access key
     */
    public function showLogin()
    {
        return view(self::FEEDBACK_LOGIN);
    }


}
