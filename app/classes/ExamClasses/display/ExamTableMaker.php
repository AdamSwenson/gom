<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/30/15
 * Time: 5:46 PM
 */

namespace ExamClasses\display;


use Whoops\Handler\Handler;

class ExamTableMaker
{
    public $out = array();

    public $exams;

    public $encoder;

    public function set_encoder(\JsonOutputClasses\encoders\DirectJsonOutput $encoder)
    {
        $this->encoder = $encoder;
    }

    public function build_array(\Exam $exam)
    {
        $examid = $exam->getId();
        ($exam->getLocked() == 1 ? $locked = "checked='checked'" : $locked = '');
        ($exam->getReleased() == 1 ? $released = "checked='checked'" : $released = '');
        $released_cell = <<<H
            <label for='{$examid}released'>Released</label>
            <input type='checkbox' data='{$examid}' class='releasedChecks' id='{$examid}released' name='{$examid}released[]' value='released' {$released} />
H;
        $locked_cell = <<<H
            <label for='{$examid}locked'>Locked</label>
            <input type='checkbox' data='{$examid}' class='lockedChecks' id='{$examid}locked' name='{$examid}locked[]' value='locked' {$locked} />
H;

        return array(
            'examID' => $examid,
            'term' => $exam->getExamterm(),
            'year' => $exam->getExamyear(),
            'topic' => $exam->getExamtopic(),
            'released' => $released_cell,
            'locked' => $locked_cell
        );
    }

    public function load_all_exams()
    {
        $this->exams = \ExamQuery::create()->find();
    }

