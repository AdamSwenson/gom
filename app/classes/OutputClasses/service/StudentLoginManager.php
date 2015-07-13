<?php

/*
 * Gradeomatic
 * Copyright Adam Swenson Merp Co Intl
 *
 */

namespace App\classes\OutputClasses\service;

/**
 * This handles the student access on the output page.
 *
 * Appropriate call order:
 * $student_login_manager = new StudentLoginManager
 * $student_login_manager->set_lookup($disposibleIDLookup)
 * $student_login_manager->process_access_token($accesstoken)
 * //At this point, we've retrieved the instructor's readonly credentials and they are stored inside lookup.
 * //Now we need to create a dataservice to handle requests for scores and comments
 * $student_login_manager->get_credentials($secrets)
 * //Finally, we can make a student object which has the relevant data for requests
 * $student_login_manager->make_student(\App\classes\StudentClasses\factories\StudentPIDFactory, $pseudoid)
 * $student_login_manager->set_exam(new \ExaminationClasses\models\ExamLight());
 *
 * @author adam
 */
class StudentLoginManager {

    /** @var $lookup \App\classes\OutputClasses\dao\ICredentialLookup */
    protected $lookup;

    /** @var $secrets  */
    public $secrets;

    /** @var $dataservice  */
    public $dataservice;

    /** @var $student \Student */
    protected $student;

    /** @var $exam \Exam */
    protected $exam;

    /**
     * Stores the object which will handle looking up the db credentials in self::lookup
     * @param \App\classes\OutputClasses\dao\ICredentialLookup $lookup
     */
    public function set_lookup(\App\classes\OutputClasses\dao\ICredentialLookup $lookup) {
        $this->lookup = $lookup;
    }

    public function login(\App\classes\RequestClasses\IRequest $request)
    {
        if (isset($request->http['access_code']) && isset($request->http['lookup'])) {
            try {
                $this->process_access_token($request->http['access_code']);
                if ($this->lookup->success) {
                    return \App\classes\OutputClasses\facades\Visitor::make($this->lookup->get_exam(),
                        $this->lookup->get_student());
                }
            } catch (\Exception $e) {
            }
        }
     }

    /**
     * Calls \Interfaces\ICredentialLookup::authenticate on the token provided by the student
     * TODO add further cleaning
     * @param string $accesstoken
     * @throws \Exception
     */
    public function process_access_token($accesstoken) {
        try {
            if (ctype_alnum($accesstoken)) {
                $this->lookup->authenticate($accesstoken);
            } else {
                throw new \Exception("Invalid input to process_access_token");
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Once all the objects are intialized, the first order of business is to lookup the readonly credentials associated with the instructor who
     * gave the student logging in the access token.
     */
    public function get_credentials() {
    }

    /**
     * Takes the secrets object that has been stored and creates the read only dataservice class which is stored in dataservice
     */
    public function create_dataservice() {
    }

    public function make_visitor()
    {

    }

    /**
     * Creates the student object and stores in $this->student
     */
    public function make_student()
    {

    }

    /**
     * Loads associated exam into self::exam
     * @todo Setup set_exam
     */
    public function set_exam(\Exam $exam) {
    }

}
