<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentAccessRequest;
use App\Repositories\Feedback\FeedbackBuilder;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Feedback\IAccessKeyRepository;

/**
 * Class PublicFeedbackController
 *
 * This handles requests from students who are trying to see their feedback
 *
 * @package App\Http\Controllers
 */
class PublicFeedbackController extends Controller
{

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
        $data = $this->accessKeyRepository->retrieveFeedback($accessKey);

        return view('feedback.feedback', compact('data'));
    }

    /**
     * Redirects to student arrival page where they can enter in their access key
     */
    public function showLogin()
    {
        return view('feedback.login');
    }


}