    public function display_table_data()
    {
        foreach($this->exams as $exam)
        {
            array_push($this->out, $this->build_array($exam));
        }
        if(count($this->out) > 0){
            $this->encoder->encode_and_send($this->out);
        }
    }


//
//
//{
//    //@todo Replace these with symbols/links
//    const COMPLETE = 'Done!';
//    const STARTED = 'Working';
//    const UNSTARTED = 'Unstarted';
//
//    /**
//     * Key is the field in the examStatus table, Value is what the user gets to see
//     * @var array
//     */
//    public $table_fields;
//
//    public function __construct(\UserManagement\IUser $user, $dataservice)
//    {
//        parent::__construct($user, 'all', 'all', $dataservice);
//        $this->table_fields = array('examID' => 'ID', 'term' => 'Term', 'year' => 'Year',
//            'examTopic' => 'Topic', 'locked' => 'Editable', 'released' => 'Visible to students', 'questionsAssigned' => 'Questions and elements setup',
//            'commentsAssigned' => 'Comments setup', 'gradesAssigned' => 'Grades setup', 'studentsAssoc' => 'Students associated',
//            'studentsEmailed' => 'Emails sent to students');
//        $this->returnAssocAll();
//    }
//
//    public function tablemaker($to_update = null)
//    {
//        echo "<table id='masterExamTable'>";
//        $this->header_row_create();
//        foreach ($this->resultAssoc as $row) {
//            $button = self::button_maker("update" . $row['examID'], $row['examID'], 'examID_to_update', 'Edit');
//            if ($to_update != null) {
//                if ($row['examID'] == $to_update) {
//                    $this->edit_row_create($row, $button);
//                } else {
//                    $this->body_row_create($row, $button);
//                }
//            } else {
//                $this->body_row_create($row, $button);
//            }
//        }
//        echo "</table>";
//    }
//
//    /**
//     * This makes a table of all exams with a button for locking or unlocking them
//     */
//    public function lock_tablemaker()
//    {
//        echo "<table id='lockTable'>";
//        $this->header_row_create();
//        foreach ($this->resultAssoc as $row) {
//            if ($row['locked'] == true) {
//                $button = self::button_maker("managelocked" . $row['examID'], $row['examID'], 'examID_to_unlock', 'unlock');
//            } elseif ($row['locked'] == false) {
//                $button = self::button_maker("managelocked" . $row['examID'], $row['examID'], 'examID_to_lock', 'lock');
//            }
//            $this->body_row_create($row, $button);
//        }
//        echo "</table>";
//    }
//    /**
//     * Makes a table with button to clone locked exams
//     */
//    public function clone_tablemaker()
//    {
//        echo "<table id='lockTable'>";
//        $this->header_row_create();
//        foreach ($this->resultAssoc as $row) {
//            if ($row['locked'] == true) {
////                $button = self::button_maker("cloneExam" . $row['examID'], $row['examID'], 'examID_to_clone', 'clone');
//                $button = "<td><input type='button' class='cloneSubmit ' data='". $row['examID'] . "' value='clone' /></td>";
//            } elseif ($row['locked'] == false) {
//                $button = '<td></td>';
//            }
//            $this->body_row_create($row, $button);
//        }
//        echo "</tbody></table>";
//    }
//
//    /**
//     * Makes a table with all rows having editable things
//     * @deprecated since version number
//     */
//    public function edit_tablemaker()
//    {
//        echo "<table id='masterExamTable'>";
//        $this->header_row_create();
//        foreach ($this->resultAssoc as $row) {
//            $this->edit_row_create($row);
//        }
//        echo "</table>";
//    }
//    /**
//     * Uses table_fields to make the header row
//     */
//    protected function header_row_create()
//    {
//        $head = <<<H
//            <thead>
//                <tr>
//H;
//        foreach ($this->table_fields as $k => $v) {
//            $head .= "<th>$v</th>";
//        }
//        //one more for the update buttons
//        $head .= <<<H
//            <th></th>
//            </tr>
//            </thead>
//            <tbody>
//H;
//        echo $head;
//    }
//
//    protected function body_row_create($row, $button)
//    {
//        echo "<tr>";
//        echo "<td>" . $row['examID'] ."</td>";
//        echo "<td>" . $row['term'] . "</td>";
//        echo "<td>" . $row['year'] . "</td>";
//        echo "<td>" . $row['examTopic'] . "</td>";
//        echo "<td>" . self::convert($row['locked'], 'symbol') . "</td>"; //locked
//        echo self::cell_maker(\Navigation::COMMENTRELEASE, self::convert($row['released'], 'symbol'));//released
//        echo self::cell_maker(\Navigation::QUESTIONMANAGER, $this->check_questions_assigned($row['examID']));
//        echo self::cell_maker(\Navigation::COMMENTMANAGER, $this->check_comments_assigned($row['examID'])); //comments
//        echo self::cell_maker(\Navigation::GRADES, $this->check_grades_assigned($row['examID'])); //grades
//        echo self::cell_maker(\Navigation::UPLOAD, $this->check_students_associated($row['examID']));//students loaded
//        echo self::cell_maker(\Navigation::COMMENTRELEASE, $this->check_email_sent($row['examID']));//students emailed
//        echo $button;
//        echo "</tr>";
//    }
//
//    /**
//     * This makes a table row with selects to edit items
//     * @deprecated since version number
//     * @param type $row
//     */
//    protected function edit_row_create($row)
//    {
//        echo "<tr>";
//        echo "<form name='" . $row['examID'] . "' method='post' action='" . htmlspecialchars($_SERVER['PHP_SELF']) . "' role='form'>";
//        echo "<td>" . $row['examID'] ."</td>";
//        echo "<td>" . $row['term'] . "</td>"; //need to do for this. or not. maybe don't want mutable
//        echo "<td>" . $row['year'] . "</td>";
//        echo "<td>" . $row['examTopic'] . "</td>";
//        echo "<td>" . self::convert($row['locked'], 'text') . ' ' . self::select_maker('locked') . "</td>"; //locked
//        echo "<td>" . self::convert($row['released'], 'text') . ' ' . self::select_maker('released'). "</td>"; //released
//        echo self::cell_maker(\Navigation::QUESTIONMANAGER, $this->check_questions_assigned($row['examID']));
////        echo "<td><a href='" . \Navigation::QUESTIONMANAGER . "'>" . $this->check_questions_assigned($row['examID']) . "</a></td>"; //questions
//        echo self::cell_maker(\Navigation::COMMENTMANAGER, $this->check_comments_assigned($row['examID'])); //comments
////                echo "<td><a href='" . \Navigation::COMMENTMANAGER . "'>" . $this->check_comments_assigned($row['examID']) . "</a></td>"; //comments
//        echo self::cell_maker(\Navigation::GRADES, $this->check_grades_assigned($row['examID'])); //grades
//        echo "<td><input type='submit' name='updateExamStatus' value='update' class='prettyButton' /></td>";
//        echo "</form>";
//        echo "</tr>";
//    }
//    /**
//     * This makes a form with a button for update, edit, clone, etc to be placed in the last column of a table so that this can be used in multiple places
//     * @param int    $examid      The examid
//     * @param string $examid_name The name field for the hidden field with the examid as the value
//     * @param string $task        The string to go in the value field of the submit button
//     */
//    protected static function button_maker($formname, $examid, $examid_name, $task)
//    {
//        $loc = \htmlspecialchars($_SERVER['PHP_SELF']);
//        $button = <<<H
//            <td>
//            <form method='post' name='{$formname}' action='{$loc}' role='form'>
//            <input type='hidden' name='{$examid_name}' value='{$examid}'/>
//            <input type='submit' class='submit_{$task} prettyButton' name='task' value='{$task}'/>
//            </form>
//            </td>
//H;
//        return $button;
//    }
//
//    /**
//     * Makes a cell with a link for navigation and a status icon
//     * @param  type   $navlink
//     * @param  type   $displaycontent
//     * @return string HTML string ready for echoing
//     */
//    protected static function cell_maker($navlink, $displaycontent)
//    {
//        return "<td><a href='$navlink'>$displaycontent</a></td>";
//    }
//
//    /**
//     * Makes a select with options true and false
//     * @param  type   $itemname
//     * @return string
//     */
//    protected static function select_maker($itemname)
//    {
//        $select = "<select name='$itemname'>"
//            . "<option>--</option>"
//            . "<option value='open'>True</option>"
//            . "<option value='close'>False</option>"
//            . "</select>";
//
//        return $select;
//    }
//
//    /**
//     * This will check whether have begun assigning questions
//     */
//    public function check_questions_assigned($examID)
//    {
//        return $this->check_status('questionsAssigned', 'questionAssigner', 'questionNumber', $examID);
//    }
//    /**
//     * Check whether have begun assigning comments
//     * @param  type    $examID
//     * @return boolean True if at least one comment assigned
//     */
//    public function check_comments_assigned($examID)
//    {
//        return $this->check_status('commentsAssigned', 'commentAssigner', 'commentID', $examID);
//    }
//    /**
//     * Check whether have begun assigning grades
//     * @param  string  $examID
//     * @return boolean True if at least one grade has a minimum score assigned
//     */
//    protected function check_grades_assigned($examID)
//    {
//        return $this->check_status('gradesAssigned', 'gradeAssigner', 'minScore', $examID);
//    }
//    /**
//     * Checks whether at least one student has been loaded into a class associated with the exam
//     *
//     * @todo This could be improved by doing an outerjoin to see if students are loaded for all classes associated
//     * @param type $examID
//     */
//    protected function check_students_associated($examID)
//    {
////        $this->query = "SELECT sid FROM studentsXclasses sxc INNER JOIN classesXexams cxe ON sxc.classID = cxe.classID WHERE examID = :examID";
//        $field = 'sid';
//        $table = 'studentsXclasses sxc INNER JOIN classesXexams cxe ON sxc.classID = cxe.classID';
//
//        return $this->check_status('studentsAssoc', $table, $field, $examID);
//    }
//
//    protected function check_email_sent($examID)
//    {
//        $complete = $this->check_complete('studentsEmailed', $examID);
//        if ($complete == true) {
////                return self::COMPLETE;
//            return parent::CHECK;
//        } else {
////            return self::UNSTARTED;
//            return parent::CROSS;
//        }
//    }
//
//    /**
//     * This first checks whether the task has been started. If not it doesn't even look at satus table. This is because I'm giving people the option
//     * to mark things complete. It would be bad if they marked something complete without even starting it (perhaps thinking they can skip to seeing the output)
//     * @param  type   $task   The field name from the examStatus table
//     * @param  type   $table  The assigner table name
//     * @param  type   $field  The field to check in the assigner table
//     * @param  type   $examID
//     * @return string
//     */
//    protected function check_status($task, $table, $field, $examID)
//    {
//        $started = $this->check_started($table, $field, $examID);
//        if ($started === true) {
//            //We know they've started it, so now have to check if they say they are done
//            $complete = $this->check_complete($task, $examID);
//            if ($complete === true) {
////                return self::COMPLETE;
//                return parent::CHECK;
//            } else {
//                return parent::PAUSE;
////                return self::STARTED;
//            }
//        } else {
////            return self::UNSTARTED;
//            return parent::CROSS;
//        }
//    }
//
//    /**
//     * Utility function for displaying a symbol, or true or false instead of a boolean
//     * @param type $boolean The boolean to convert
//     * @param string $type Either 'symbol' or 'text'
//     * @return string
//     */
//    protected static function convert($boolean, $type)
//    {
//        if ($boolean == 1) {
//            ($type == 'symbol' ? $new = parent::CHECK : $new = 'True');
//        } elseif ($boolean == 0) {
//            ($type == 'symbol' ? $new = parent::CROSS : $new = 'False');
//        }
//
//        return $new;
//    }
//
//
//<?php
//
//namespace ExaminationClasses\service;
//
//    /**
//     * Gets all exams associated with the user
//     * @todo The hidelocked stuff is old. All new stuff should just run off of the $construction['locked'] in the __construct(). I.e., it shouldn't even load things that are locked.
//     * @author adam
//     */
//class GetAllExams extends ExamService {
//
//    use \Traits\DataAccessTraits;
//
//    const CHECK = "<span class='ui-icon ui-icon-check' style='display: inline-block'></span>";
//    const CROSS = "<span class='ui-icon ui-icon-closethick' style='display: inline-block'></span>";
//    const PAUSE = "<span class='ui-icon ui-icon-pause' style='display: inline-block'></span>";
//
//    /**
//     *
//     * @param \UserManagement\IUser $user
//     * @param array                $constructionArray this will decide the locked status Possible keys: send, printSelector, locked, hideLocked, 'show_released_status'
//     *
//     * @param \UserManagement\IUser $user
//     * @param string               $locked   Possible values 'locked' = show only locked, 'unlocked' =show only unlocked, 'all' = show both locked and unlocked exams
//     * @param string               $released Possible values 'released' = show only released, 'unreleased' = show only unreleased, 'all' = show both released and unreleased exams
//     */
//    public function __construct(\UserManagement\IUser $user, $locked, $released, $dataservice) {
////      $this->dao = $dataservice;
//        parent::__construct($user, $dataservice);
//        $this->locked_controller($locked);
//        $this->released_controller($released);
//        $this->build_query();
//    }
//
//    /**
//     * Since older uses of this class pass in an array with instructions on locked status, this controller
//     * detects when such a request is incoming and decides which query to run
//     */
//    protected function locked_controller($locked) {
//        switch ($locked) {
//            case 'locked':
//                $this->locked_query = "locked = 1";
////                    $this->load_locked_only();
//                break;
//            case 'unlocked':
//                $this->locked_query = "locked = 0";
////                    $this->load_unlocked_only();
//                break;
//            case 'all':
//                $this->locked_query = "1 = 1";
////                    $this->load_all_exams();
//                break;
//            default:
//                throw \Exception('Invalid request for locked status. Must be locked, unlocked, or all');
//                break;
//        }
//    }
//
//    protected function released_controller($released) {
//        switch ($released) {
//            case 'released':
//                $this->released_query = "released = 1";
////                    $this->load_locked_only();
//                break;
//            case 'unreleased':
//                $this->released_query = "released = 0";
////                    $this->load_unlocked_only();
//                break;
//            case 'all':
//                $this->released_query = "1 = 1";
////                    $this->load_all_exams();
//                break;
//            default:
//                throw \Exception('Invalid request for released status. String passed in must be released, unreleased, or all');
//                break;
//        }
//    }
//
//    protected function build_query() {
//        $this->query = "SELECT examID, term, year, examTopic, locked, released "
//            . "FROM exams WHERE $this->locked_query AND $this->released_query ORDER BY year, term DESC";
//    }
//
//    /**
//     * Sends the data as a json
//     */
//    public function send() {
//        $this->sendDataJson();
//    }
//
//    /**
//     * This is used to print options inside a selector which display the exams associated with a user on forms like questionmanager
//     */
//    public function print_selector() {
//        $this->returnAssocAll();
//        foreach ($this->resultAssoc as $ex) {
//            $eid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            $opt = "<option value='$eid' data='$eid'>$year $term $topic</option>";
//            echo $opt;
//        }
//    }
//
//    /**
//     * This creates a string of options for inclusion inside a selector which display the exams associated with a user on forms like questionmanager
//     * This will replace print_selector.
//     */
//    public function return_selector() {
//        $this->returnAssocAll();
//        $out = '';
//        foreach ($this->resultAssoc as $ex) {
//            $eid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            $opt = "<option value='$eid' data='$eid'>$year $term $topic</option>";
//            $out .= $opt;
//        }
//        return $out;
//    }
//
//    /**
//     * This prints a list of exams with a checkbox for whether they are released
//     */
//    public function print_table_released() {
//        $this->returnAssocAll();
//        echo "<table id='releaseList'>";
//        echo "<tr><th>Exam</th><th>Released</th></tr>";
//        foreach ($this->resultAssoc as $ex) {
//            $examid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            ($ex['released'] == 1 ? $released = "checked='checked'" : $released = '');
//            echo "<tr><td>Exam #$examid $term $year $topic  </td><td><input type='checkbox' class='releasedChecks' name='released$examid' value='1' $released></td></tr>";
//        }
//        echo "</table>";
//    }
//
//    /**
//     * This does the same thing as print table, but doesn't do it as contaning form elements.
//     */
//    public function print_static_table_released() {
//        $this->returnAssocAll();
//        echo "<table id='releaseList'>";
//        echo "<tr><th>Exam</th><th>Released</th></tr>";
//        foreach ($this->resultAssoc as $ex) {
//            $examid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            ($ex['released'] == 1 ? $released = self::CHECK : $released = self::CROSS);
//            echo "<tr><td>Exam #$examid $term $year $topic  </td><td>$released</td></tr>";
//        }
//        echo "</table>";
//    }
//
//    /**
//     * Prints a static table (no form fields) with the locked status of the exams
//     */
//    public function print_static_table_locked() {
//        $this->returnAssocAll();
//        echo "<table id='lockedList'>";
//        echo "<tr><th>Exam</th><th>Locked</th></tr>";
//        foreach ($this->resultAssoc as $ex) {
//            $examid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            ($ex['locked'] == 1 ? $locked = self::CHECK : $locked = self::CROSS);
//            echo "<tr><td>Exam #$examid $term $year $topic  </td><td>$locked</td></tr>";
//        }
//        echo "</table>";
//    }
//
//    /**
//     * This prints a table of all exams indicating whether they are released and whether they are  locked
//     */
//    public function print_table_locked_released() {
//        $this->returnAssocAll();
//        echo "<table id='lockedReleaseList'>";
//        echo "<tr><th>Exam</th><th>Locked</th><th>Released</th></tr>";
//        foreach ($this->resultAssoc as $ex) {
//            $examid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            ($ex['locked'] == 1 ? $locked = "checked='checked'" : $locked = '');
//            ($ex['released'] == 1 ? $released = "checked='checked'" : $released = '');
//            echo "<tr>";
//            echo "<td>Exam #$examid $term $year $topic  </td>";
//            echo "<td><input type='checkbox' data='$examid' class='lockedChecks' name='" . $examid . "locked[]' value='locked' $released></td>";
//            echo "<td><input type='checkbox' class='releasedChecks' name='" . $examid . "released[]' value='released' $released></td>";
//            echo "</tr>";
//        }
//        echo "</table>";
//    }
//
//    /**
//     * Prints a static (i.e., no form elements) table of all exams and their locked/released status
//     */
//    public function print_static_table_locked_released() {
//        $this->returnAssocAll();
//        echo "<table id='lockedReleaseList'>";
//        echo "<tr><th>Exam</th><th>Locked</th><th>Visible to students</th></tr>";
//        foreach ($this->resultAssoc as $ex) {
//            $examid = $ex['examID'];
//            $term = $ex['term'];
//            $year = $ex['year'];
//            $topic = $ex['examTopic'];
//            ($ex['locked'] == 1 ? $locked = self::CHECK : $locked = self::CROSS);
//            ($ex['released'] == 1 ? $released = self::CHECK : $released = self::CROSS);
//            echo "<tr>";
//            echo "<td>Exam #$examid $term $year $topic  </td>";
//            echo "<td>$locked</td>";
//            echo "<td>$released</td>";
//            echo "</tr>";
//        }
//        echo "</table>";
//    }
//
//}

}