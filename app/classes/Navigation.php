<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 4/5/15
 * Time: 6:58 PM
 */

namespace classes;


class Navigation
{
#Pages
    const ANALYTICS = 'analytics.php'; //quality control etc
    const ANNOUNCEMENTS = 'announcements.php';
    const BUGS = 'bugs.php';
    const COMMENTMANAGER = 'commentsetup.php'; //'commentedit.php'; //create and edit comments
    const COMMENTASSIGN = 'commentassign.php'; //Assign comments to elements and scores for an exam
    const COMMENTONLY = 'commentOnly.php'; //  alternative input form with just comment selection
    const COMMENTRELEASE = 'commentrelease.php';
    const EXAMSETUP = 'examcreate.php'; //Create exams, classes, and other raw materials
    const EXAMPOPULATE = 'questionsetup.php'; //add questions and elements to exam
    const GRADES = 'gradeassign.php';
    const HISTORY = 'history.php';
    const HOME = 'index.php';
    const INPUT = 'input.php'; //The main grading page
    const INSTRUCTIONS = 'instructions.php';
    const MANAGER = 'examManager.php'; //select exam to grade; set # exams
    const OUTPUT = 'output.php';
    const QUESTIONMANAGER = 'questionsetup.php';
    const UPLOAD = 'studentmanager.php'; //Add students to exam
#New user management system
    const REGISTER = 'register.php';
    const LOGIN = 'login.php';
    const PREFERENCES = 'preferences.php';
    const LOST_PASS = 'forgot-password.php';
    const RESEND_ACTIVE = 'resend-activation.php';

#Error pages
    const SITEDOWN = 'sitedown.html'; //Error page for serious errors
#Includes (common page components)
    const SLOGAN = 'inc/page_includes/slogan.php';
    const CONSTRUCTION = 'inc/page_includes/under_construction.php';

#Student view page parts
    const CHARTS = 'charts.v.4.0.php';

#Input page variables
    const INPUTPAGE_NAME = 'input';

#Javascript files
    #SCRIPT LOADER
    const SCRIPTLOADER = 'inc/page_includes/scriptloader.php';
    #PAGE SCRIPTS
    const OUTPUTSCRIPT = 'inc/js/outputScripts.js';
    const INPUTSCRIPT = 'inc/js/inputScripts.js';
    const CHARTSCRIPT = 'inc/js/chartScripts.js';
    const MANAGERSCRIPT = 'inc/js/managerScripts.js';
    const COMMENTMANAGERSCRIPT = 'inc/js/commentManagerScripts.js';
    #SETUP SCRIPTS
    const SCRIPT_EXAMSETUP = 'inc/js/examSetup.js';
    const SCRIPT_GRADES = 'inc/js/gradeassignmentScripts.js';
    const SCRIPT_QUESTIONSETUP = 'inc/js/questionsetupScripts.js';
    const ELEMENTEDITSCRIPT = 'inc/js/elementEdit.js';
    const COMMENTEDITSCRIPT = 'inc/js/commentEdit.js';
    #UTILITY SCRIPTS
    const ACCORDION_UTIL = 'inc/js/accordion_management.js'; //Callback and setter for accordion tabs
    #PROCESSORS
    const API = 'api'; //This will eventually be the main processor and replace most of the others
    #TEMPLATES
    const SCRIPT_TEMPLATES = 'inc/page_includes/ScriptTemplates.php';

#DASHBOARD
    const DASHHTML = 'inc/page_includes/dashboardHTML.php';

#PAGE PARTS
    const NAVMENU = "inc/page_includes/navmenu.php";

    const JQTEMPLATES = 'inc/page_includes/jqueryTemplates.php';
    const GRADESELECTOR = 'inc/page_includes/gradeSelectMaker.php';

    const BACKUPBUTTON = 'inc/page_includes/backup_button.php';
    const BACKUPPROCESSOR = 'backup.php';
    const TOPBAR = 'inc/page_includes/topbar.php';

#STYLING
    const COMMENTONLYSTYLE = 'inc/css/commentOnlyStyles.css';
    const CONSTRUCTION_STYLE = 'inc/css/underConstructionStyles.css';
    const ELEMENTSETUPSTYLE = 'inc/css/elementEditStyles';
    const FAVICON = "<link href='inc/images/favicon.ico' rel='icon' type='image/x-icon' /> ";
    const INPUTSTYLE = "inc/css/inputStyles.v.3.3.1.css";
    const OUTPUTSTYLE = 'inc/css/outputStyles.css';
    const LEFT_NAV_STYLE = 'inc/css/leftnavStyles.css';
    const NAVSTYLE = "inc/css/navMenuStyles.css";
    const MANAGERSTYLE = 'inc/css/examManagerStyles.css';
    const STANDARD_STYLE = "inc/css/standardStyles.css";
    const STYLE_COMMENTSETUP = 'inc/css/commentsetupStyles.css';
    const STYLE_COMMENTRELEASE = 'inc/css/commentreleaseStyles.css';
    const STYLE_EXAMCREATE = 'inc/css/examCreateStyles.css';
    const STYLE_EXAMSETUP = 'inc/css/examsetupStyles.css';
    const STYLE_INDEX = 'inc/css/indexStyles.css';
    const STYLE_GRADES = 'inc/css/gradeassignerStyles.css';
    const STYLE_QUESTIONSETUP = 'inc/css/questionmanagerStyles.css';
#JQUERY PLUGINS
    const JCOOKIE = 'inc/js/jcookie/';
    const JQPLOT = 'inc/js/jqplot/';

}