<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 11/17/15
 * Time: 12:04 PM
 */

namespace App\ViewTools;

/**
 * Centralizes links to help topics for instructions, faq, and
 * video tutorials.
 *
 * Each static property is an array with keys:
 *      id: The html id of the object (without the '#')
 *      text: The text to be used in the link label (usually the one used in navs)
 *
 * @package Viewtools
 */
class HelpLinks
{
//Enclosing sections in instructions page
    static public $instructSectionOverview = ['id' => 'overview'];
    static public $instructSectionSetup = ['id' => 'setup'];
    static public $instructSectionRosterSetup = ['id' => 'rosterSetup'];
    static public $instructSectionElementSetup = ['id' => 'elementSetup'];
    static public $instructSectionExamSetup = ['id' => 'examSetup'];
    static public $instructSectionQuestionSetup = ['id' => 'questionSetup'];

    static public $instructSectionGrade = ['id' => 'grade'];
    static public $instructSectionGradeGrading = ['id' => 'grading'];
    static public $instructSectionGradeAssign = ['id' => 'gradeAssign'];

    static public $instructSectionReport = ['id' => 'setup'];
    static public $instructSectionReportFeedbackRelease = ['id' => 'releaseFeedback'];
    static public $instructSectionReportExport = ['id' => 'exportGrades'];
    static public $instructSectionReportAnalytics = ['id' => 'analytics'];
    static public $instructSectionReportStudentControls = ['id' => 'studentControls'];

//Enclosing sections in faq page
    static public $faqSectionSetup = ['id' => 'faqSetup'];
    static public $faqSectionGrade = ['id' => 'faqGrade'];
    static public $faqSectionReport = ['id' => 'faqReport'];
    static public $faqSectionOther = ['id' => 'faqOther'];

//Enclosing sections in videos page
    static public $videoAllGrade = ['id' => 'gradeVideos', 'text' => 'Videos: Grading'];

    static public $videoAllReport = ['id' => 'reportVideos', 'text' => 'Videos: Reporting'];

    static public $videoAllSetup = ['id' => 'setupVideos', 'text' => 'Videos: Setup'];
    static public $videoAllOther = ['id' => 'otherVideos', 'text' => 'Videos: Other'];


//General: setup
    static public $faqHowSave = ['id' => 'howSave', 'text' => 'Where is the save button'];
    static public $faqSetupGradeOnly = ['id' => 'faqNoFeedback', 'text' => 'Using the gradeomatic without feedback'];

//Exam
    static public $examWhat = ['id' => 'examWhat', 'text' => 'What exams are'];
    static public $examCreate = ['id' => 'examCreate', 'text' => 'Create a new exam'];
    static public $examClone = ['id' => 'examClone', 'text' => 'Make an exam from an existing exam'];
    static public $videoExamSetup = ['id' => 'videoExamSetup', 'text' => 'Videos: Setting up an exam'];


//Overview
    static public $overviewThings = ['id' => 'overviewThings', 'text' => 'Components of an exam'];
    static public $overviewProcess = ['id' => 'overviewProcess', 'text' => 'The overall process'];


//Questions
    static public $questionWhat = ['id' => 'questionWhat', 'text' => 'What questions are'];
    static public $questionCreate = ['id' => 'questionCreateEdit', 'text' => 'Create questions'];
    static public $questionEdit = ['id' => 'questionCreateEdit', 'text' => 'Edit questions'];
    static public $questionMaxPoints = ['id' => 'questionMaxPoints', 'text' => 'Set point value'];
    static public $questionReorder = ['id' => "questionReorder", 'text' => 'Reorder questions'];
    static public $questionSave = ['id' => 'questionSave', 'text' => 'Save questions'];
    static public $questionDelete = ['id' => "questionDelete", 'text' => 'Delete questions'];
    static public $questionAltUses = ['id' => 'questionAltUses', 'text' => 'Alternative uses of questions'];
    static public $questionFeedbackOnly = ['id' => "questionFeedbackOnly", 'text' => 'Giving feedback only'];




//Elements
    static public $elementWhat = ['id' => 'elementWhat', 'text' => 'What elements are'];
    static public $elementCreate = ['id' => 'elementCreateEdit', 'text' => 'Create new elements'];
    static public $elementEdit = ['id' => 'elementCreateEdit', 'text' => 'Edit existing elements'];
    static public $elementAdd = ['id' => 'elementAdd', 'text' => 'Add additional elements'];
    static public $elementSave = ['id' => 'elementSave', 'text' => "Save elements"];
    static public $elementCustomize = ['id' => 'elementCustomize', 'text' => 'Customize feedback'];


//Roster
    static public $rosterWhat = ['id' => 'rosterWhat', 'text' => 'Introduction'];
    static public $rosterPrep = ['id' => 'rosterPrep', 'text' => 'Preparing the file'];
    static public $rosterImport = ['id' => 'rosterImport', 'text' => 'Importing file'];
    static public $rosterManual = ['id' => 'rosterManual', 'text' => 'Manually adding students'];
    static public $rosterDelete = ['id' => 'rosterDelete', 'text' => 'Removing students'];
    static public $rosterSave = ['id' => 'rosterSave', 'text' => 'Saving students'];

