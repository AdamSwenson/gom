<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 6/8/15
 * Time: 9:34 AM
 */

namespace TemplateClasses;


class LeftNav extends NavBar
{

    const TEMPLATE = "navbar.leftnav.twig";

    static public $vars = [
        'index' => \classes\Navigation::HOME,
        'account' => 'account.php',
        'user_settings' => "user_settings.php",
        'preferences' => "preferences.php",
        'logout' => 'logout.php',
        'login' => 'login.php',
        'register' => 'register.php',
        'lost_password' => 'forgot-password.php',
        'resend_activation' => 'resend-activation.php'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->add_variables(self::$vars);

    }

    public function output($loggedIn = false, $emailActivation = false)
    {

        $this->add_variables(array('loggedIn' => $loggedIn, 'emailActivation' => $emailActivation));
//        var_dump($this->variables);
        $this->render(self::TEMPLATE);

    }
}