<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/8/15
 * Time: 7:11 AM
 */

namespace TemplateClasses;


class NavBar extends Controller
{

    public $base_template = 'navbar.base.twig';

    /** @var array Link values for the template with account stuff */
    public $account_vars;

    /** @var  array Link values for items common to all templates */
    public $basic_vars;


    public function __construct()
    {  parent::__construct();
        $this->account_vars = array(
            'account' => 'account.php',
            'user_settings' => 'user_settings.php',
            'preferences' => \classes\Navigation::PREFERENCES,
            'logout' => 'logout.php',
        );

        $this->basic_vars = array(
            'index' => 'index.php',
            'output' => \classes\Navigation::OUTPUT,
            'instructions' => \classes\Navigation::INSTRUCTIONS
        );

        $this->teacher_admin_variables = array(
            'exam_setup' => \classes\Navigation::EXAMSETUP,
            'question_manager' => \classes\Navigation::QUESTIONMANAGER,
            'element_manager' => \classes\Navigation::COMMENTMANAGER,
            'upload' => \classes\Navigation::UPLOAD,
            'grade_assign' => \classes\Navigation::GRADES,
            'exam_manager' => \classes\Navigation::MANAGER,
            'manager_descrip' => 'Change exam',
            'grade' => \classes\Navigation::INPUT
        );

        $this->new_account_vars = array(
            'login' => \classes\Navigation::LOGIN,
            'register' => \classes\Navigation::REGISTER,
            'lost_password' => \classes\Navigation::LOST_PASS,
            'resend_activation' => \classes\Navigation::RESEND_ACTIVE
        );

        $this->add_variables($this->account_vars);
        $this->add_variables($this->basic_vars);
        $this->add_variables($this->teacher_admin_variables);


    }

    public function get_variables()
    {
        return $this->variables;
    }

    public function render_basic()
    {
        parent::render('navbar.base.twig');
    }

    public function render_teach_admin()
    {
        parent::render('navbar.teach_admin.twig');
    }

    public function grade_decide()
    {
    }
}