    static public $faqRosterCsvWhat = ['id' => 'faqCsvWhat', 'text' => '.csv files? What?'];
    static public $faqRosterErrors = ['id' => 'faqRosterBad', 'text' => 'Roster import errors'];

    static public $videoRosterUpload = ['id' => 'videoRosterUpload', 'text' => 'Video: Upload roster'];


//Grading page
    static public $gradeExamSelect = ['id' => 'gradeExamSelect', 'text' => 'Choose exam to grade'];
    static public $gradeStudentSelect = ['id' => 'gradeSelectStudent', 'text' => 'Choose student to grade'];
    static public $gradeDashboard = ['id' => 'gradeDashboard', 'text' => 'Timers and grading statistics'];
    static public $gradeStart = ['id' => 'gradeStart', 'text' => 'Start grading'];
    static public $gradeSelectQuestion = ['id' => 'gradeSelectQuestion', 'text' => 'Select question to grade'];
    static public $gradeScoreElement = ['id' => 'gradeScoreElement', 'text' => 'Enter element scores'];
    static public $gradeCustomizeFeedback = ['id' => 'gradeScoreElement', 'text' => 'Personalize feedback'];
    static public $gradeScoreQuestion = ['id' => 'gradeScoreQuestion', 'text' => 'Enter question scores'];
    static public $gradeSave = ['id' => 'gradeSave', 'text' => 'Saving scores'];

    static public $faqGradeHideStudents = ['id' => 'faqHideStudents', 'text' => 'Can I grade blind?'];

    static public $videoGrading = ['id' => 'videoGrading', 'text' => 'Video: Grading the exam'];


//Grade assignment page
    static public $assignSetCutoffs = ['id' => 'assignSetCutoffs', 'text' => 'Set cutoffs for letter grades'];
    static public $assignSave = ['id' => 'assignSave', 'text' => 'Save grade assignments'];
    static public $assignVisualize = ['id' => 'assignVisualize', 'text' => 'Visualizing distributions'];


//Feedback controls
    static public $reportRelease = ['id' => 'reportRelease', 'text' => 'Send feedback to students'];
    static public $reportLock = ['id' => 'reportLock', 'text' => 'Hide feedback from students'];


//Analytics
    static public $analyticsOverview = ['id' => 'analyticsOverview', 'text' => 'Overview'];
    static public $analyticsBoxPlots = ['id' => 'analyticsBoxPlots', 'text' => 'Score box plots'];


//Export scores
    static public $exportHow = ['id' => 'exportWhere', 'text' => 'How to export scores'];


//Student controls
    static public $studentControlEmail = [
        'id' => 'studentControlEmail',
        'text' => 'Send feedback to individual student'
    ];
    static public $studentControlReview = ['id' => 'studentControlReview', 'text' => 'Review feedback for a student'];


//Other
    static public $faqOtherSecurity = ['id' => 'faqSecureData', 'text' => 'Student data security'];
    static public $faqOtherPermanentDeletion = ['id' => 'faqPermanentDeletion', 'text' => 'Why is there no way to recover deleted data?'];
    static public $faqOtherCreator = ['id' => 'faqCreator', 'text' => 'Who created this?'];
    static public $faqOtherSupport = ['id' => 'faqSupportGom', 'text' => 'How can I contribute?'];



}