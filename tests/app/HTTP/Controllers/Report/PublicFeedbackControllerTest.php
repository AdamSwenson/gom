<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/12/16
 * Time: 6:38 PM
 */

namespace App\HTTP\Controllers\Report;


use App\AccessKey;
use App\Feedback;
use App\Repositories\Feedback\IAccessKeyRepository;

class PublicFeedbackControllerTest extends \TestCase
{

    public $feedback;
    public $key;
    protected $object;

    public function setUp()
    {
        parent::setUp();

        $this->feedback = factory(Feedback::class)->create();
        $this->key = $this->feedback->access_key;

        /*
         *
# If arrived via link in email to student
Route::get('feedback', 'PublicFeedbackController@showFeedback');
# If arrived via feedback login page
Route::post('feedback/login', 'PublicFeedbackController@showFeedback');
Route::get('feedback/login', 'PublicFeedbackController@showLogin');
Route::get('feedback/view', 'PublicFeedbackController@showFeedback');*/
    }

    public function setUpTests(){
        $accessKeyDao = $this->createMock(IAccessKeyRepository::class);
        $accessKeyDao->shouldReceive('retrieveFeedback')
            ->with($this->key)
            ->once()
            ->andReturn($this->feedback);

        $accessKeyDao->shouldReceive("getStudentInfo")
            ->once()
            ->with($this->key)
            ->andReturn(['studentName' => 'name', 'studentIdentifier' => 'identifier']);
    }

    /** @test */
    public function showFeedbackViaGet(){
        #prep
        $route = 'feedback';
        $this->setUpTests();

        #call
        $this->call("GET", $route, ['accessKey' => $this->key ]);
    }

    /** @test */
    public function showFeedbackViaPost(){
        #prep
        $route = 'feedback/login';
        $this->setUpTests();

        #call
        $this->call("POST", $route, ['accessKey' => $this->key ]);
    }

    /** @test */
    public function showFeedbackViaView(){
        #prep
        $route = 'feedback/view';
        $this->setUpTests();

        #call
        $this->call("GET", $route, ['accessKey' => $this->key ]);
    }

    /** @test */
    public function showFeedbackInvalidKey(){
        #prep
        $route = 'feedback';

        #call
        $this->call("GET", $route, ['accessKey' => 'taco' ]);
        $this->assertSessionHasErrors();
    }



    public function showFeedbackEmptyKey(){
//TODO Figure out how to test this
        $route = 'feedback';

        #call
        $this->call("GET", $route);
        $this->assertResponseOk();

    }


    /** @test */
    public function showLoginViaGet(){
        $route = 'feedback/login';

        $this->call("GET", $route);
        $this->assertResponseOk();

    }

}
