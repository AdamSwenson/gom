<?php

namespace Base;

use \Element as ChildElement;
use \ElementQuery as ChildElementQuery;
use \ElementScore as ChildElementScore;
use \ElementScoreQuery as ChildElementScoreQuery;
use \Exam as ChildExam;
use \ExamInfo as ChildExamInfo;
use \ExamInfoQuery as ChildExamInfoQuery;
use \ExamQuery as ChildExamQuery;
use \GradingTime as ChildGradingTime;
use \GradingTimeQuery as ChildGradingTimeQuery;
use \GroupTime as ChildGroupTime;
use \GroupTimeQuery as ChildGroupTimeQuery;
use \Kumi as ChildKumi;
use \KumiQuery as ChildKumiQuery;
use \Question as ChildQuestion;
use \QuestionQuery as ChildQuestionQuery;
use \QuestionScore as ChildQuestionScore;
use \QuestionScoreQuery as ChildQuestionScoreQuery;
use \StockText as ChildStockText;
use \StockTextQuery as ChildStockTextQuery;
use \Student as ChildStudent;
use \StudentQuery as ChildStudentQuery;
use \Term as ChildTerm;
use \TermQuery as ChildTermQuery;
use \Topic as ChildTopic;
use \TopicQuery as ChildTopicQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Year as ChildYear;
use \YearQuery as ChildYearQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'users' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class User implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\UserTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     * @var        int
     */
    protected $id;

    /**
     * The value for the username field.
     * @var        string
     */
    protected $username;

    /**
     * The value for the displayname field.
     * @var        string
     */
    protected $displayname;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the activation_token field.
     * @var        string
     */
    protected $activation_token;

    /**
     * The value for the last_activation_request field.
     * @var        int
     */
    protected $last_activation_request;

    /**
     * The value for the lost_password_request field.
     * @var        int
     */
    protected $lost_password_request;

    /**
     * The value for the active field.
     * @var        int
     */
    protected $active;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the sign_up_stamp field.
     * @var        int
     */
    protected $sign_up_stamp;

    /**
     * The value for the last_sign_in_stamp field.
     * @var        int
     */
    protected $last_sign_in_stamp;

    /**
     * The value for the created_at field.
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        \DateTime
     */
    protected $updated_at;

    /**
     * @var        ObjectCollection|ChildTerm[] Collection to store aggregation of ChildTerm objects.
     */
    protected $collTerms;
    protected $collTermsPartial;

    /**
     * @var        ObjectCollection|ChildTopic[] Collection to store aggregation of ChildTopic objects.
     */
    protected $collTopics;
    protected $collTopicsPartial;

    /**
     * @var        ObjectCollection|ChildYear[] Collection to store aggregation of ChildYear objects.
     */
    protected $collYears;
    protected $collYearsPartial;

    /**
     * @var        ObjectCollection|ChildExam[] Collection to store aggregation of ChildExam objects.
     */
    protected $collExams;
    protected $collExamsPartial;

    /**
     * @var        ObjectCollection|ChildQuestion[] Collection to store aggregation of ChildQuestion objects.
     */
    protected $collQuestions;
    protected $collQuestionsPartial;

    /**
     * @var        ObjectCollection|ChildElement[] Collection to store aggregation of ChildElement objects.
     */
    protected $collElements;
    protected $collElementsPartial;

    /**
     * @var        ObjectCollection|ChildStudent[] Collection to store aggregation of ChildStudent objects.
     */
    protected $collStudents;
    protected $collStudentsPartial;

    /**
     * @var        ObjectCollection|ChildKumi[] Collection to store aggregation of ChildKumi objects.
     */
    protected $collKumis;
    protected $collKumisPartial;

    /**
     * @var        ObjectCollection|ChildStockText[] Collection to store aggregation of ChildStockText objects.
     */
    protected $collStockTexts;
    protected $collStockTextsPartial;

    /**
     * @var        ObjectCollection|ChildQuestionScore[] Collection to store aggregation of ChildQuestionScore objects.
     */
    protected $collQuestionScores;
    protected $collQuestionScoresPartial;

    /**
     * @var        ObjectCollection|ChildElementScore[] Collection to store aggregation of ChildElementScore objects.
     */
    protected $collElementScores;
    protected $collElementScoresPartial;

    /**
     * @var        ObjectCollection|ChildExamInfo[] Collection to store aggregation of ChildExamInfo objects.
     */
    protected $collExamInfos;
    protected $collExamInfosPartial;

    /**
     * @var        ObjectCollection|ChildGradingTime[] Collection to store aggregation of ChildGradingTime objects.
     */
    protected $collGradingTimes;
    protected $collGradingTimesPartial;

    /**
     * @var        ObjectCollection|ChildGroupTime[] Collection to store aggregation of ChildGroupTime objects.
     */
    protected $collGroupTimes;
    protected $collGroupTimesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTerm[]
     */
    protected $termsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTopic[]
     */
    protected $topicsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildYear[]
     */
    protected $yearsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExam[]
     */
    protected $examsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildQuestion[]
     */
    protected $questionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildElement[]
     */
    protected $elementsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStudent[]
     */
    protected $studentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildKumi[]
     */
    protected $kumisScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStockText[]
     */
    protected $stockTextsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildQuestionScore[]
     */
    protected $questionScoresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildElementScore[]
     */
    protected $elementScoresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExamInfo[]
     */
    protected $examInfosScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGradingTime[]
     */
    protected $gradingTimesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildGroupTime[]
     */
    protected $groupTimesScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\User object.
     */
    public function __construct()
    {
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>User</code> instance.  If
     * <code>obj</code> is an instance of <code>User</code>, delegates to
     * <code>equals(User)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|User The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [displayname] column value.
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [activation_token] column value.
     *
     * @return string
     */
    public function getActivationToken()
    {
        return $this->activation_token;
    }

    /**
     * Get the [last_activation_request] column value.
     *
     * @return int
     */
    public function getLastActivationRequest()
    {
        return $this->last_activation_request;
    }

    /**
     * Get the [lost_password_request] column value.
     *
     * @return int
     */
    public function getLostPasswordRequest()
    {
        return $this->lost_password_request;
    }

    /**
     * Get the [active] column value.
     *
     * @return int
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [sign_up_stamp] column value.
     *
     * @return int
     */
    public function getSignUpStamp()
    {
        return $this->sign_up_stamp;
    }

    /**
     * Get the [last_sign_in_stamp] column value.
     *
     * @return int
     */
    public function getLastSignInStamp()
    {
        return $this->last_sign_in_stamp;
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->updated_at;
        } else {
            return $this->updated_at instanceof \DateTime ? $this->updated_at->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UserTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UserTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [displayname] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setDisplayname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->displayname !== $v) {
            $this->displayname = $v;
            $this->modifiedColumns[UserTableMap::COL_DISPLAYNAME] = true;
        }

        return $this;
    } // setDisplayname()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UserTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UserTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [activation_token] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setActivationToken($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->activation_token !== $v) {
            $this->activation_token = $v;
            $this->modifiedColumns[UserTableMap::COL_ACTIVATION_TOKEN] = true;
        }

        return $this;
    } // setActivationToken()

    /**
     * Set the value of [last_activation_request] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setLastActivationRequest($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->last_activation_request !== $v) {
            $this->last_activation_request = $v;
            $this->modifiedColumns[UserTableMap::COL_LAST_ACTIVATION_REQUEST] = true;
        }

        return $this;
    } // setLastActivationRequest()

    /**
     * Set the value of [lost_password_request] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setLostPasswordRequest($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->lost_password_request !== $v) {
            $this->lost_password_request = $v;
            $this->modifiedColumns[UserTableMap::COL_LOST_PASSWORD_REQUEST] = true;
        }

        return $this;
    } // setLostPasswordRequest()

    /**
     * Set the value of [active] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setActive($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->active !== $v) {
            $this->active = $v;
            $this->modifiedColumns[UserTableMap::COL_ACTIVE] = true;
        }

        return $this;
    } // setActive()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[UserTableMap::COL_TITLE] = true;
        }

        return $this;
    } // setTitle()

    /**
     * Set the value of [sign_up_stamp] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setSignUpStamp($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sign_up_stamp !== $v) {
            $this->sign_up_stamp = $v;
            $this->modifiedColumns[UserTableMap::COL_SIGN_UP_STAMP] = true;
        }

        return $this;
    } // setSignUpStamp()

    /**
     * Set the value of [last_sign_in_stamp] column.
     *
     * @param int $v new value
     * @return $this|\User The current object (for fluent API support)
     */
    public function setLastSignInStamp($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->last_sign_in_stamp !== $v) {
            $this->last_sign_in_stamp = $v;
            $this->modifiedColumns[UserTableMap::COL_LAST_SIGN_IN_STAMP] = true;
        }

        return $this;
    } // setLastSignInStamp()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\User The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\User The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UserTableMap::COL_UPDATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UserTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UserTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UserTableMap::translateFieldName('Displayname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->displayname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UserTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UserTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UserTableMap::translateFieldName('ActivationToken', TableMap::TYPE_PHPNAME, $indexType)];
            $this->activation_token = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UserTableMap::translateFieldName('LastActivationRequest', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_activation_request = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UserTableMap::translateFieldName('LostPasswordRequest', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lost_password_request = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UserTableMap::translateFieldName('Active', TableMap::TYPE_PHPNAME, $indexType)];
            $this->active = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UserTableMap::translateFieldName('Title', TableMap::TYPE_PHPNAME, $indexType)];
            $this->title = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UserTableMap::translateFieldName('SignUpStamp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sign_up_stamp = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : UserTableMap::translateFieldName('LastSignInStamp', TableMap::TYPE_PHPNAME, $indexType)];
            $this->last_sign_in_stamp = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : UserTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : UserTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = UserTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\User'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUserQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collTerms = null;

            $this->collTopics = null;

            $this->collYears = null;

            $this->collExams = null;

            $this->collQuestions = null;

            $this->collElements = null;

            $this->collStudents = null;

            $this->collKumis = null;

            $this->collStockTexts = null;

            $this->collQuestionScores = null;

            $this->collElementScores = null;

            $this->collExamInfos = null;

            $this->collGradingTimes = null;

            $this->collGroupTimes = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see User::setDeleted()
     * @see User::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(UserTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                UserTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->termsScheduledForDeletion !== null) {
                if (!$this->termsScheduledForDeletion->isEmpty()) {
                    \TermQuery::create()
                        ->filterByPrimaryKeys($this->termsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->termsScheduledForDeletion = null;
                }
            }

            if ($this->collTerms !== null) {
                foreach ($this->collTerms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->topicsScheduledForDeletion !== null) {
                if (!$this->topicsScheduledForDeletion->isEmpty()) {
                    \TopicQuery::create()
                        ->filterByPrimaryKeys($this->topicsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->topicsScheduledForDeletion = null;
                }
            }

            if ($this->collTopics !== null) {
                foreach ($this->collTopics as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->yearsScheduledForDeletion !== null) {
                if (!$this->yearsScheduledForDeletion->isEmpty()) {
                    \YearQuery::create()
                        ->filterByPrimaryKeys($this->yearsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->yearsScheduledForDeletion = null;
                }
            }

            if ($this->collYears !== null) {
                foreach ($this->collYears as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->examsScheduledForDeletion !== null) {
                if (!$this->examsScheduledForDeletion->isEmpty()) {
                    \ExamQuery::create()
                        ->filterByPrimaryKeys($this->examsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->examsScheduledForDeletion = null;
                }
            }

            if ($this->collExams !== null) {
                foreach ($this->collExams as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->questionsScheduledForDeletion !== null) {
                if (!$this->questionsScheduledForDeletion->isEmpty()) {
                    \QuestionQuery::create()
                        ->filterByPrimaryKeys($this->questionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questionsScheduledForDeletion = null;
                }
            }

            if ($this->collQuestions !== null) {
                foreach ($this->collQuestions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementsScheduledForDeletion !== null) {
                if (!$this->elementsScheduledForDeletion->isEmpty()) {
                    \ElementQuery::create()
                        ->filterByPrimaryKeys($this->elementsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementsScheduledForDeletion = null;
                }
            }

            if ($this->collElements !== null) {
                foreach ($this->collElements as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studentsScheduledForDeletion !== null) {
                if (!$this->studentsScheduledForDeletion->isEmpty()) {
                    \StudentQuery::create()
                        ->filterByPrimaryKeys($this->studentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studentsScheduledForDeletion = null;
                }
            }

            if ($this->collStudents !== null) {
                foreach ($this->collStudents as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->kumisScheduledForDeletion !== null) {
                if (!$this->kumisScheduledForDeletion->isEmpty()) {
                    \KumiQuery::create()
                        ->filterByPrimaryKeys($this->kumisScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->kumisScheduledForDeletion = null;
                }
            }

            if ($this->collKumis !== null) {
                foreach ($this->collKumis as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stockTextsScheduledForDeletion !== null) {
                if (!$this->stockTextsScheduledForDeletion->isEmpty()) {
                    \StockTextQuery::create()
                        ->filterByPrimaryKeys($this->stockTextsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->stockTextsScheduledForDeletion = null;
                }
            }

            if ($this->collStockTexts !== null) {
                foreach ($this->collStockTexts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->questionScoresScheduledForDeletion !== null) {
                if (!$this->questionScoresScheduledForDeletion->isEmpty()) {
                    \QuestionScoreQuery::create()
                        ->filterByPrimaryKeys($this->questionScoresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->questionScoresScheduledForDeletion = null;
                }
            }

            if ($this->collQuestionScores !== null) {
                foreach ($this->collQuestionScores as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementScoresScheduledForDeletion !== null) {
                if (!$this->elementScoresScheduledForDeletion->isEmpty()) {
                    \ElementScoreQuery::create()
                        ->filterByPrimaryKeys($this->elementScoresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementScoresScheduledForDeletion = null;
                }
            }

            if ($this->collElementScores !== null) {
                foreach ($this->collElementScores as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->examInfosScheduledForDeletion !== null) {
                if (!$this->examInfosScheduledForDeletion->isEmpty()) {
                    \ExamInfoQuery::create()
                        ->filterByPrimaryKeys($this->examInfosScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->examInfosScheduledForDeletion = null;
                }
            }

            if ($this->collExamInfos !== null) {
                foreach ($this->collExamInfos as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->gradingTimesScheduledForDeletion !== null) {
                if (!$this->gradingTimesScheduledForDeletion->isEmpty()) {
                    \GradingTimeQuery::create()
                        ->filterByPrimaryKeys($this->gradingTimesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->gradingTimesScheduledForDeletion = null;
                }
            }

            if ($this->collGradingTimes !== null) {
                foreach ($this->collGradingTimes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->groupTimesScheduledForDeletion !== null) {
                if (!$this->groupTimesScheduledForDeletion->isEmpty()) {
                    \GroupTimeQuery::create()
                        ->filterByPrimaryKeys($this->groupTimesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->groupTimesScheduledForDeletion = null;
                }
            }

            if ($this->collGroupTimes !== null) {
                foreach ($this->collGroupTimes as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[UserTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UserTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UserTableMap::COL_DISPLAYNAME)) {
            $modifiedColumns[':p' . $index++]  = 'displayname';
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UserTableMap::COL_ACTIVATION_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = 'activation_token';
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_ACTIVATION_REQUEST)) {
            $modifiedColumns[':p' . $index++]  = 'last_activation_request';
        }
        if ($this->isColumnModified(UserTableMap::COL_LOST_PASSWORD_REQUEST)) {
            $modifiedColumns[':p' . $index++]  = 'lost_password_request';
        }
        if ($this->isColumnModified(UserTableMap::COL_ACTIVE)) {
            $modifiedColumns[':p' . $index++]  = 'active';
        }
        if ($this->isColumnModified(UserTableMap::COL_TITLE)) {
            $modifiedColumns[':p' . $index++]  = 'title';
        }
        if ($this->isColumnModified(UserTableMap::COL_SIGN_UP_STAMP)) {
            $modifiedColumns[':p' . $index++]  = 'sign_up_stamp';
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_SIGN_IN_STAMP)) {
            $modifiedColumns[':p' . $index++]  = 'last_sign_in_stamp';
        }
        if ($this->isColumnModified(UserTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'displayname':
                        $stmt->bindValue($identifier, $this->displayname, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'activation_token':
                        $stmt->bindValue($identifier, $this->activation_token, PDO::PARAM_STR);
                        break;
                    case 'last_activation_request':
                        $stmt->bindValue($identifier, $this->last_activation_request, PDO::PARAM_INT);
                        break;
                    case 'lost_password_request':
                        $stmt->bindValue($identifier, $this->lost_password_request, PDO::PARAM_INT);
                        break;
                    case 'active':
                        $stmt->bindValue($identifier, $this->active, PDO::PARAM_INT);
                        break;
                    case 'title':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case 'sign_up_stamp':
                        $stmt->bindValue($identifier, $this->sign_up_stamp, PDO::PARAM_INT);
                        break;
                    case 'last_sign_in_stamp':
                        $stmt->bindValue($identifier, $this->last_sign_in_stamp, PDO::PARAM_INT);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'updated_at':
                        $stmt->bindValue($identifier, $this->updated_at ? $this->updated_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getUsername();
                break;
            case 2:
                return $this->getDisplayname();
                break;
            case 3:
                return $this->getPassword();
                break;
            case 4:
                return $this->getEmail();
                break;
            case 5:
                return $this->getActivationToken();
                break;
            case 6:
                return $this->getLastActivationRequest();
                break;
            case 7:
                return $this->getLostPasswordRequest();
                break;
            case 8:
                return $this->getActive();
                break;
            case 9:
                return $this->getTitle();
                break;
            case 10:
                return $this->getSignUpStamp();
                break;
            case 11:
                return $this->getLastSignInStamp();
                break;
            case 12:
                return $this->getCreatedAt();
                break;
            case 13:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['User'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['User'][$this->hashCode()] = true;
        $keys = UserTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getDisplayname(),
            $keys[3] => $this->getPassword(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getActivationToken(),
            $keys[6] => $this->getLastActivationRequest(),
            $keys[7] => $this->getLostPasswordRequest(),
            $keys[8] => $this->getActive(),
            $keys[9] => $this->getTitle(),
            $keys[10] => $this->getSignUpStamp(),
            $keys[11] => $this->getLastSignInStamp(),
            $keys[12] => $this->getCreatedAt(),
            $keys[13] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[12]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[12]];
            $result[$keys[12]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[13]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[13]];
            $result[$keys[13]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collTerms) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'terms';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'r_termss';
                        break;
                    default:
                        $key = 'Terms';
                }

                $result[$key] = $this->collTerms->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTopics) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'topics';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'r_examTopicss';
                        break;
                    default:
                        $key = 'Topics';
                }

                $result[$key] = $this->collTopics->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collYears) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'years';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'r_yearss';
                        break;
                    default:
                        $key = 'Years';
                }

                $result[$key] = $this->collYears->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExams) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'exams';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'examss';
                        break;
                    default:
                        $key = 'Exams';
                }

                $result[$key] = $this->collExams->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuestions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'questions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'questionss';
                        break;
                    default:
                        $key = 'Questions';
                }

                $result[$key] = $this->collQuestions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElements) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'elements';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'elementss';
                        break;
                    default:
                        $key = 'Elements';
                }

                $result[$key] = $this->collElements->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudents) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'students';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'studentss';
                        break;
                    default:
                        $key = 'Students';
                }

                $result[$key] = $this->collStudents->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collKumis) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'kumis';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'classess';
                        break;
                    default:
                        $key = 'Kumis';
                }

                $result[$key] = $this->collKumis->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStockTexts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'stockTexts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'stockTextss';
                        break;
                    default:
                        $key = 'StockTexts';
                }

                $result[$key] = $this->collStockTexts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuestionScores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'questionScores';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'questionScoress';
                        break;
                    default:
                        $key = 'QuestionScores';
                }

                $result[$key] = $this->collQuestionScores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElementScores) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'elementScores';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'elementScoress';
                        break;
                    default:
                        $key = 'ElementScores';
                }

                $result[$key] = $this->collElementScores->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExamInfos) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'examInfos';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'examInfos';
                        break;
                    default:
                        $key = 'ExamInfos';
                }

                $result[$key] = $this->collExamInfos->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGradingTimes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'gradingTimes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'time_gradings';
                        break;
                    default:
                        $key = 'GradingTimes';
                }

                $result[$key] = $this->collGradingTimes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collGroupTimes) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'groupTimes';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'time_groups';
                        break;
                    default:
                        $key = 'GroupTimes';
                }

                $result[$key] = $this->collGroupTimes->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\User
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UserTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\User
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setDisplayname($value);
                break;
            case 3:
                $this->setPassword($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setActivationToken($value);
                break;
            case 6:
                $this->setLastActivationRequest($value);
                break;
            case 7:
                $this->setLostPasswordRequest($value);
                break;
            case 8:
                $this->setActive($value);
                break;
            case 9:
                $this->setTitle($value);
                break;
            case 10:
                $this->setSignUpStamp($value);
                break;
            case 11:
                $this->setLastSignInStamp($value);
                break;
            case 12:
                $this->setCreatedAt($value);
                break;
            case 13:
                $this->setUpdatedAt($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = UserTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDisplayname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPassword($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEmail($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setActivationToken($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setLastActivationRequest($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setLostPasswordRequest($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setActive($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setTitle($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setSignUpStamp($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setLastSignInStamp($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCreatedAt($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setUpdatedAt($arr[$keys[13]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\User The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(UserTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UserTableMap::COL_ID)) {
            $criteria->add(UserTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UserTableMap::COL_USERNAME)) {
            $criteria->add(UserTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UserTableMap::COL_DISPLAYNAME)) {
            $criteria->add(UserTableMap::COL_DISPLAYNAME, $this->displayname);
        }
        if ($this->isColumnModified(UserTableMap::COL_PASSWORD)) {
            $criteria->add(UserTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UserTableMap::COL_EMAIL)) {
            $criteria->add(UserTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UserTableMap::COL_ACTIVATION_TOKEN)) {
            $criteria->add(UserTableMap::COL_ACTIVATION_TOKEN, $this->activation_token);
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_ACTIVATION_REQUEST)) {
            $criteria->add(UserTableMap::COL_LAST_ACTIVATION_REQUEST, $this->last_activation_request);
        }
        if ($this->isColumnModified(UserTableMap::COL_LOST_PASSWORD_REQUEST)) {
            $criteria->add(UserTableMap::COL_LOST_PASSWORD_REQUEST, $this->lost_password_request);
        }
        if ($this->isColumnModified(UserTableMap::COL_ACTIVE)) {
            $criteria->add(UserTableMap::COL_ACTIVE, $this->active);
        }
        if ($this->isColumnModified(UserTableMap::COL_TITLE)) {
            $criteria->add(UserTableMap::COL_TITLE, $this->title);
        }
        if ($this->isColumnModified(UserTableMap::COL_SIGN_UP_STAMP)) {
            $criteria->add(UserTableMap::COL_SIGN_UP_STAMP, $this->sign_up_stamp);
        }
        if ($this->isColumnModified(UserTableMap::COL_LAST_SIGN_IN_STAMP)) {
            $criteria->add(UserTableMap::COL_LAST_SIGN_IN_STAMP, $this->last_sign_in_stamp);
        }
        if ($this->isColumnModified(UserTableMap::COL_CREATED_AT)) {
            $criteria->add(UserTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(UserTableMap::COL_UPDATED_AT)) {
            $criteria->add(UserTableMap::COL_UPDATED_AT, $this->updated_at);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildUserQuery::create();
        $criteria->add(UserTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \User (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setDisplayname($this->getDisplayname());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setActivationToken($this->getActivationToken());
        $copyObj->setLastActivationRequest($this->getLastActivationRequest());
        $copyObj->setLostPasswordRequest($this->getLostPasswordRequest());
        $copyObj->setActive($this->getActive());
        $copyObj->setTitle($this->getTitle());
        $copyObj->setSignUpStamp($this->getSignUpStamp());
        $copyObj->setLastSignInStamp($this->getLastSignInStamp());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTerms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTerm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTopics() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTopic($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getYears() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addYear($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExam($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuestions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuestion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElement($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudents() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudent($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getKumis() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addKumi($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStockTexts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockText($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuestionScores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuestionScore($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElementScores() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementScore($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExamInfos() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExamInfo($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGradingTimes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGradingTime($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getGroupTimes() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addGroupTime($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \User Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Term' == $relationName) {
            return $this->initTerms();
        }
        if ('Topic' == $relationName) {
            return $this->initTopics();
        }
        if ('Year' == $relationName) {
            return $this->initYears();
        }
        if ('Exam' == $relationName) {
            return $this->initExams();
        }
        if ('Question' == $relationName) {
            return $this->initQuestions();
        }
        if ('Element' == $relationName) {
            return $this->initElements();
        }
        if ('Student' == $relationName) {
            return $this->initStudents();
        }
        if ('Kumi' == $relationName) {
            return $this->initKumis();
        }
        if ('StockText' == $relationName) {
            return $this->initStockTexts();
        }
        if ('QuestionScore' == $relationName) {
            return $this->initQuestionScores();
        }
        if ('ElementScore' == $relationName) {
            return $this->initElementScores();
        }
        if ('ExamInfo' == $relationName) {
            return $this->initExamInfos();
        }
        if ('GradingTime' == $relationName) {
            return $this->initGradingTimes();
        }
        if ('GroupTime' == $relationName) {
            return $this->initGroupTimes();
        }
    }

    /**
     * Clears out the collTerms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTerms()
     */
    public function clearTerms()
    {
        $this->collTerms = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTerms collection loaded partially.
     */
    public function resetPartialTerms($v = true)
    {
        $this->collTermsPartial = $v;
    }

    /**
     * Initializes the collTerms collection.
     *
     * By default this just sets the collTerms collection to an empty array (like clearcollTerms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTerms($overrideExisting = true)
    {
        if (null !== $this->collTerms && !$overrideExisting) {
            return;
        }
        $this->collTerms = new ObjectCollection();
        $this->collTerms->setModel('\Term');
    }

    /**
     * Gets an array of ChildTerm objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTerm[] List of ChildTerm objects
     * @throws PropelException
     */
    public function getTerms(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTermsPartial && !$this->isNew();
        if (null === $this->collTerms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTerms) {
                // return empty collection
                $this->initTerms();
            } else {
                $collTerms = ChildTermQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTermsPartial && count($collTerms)) {
                        $this->initTerms(false);

                        foreach ($collTerms as $obj) {
                            if (false == $this->collTerms->contains($obj)) {
                                $this->collTerms->append($obj);
                            }
                        }

                        $this->collTermsPartial = true;
                    }

                    return $collTerms;
                }

                if ($partial && $this->collTerms) {
                    foreach ($this->collTerms as $obj) {
                        if ($obj->isNew()) {
                            $collTerms[] = $obj;
                        }
                    }
                }

                $this->collTerms = $collTerms;
                $this->collTermsPartial = false;
            }
        }

        return $this->collTerms;
    }

    /**
     * Sets a collection of ChildTerm objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $terms A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTerms(Collection $terms, ConnectionInterface $con = null)
    {
        /** @var ChildTerm[] $termsToDelete */
        $termsToDelete = $this->getTerms(new Criteria(), $con)->diff($terms);


        $this->termsScheduledForDeletion = $termsToDelete;

        foreach ($termsToDelete as $termRemoved) {
            $termRemoved->setUser(null);
        }

        $this->collTerms = null;
        foreach ($terms as $term) {
            $this->addTerm($term);
        }

        $this->collTerms = $terms;
        $this->collTermsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Term objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Term objects.
     * @throws PropelException
     */
    public function countTerms(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTermsPartial && !$this->isNew();
        if (null === $this->collTerms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTerms) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTerms());
            }

            $query = ChildTermQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collTerms);
    }

    /**
     * Method called to associate a ChildTerm object to this object
     * through the ChildTerm foreign key attribute.
     *
     * @param  ChildTerm $l ChildTerm
     * @return $this|\User The current object (for fluent API support)
     */
    public function addTerm(ChildTerm $l)
    {
        if ($this->collTerms === null) {
            $this->initTerms();
            $this->collTermsPartial = true;
        }

        if (!$this->collTerms->contains($l)) {
            $this->doAddTerm($l);
        }

        return $this;
    }

    /**
     * @param ChildTerm $term The ChildTerm object to add.
     */
    protected function doAddTerm(ChildTerm $term)
    {
        $this->collTerms[]= $term;
        $term->setUser($this);
    }

    /**
     * @param  ChildTerm $term The ChildTerm object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTerm(ChildTerm $term)
    {
        if ($this->getTerms()->contains($term)) {
            $pos = $this->collTerms->search($term);
            $this->collTerms->remove($pos);
            if (null === $this->termsScheduledForDeletion) {
                $this->termsScheduledForDeletion = clone $this->collTerms;
                $this->termsScheduledForDeletion->clear();
            }
            $this->termsScheduledForDeletion[]= clone $term;
            $term->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collTopics collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTopics()
     */
    public function clearTopics()
    {
        $this->collTopics = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTopics collection loaded partially.
     */
    public function resetPartialTopics($v = true)
    {
        $this->collTopicsPartial = $v;
    }

    /**
     * Initializes the collTopics collection.
     *
     * By default this just sets the collTopics collection to an empty array (like clearcollTopics());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTopics($overrideExisting = true)
    {
        if (null !== $this->collTopics && !$overrideExisting) {
            return;
        }
        $this->collTopics = new ObjectCollection();
        $this->collTopics->setModel('\Topic');
    }

    /**
     * Gets an array of ChildTopic objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTopic[] List of ChildTopic objects
     * @throws PropelException
     */
    public function getTopics(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTopicsPartial && !$this->isNew();
        if (null === $this->collTopics || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTopics) {
                // return empty collection
                $this->initTopics();
            } else {
                $collTopics = ChildTopicQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTopicsPartial && count($collTopics)) {
                        $this->initTopics(false);

                        foreach ($collTopics as $obj) {
                            if (false == $this->collTopics->contains($obj)) {
                                $this->collTopics->append($obj);
                            }
                        }

                        $this->collTopicsPartial = true;
                    }

                    return $collTopics;
                }

                if ($partial && $this->collTopics) {
                    foreach ($this->collTopics as $obj) {
                        if ($obj->isNew()) {
                            $collTopics[] = $obj;
                        }
                    }
                }

                $this->collTopics = $collTopics;
                $this->collTopicsPartial = false;
            }
        }

        return $this->collTopics;
    }

    /**
     * Sets a collection of ChildTopic objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $topics A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setTopics(Collection $topics, ConnectionInterface $con = null)
    {
        /** @var ChildTopic[] $topicsToDelete */
        $topicsToDelete = $this->getTopics(new Criteria(), $con)->diff($topics);


        $this->topicsScheduledForDeletion = $topicsToDelete;

        foreach ($topicsToDelete as $topicRemoved) {
            $topicRemoved->setUser(null);
        }

        $this->collTopics = null;
        foreach ($topics as $topic) {
            $this->addTopic($topic);
        }

        $this->collTopics = $topics;
        $this->collTopicsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Topic objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Topic objects.
     * @throws PropelException
     */
    public function countTopics(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTopicsPartial && !$this->isNew();
        if (null === $this->collTopics || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTopics) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTopics());
            }

            $query = ChildTopicQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collTopics);
    }

    /**
     * Method called to associate a ChildTopic object to this object
     * through the ChildTopic foreign key attribute.
     *
     * @param  ChildTopic $l ChildTopic
     * @return $this|\User The current object (for fluent API support)
     */
    public function addTopic(ChildTopic $l)
    {
        if ($this->collTopics === null) {
            $this->initTopics();
            $this->collTopicsPartial = true;
        }

        if (!$this->collTopics->contains($l)) {
            $this->doAddTopic($l);
        }

        return $this;
    }

    /**
     * @param ChildTopic $topic The ChildTopic object to add.
     */
    protected function doAddTopic(ChildTopic $topic)
    {
        $this->collTopics[]= $topic;
        $topic->setUser($this);
    }

    /**
     * @param  ChildTopic $topic The ChildTopic object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeTopic(ChildTopic $topic)
    {
        if ($this->getTopics()->contains($topic)) {
            $pos = $this->collTopics->search($topic);
            $this->collTopics->remove($pos);
            if (null === $this->topicsScheduledForDeletion) {
                $this->topicsScheduledForDeletion = clone $this->collTopics;
                $this->topicsScheduledForDeletion->clear();
            }
            $this->topicsScheduledForDeletion[]= clone $topic;
            $topic->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collYears collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addYears()
     */
    public function clearYears()
    {
        $this->collYears = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collYears collection loaded partially.
     */
    public function resetPartialYears($v = true)
    {
        $this->collYearsPartial = $v;
    }

    /**
     * Initializes the collYears collection.
     *
     * By default this just sets the collYears collection to an empty array (like clearcollYears());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initYears($overrideExisting = true)
    {
        if (null !== $this->collYears && !$overrideExisting) {
            return;
        }
        $this->collYears = new ObjectCollection();
        $this->collYears->setModel('\Year');
    }

    /**
     * Gets an array of ChildYear objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildYear[] List of ChildYear objects
     * @throws PropelException
     */
    public function getYears(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collYearsPartial && !$this->isNew();
        if (null === $this->collYears || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collYears) {
                // return empty collection
                $this->initYears();
            } else {
                $collYears = ChildYearQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collYearsPartial && count($collYears)) {
                        $this->initYears(false);

                        foreach ($collYears as $obj) {
                            if (false == $this->collYears->contains($obj)) {
                                $this->collYears->append($obj);
                            }
                        }

                        $this->collYearsPartial = true;
                    }

                    return $collYears;
                }

                if ($partial && $this->collYears) {
                    foreach ($this->collYears as $obj) {
                        if ($obj->isNew()) {
                            $collYears[] = $obj;
                        }
                    }
                }

                $this->collYears = $collYears;
                $this->collYearsPartial = false;
            }
        }

        return $this->collYears;
    }

    /**
     * Sets a collection of ChildYear objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $years A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setYears(Collection $years, ConnectionInterface $con = null)
    {
        /** @var ChildYear[] $yearsToDelete */
        $yearsToDelete = $this->getYears(new Criteria(), $con)->diff($years);


        $this->yearsScheduledForDeletion = $yearsToDelete;

        foreach ($yearsToDelete as $yearRemoved) {
            $yearRemoved->setUser(null);
        }

        $this->collYears = null;
        foreach ($years as $year) {
            $this->addYear($year);
        }

        $this->collYears = $years;
        $this->collYearsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Year objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Year objects.
     * @throws PropelException
     */
    public function countYears(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collYearsPartial && !$this->isNew();
        if (null === $this->collYears || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collYears) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getYears());
            }

            $query = ChildYearQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collYears);
    }

    /**
     * Method called to associate a ChildYear object to this object
     * through the ChildYear foreign key attribute.
     *
     * @param  ChildYear $l ChildYear
     * @return $this|\User The current object (for fluent API support)
     */
    public function addYear(ChildYear $l)
    {
        if ($this->collYears === null) {
            $this->initYears();
            $this->collYearsPartial = true;
        }

        if (!$this->collYears->contains($l)) {
            $this->doAddYear($l);
        }

        return $this;
    }

    /**
     * @param ChildYear $year The ChildYear object to add.
     */
    protected function doAddYear(ChildYear $year)
    {
        $this->collYears[]= $year;
        $year->setUser($this);
    }

    /**
     * @param  ChildYear $year The ChildYear object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeYear(ChildYear $year)
    {
        if ($this->getYears()->contains($year)) {
            $pos = $this->collYears->search($year);
            $this->collYears->remove($pos);
            if (null === $this->yearsScheduledForDeletion) {
                $this->yearsScheduledForDeletion = clone $this->collYears;
                $this->yearsScheduledForDeletion->clear();
            }
            $this->yearsScheduledForDeletion[]= clone $year;
            $year->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collExams collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExams()
     */
    public function clearExams()
    {
        $this->collExams = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExams collection loaded partially.
     */
    public function resetPartialExams($v = true)
    {
        $this->collExamsPartial = $v;
    }

    /**
     * Initializes the collExams collection.
     *
     * By default this just sets the collExams collection to an empty array (like clearcollExams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExams($overrideExisting = true)
    {
        if (null !== $this->collExams && !$overrideExisting) {
            return;
        }
        $this->collExams = new ObjectCollection();
        $this->collExams->setModel('\Exam');
    }

    /**
     * Gets an array of ChildExam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExam[] List of ChildExam objects
     * @throws PropelException
     */
    public function getExams(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExamsPartial && !$this->isNew();
        if (null === $this->collExams || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExams) {
                // return empty collection
                $this->initExams();
            } else {
                $collExams = ChildExamQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExamsPartial && count($collExams)) {
                        $this->initExams(false);

                        foreach ($collExams as $obj) {
                            if (false == $this->collExams->contains($obj)) {
                                $this->collExams->append($obj);
                            }
                        }

                        $this->collExamsPartial = true;
                    }

                    return $collExams;
                }

                if ($partial && $this->collExams) {
                    foreach ($this->collExams as $obj) {
                        if ($obj->isNew()) {
                            $collExams[] = $obj;
                        }
                    }
                }

                $this->collExams = $collExams;
                $this->collExamsPartial = false;
            }
        }

        return $this->collExams;
    }

    /**
     * Sets a collection of ChildExam objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $exams A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setExams(Collection $exams, ConnectionInterface $con = null)
    {
        /** @var ChildExam[] $examsToDelete */
        $examsToDelete = $this->getExams(new Criteria(), $con)->diff($exams);


        $this->examsScheduledForDeletion = $examsToDelete;

        foreach ($examsToDelete as $examRemoved) {
            $examRemoved->setUser(null);
        }

        $this->collExams = null;
        foreach ($exams as $exam) {
            $this->addExam($exam);
        }

        $this->collExams = $exams;
        $this->collExamsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Exam objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Exam objects.
     * @throws PropelException
     */
    public function countExams(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExamsPartial && !$this->isNew();
        if (null === $this->collExams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExams) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExams());
            }

            $query = ChildExamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collExams);
    }

    /**
     * Method called to associate a ChildExam object to this object
     * through the ChildExam foreign key attribute.
     *
     * @param  ChildExam $l ChildExam
     * @return $this|\User The current object (for fluent API support)
     */
    public function addExam(ChildExam $l)
    {
        if ($this->collExams === null) {
            $this->initExams();
            $this->collExamsPartial = true;
        }

        if (!$this->collExams->contains($l)) {
            $this->doAddExam($l);
        }

        return $this;
    }

    /**
     * @param ChildExam $exam The ChildExam object to add.
     */
    protected function doAddExam(ChildExam $exam)
    {
        $this->collExams[]= $exam;
        $exam->setUser($this);
    }

    /**
     * @param  ChildExam $exam The ChildExam object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeExam(ChildExam $exam)
    {
        if ($this->getExams()->contains($exam)) {
            $pos = $this->collExams->search($exam);
            $this->collExams->remove($pos);
            if (null === $this->examsScheduledForDeletion) {
                $this->examsScheduledForDeletion = clone $this->collExams;
                $this->examsScheduledForDeletion->clear();
            }
            $this->examsScheduledForDeletion[]= clone $exam;
            $exam->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Exams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExam[] List of ChildExam objects
     */
    public function getExamsJoinTerm(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamQuery::create(null, $criteria);
        $query->joinWith('Term', $joinBehavior);

        return $this->getExams($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Exams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExam[] List of ChildExam objects
     */
    public function getExamsJoinTopic(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamQuery::create(null, $criteria);
        $query->joinWith('Topic', $joinBehavior);

        return $this->getExams($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related Exams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExam[] List of ChildExam objects
     */
    public function getExamsJoinYear(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamQuery::create(null, $criteria);
        $query->joinWith('Year', $joinBehavior);

        return $this->getExams($query, $con);
    }

    /**
     * Clears out the collQuestions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestions()
     */
    public function clearQuestions()
    {
        $this->collQuestions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuestions collection loaded partially.
     */
    public function resetPartialQuestions($v = true)
    {
        $this->collQuestionsPartial = $v;
    }

    /**
     * Initializes the collQuestions collection.
     *
     * By default this just sets the collQuestions collection to an empty array (like clearcollQuestions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestions($overrideExisting = true)
    {
        if (null !== $this->collQuestions && !$overrideExisting) {
            return;
        }
        $this->collQuestions = new ObjectCollection();
        $this->collQuestions->setModel('\Question');
    }

    /**
     * Gets an array of ChildQuestion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestion[] List of ChildQuestion objects
     * @throws PropelException
     */
    public function getQuestions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                // return empty collection
                $this->initQuestions();
            } else {
                $collQuestions = ChildQuestionQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestionsPartial && count($collQuestions)) {
                        $this->initQuestions(false);

                        foreach ($collQuestions as $obj) {
                            if (false == $this->collQuestions->contains($obj)) {
                                $this->collQuestions->append($obj);
                            }
                        }

                        $this->collQuestionsPartial = true;
                    }

                    return $collQuestions;
                }

                if ($partial && $this->collQuestions) {
                    foreach ($this->collQuestions as $obj) {
                        if ($obj->isNew()) {
                            $collQuestions[] = $obj;
                        }
                    }
                }

                $this->collQuestions = $collQuestions;
                $this->collQuestionsPartial = false;
            }
        }

        return $this->collQuestions;
    }

    /**
     * Sets a collection of ChildQuestion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setQuestions(Collection $questions, ConnectionInterface $con = null)
    {
        /** @var ChildQuestion[] $questionsToDelete */
        $questionsToDelete = $this->getQuestions(new Criteria(), $con)->diff($questions);


        $this->questionsScheduledForDeletion = $questionsToDelete;

        foreach ($questionsToDelete as $questionRemoved) {
            $questionRemoved->setUser(null);
        }

        $this->collQuestions = null;
        foreach ($questions as $question) {
            $this->addQuestion($question);
        }

        $this->collQuestions = $questions;
        $this->collQuestionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Question objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Question objects.
     * @throws PropelException
     */
    public function countQuestions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuestions());
            }

            $query = ChildQuestionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collQuestions);
    }

    /**
     * Method called to associate a ChildQuestion object to this object
     * through the ChildQuestion foreign key attribute.
     *
     * @param  ChildQuestion $l ChildQuestion
     * @return $this|\User The current object (for fluent API support)
     */
    public function addQuestion(ChildQuestion $l)
    {
        if ($this->collQuestions === null) {
            $this->initQuestions();
            $this->collQuestionsPartial = true;
        }

        if (!$this->collQuestions->contains($l)) {
            $this->doAddQuestion($l);
        }

        return $this;
    }

    /**
     * @param ChildQuestion $question The ChildQuestion object to add.
     */
    protected function doAddQuestion(ChildQuestion $question)
    {
        $this->collQuestions[]= $question;
        $question->setUser($this);
    }

    /**
     * @param  ChildQuestion $question The ChildQuestion object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeQuestion(ChildQuestion $question)
    {
        if ($this->getQuestions()->contains($question)) {
            $pos = $this->collQuestions->search($question);
            $this->collQuestions->remove($pos);
            if (null === $this->questionsScheduledForDeletion) {
                $this->questionsScheduledForDeletion = clone $this->collQuestions;
                $this->questionsScheduledForDeletion->clear();
            }
            $this->questionsScheduledForDeletion[]= clone $question;
            $question->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collElements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addElements()
     */
    public function clearElements()
    {
        $this->collElements = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collElements collection loaded partially.
     */
    public function resetPartialElements($v = true)
    {
        $this->collElementsPartial = $v;
    }

    /**
     * Initializes the collElements collection.
     *
     * By default this just sets the collElements collection to an empty array (like clearcollElements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElements($overrideExisting = true)
    {
        if (null !== $this->collElements && !$overrideExisting) {
            return;
        }
        $this->collElements = new ObjectCollection();
        $this->collElements->setModel('\Element');
    }

    /**
     * Gets an array of ChildElement objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildElement[] List of ChildElement objects
     * @throws PropelException
     */
    public function getElements(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                // return empty collection
                $this->initElements();
            } else {
                $collElements = ChildElementQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collElementsPartial && count($collElements)) {
                        $this->initElements(false);

                        foreach ($collElements as $obj) {
                            if (false == $this->collElements->contains($obj)) {
                                $this->collElements->append($obj);
                            }
                        }

                        $this->collElementsPartial = true;
                    }

                    return $collElements;
                }

                if ($partial && $this->collElements) {
                    foreach ($this->collElements as $obj) {
                        if ($obj->isNew()) {
                            $collElements[] = $obj;
                        }
                    }
                }

                $this->collElements = $collElements;
                $this->collElementsPartial = false;
            }
        }

        return $this->collElements;
    }

    /**
     * Sets a collection of ChildElement objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $elements A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setElements(Collection $elements, ConnectionInterface $con = null)
    {
        /** @var ChildElement[] $elementsToDelete */
        $elementsToDelete = $this->getElements(new Criteria(), $con)->diff($elements);


        $this->elementsScheduledForDeletion = $elementsToDelete;

        foreach ($elementsToDelete as $elementRemoved) {
            $elementRemoved->setUser(null);
        }

        $this->collElements = null;
        foreach ($elements as $element) {
            $this->addElement($element);
        }

        $this->collElements = $elements;
        $this->collElementsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Element objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Element objects.
     * @throws PropelException
     */
    public function countElements(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getElements());
            }

            $query = ChildElementQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collElements);
    }

    /**
     * Method called to associate a ChildElement object to this object
     * through the ChildElement foreign key attribute.
     *
     * @param  ChildElement $l ChildElement
     * @return $this|\User The current object (for fluent API support)
     */
    public function addElement(ChildElement $l)
    {
        if ($this->collElements === null) {
            $this->initElements();
            $this->collElementsPartial = true;
        }

        if (!$this->collElements->contains($l)) {
            $this->doAddElement($l);
        }

        return $this;
    }

    /**
     * @param ChildElement $element The ChildElement object to add.
     */
    protected function doAddElement(ChildElement $element)
    {
        $this->collElements[]= $element;
        $element->setUser($this);
    }

    /**
     * @param  ChildElement $element The ChildElement object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeElement(ChildElement $element)
    {
        if ($this->getElements()->contains($element)) {
            $pos = $this->collElements->search($element);
            $this->collElements->remove($pos);
            if (null === $this->elementsScheduledForDeletion) {
                $this->elementsScheduledForDeletion = clone $this->collElements;
                $this->elementsScheduledForDeletion->clear();
            }
            $this->elementsScheduledForDeletion[]= clone $element;
            $element->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collStudents collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStudents()
     */
    public function clearStudents()
    {
        $this->collStudents = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStudents collection loaded partially.
     */
    public function resetPartialStudents($v = true)
    {
        $this->collStudentsPartial = $v;
    }

    /**
     * Initializes the collStudents collection.
     *
     * By default this just sets the collStudents collection to an empty array (like clearcollStudents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudents($overrideExisting = true)
    {
        if (null !== $this->collStudents && !$overrideExisting) {
            return;
        }
        $this->collStudents = new ObjectCollection();
        $this->collStudents->setModel('\Student');
    }

    /**
     * Gets an array of ChildStudent objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStudent[] List of ChildStudent objects
     * @throws PropelException
     */
    public function getStudents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentsPartial && !$this->isNew();
        if (null === $this->collStudents || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudents) {
                // return empty collection
                $this->initStudents();
            } else {
                $collStudents = ChildStudentQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStudentsPartial && count($collStudents)) {
                        $this->initStudents(false);

                        foreach ($collStudents as $obj) {
                            if (false == $this->collStudents->contains($obj)) {
                                $this->collStudents->append($obj);
                            }
                        }

                        $this->collStudentsPartial = true;
                    }

                    return $collStudents;
                }

                if ($partial && $this->collStudents) {
                    foreach ($this->collStudents as $obj) {
                        if ($obj->isNew()) {
                            $collStudents[] = $obj;
                        }
                    }
                }

                $this->collStudents = $collStudents;
                $this->collStudentsPartial = false;
            }
        }

        return $this->collStudents;
    }

    /**
     * Sets a collection of ChildStudent objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $students A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setStudents(Collection $students, ConnectionInterface $con = null)
    {
        /** @var ChildStudent[] $studentsToDelete */
        $studentsToDelete = $this->getStudents(new Criteria(), $con)->diff($students);


        $this->studentsScheduledForDeletion = $studentsToDelete;

        foreach ($studentsToDelete as $studentRemoved) {
            $studentRemoved->setUser(null);
        }

        $this->collStudents = null;
        foreach ($students as $student) {
            $this->addStudent($student);
        }

        $this->collStudents = $students;
        $this->collStudentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Student objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Student objects.
     * @throws PropelException
     */
    public function countStudents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentsPartial && !$this->isNew();
        if (null === $this->collStudents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudents) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStudents());
            }

            $query = ChildStudentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collStudents);
    }

    /**
     * Method called to associate a ChildStudent object to this object
     * through the ChildStudent foreign key attribute.
     *
     * @param  ChildStudent $l ChildStudent
     * @return $this|\User The current object (for fluent API support)
     */
    public function addStudent(ChildStudent $l)
    {
        if ($this->collStudents === null) {
            $this->initStudents();
            $this->collStudentsPartial = true;
        }

        if (!$this->collStudents->contains($l)) {
            $this->doAddStudent($l);
        }

        return $this;
    }

    /**
     * @param ChildStudent $student The ChildStudent object to add.
     */
    protected function doAddStudent(ChildStudent $student)
    {
        $this->collStudents[]= $student;
        $student->setUser($this);
    }

    /**
     * @param  ChildStudent $student The ChildStudent object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeStudent(ChildStudent $student)
    {
        if ($this->getStudents()->contains($student)) {
            $pos = $this->collStudents->search($student);
            $this->collStudents->remove($pos);
            if (null === $this->studentsScheduledForDeletion) {
                $this->studentsScheduledForDeletion = clone $this->collStudents;
                $this->studentsScheduledForDeletion->clear();
            }
            $this->studentsScheduledForDeletion[]= clone $student;
            $student->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collKumis collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addKumis()
     */
    public function clearKumis()
    {
        $this->collKumis = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collKumis collection loaded partially.
     */
    public function resetPartialKumis($v = true)
    {
        $this->collKumisPartial = $v;
    }

    /**
     * Initializes the collKumis collection.
     *
     * By default this just sets the collKumis collection to an empty array (like clearcollKumis());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initKumis($overrideExisting = true)
    {
        if (null !== $this->collKumis && !$overrideExisting) {
            return;
        }
        $this->collKumis = new ObjectCollection();
        $this->collKumis->setModel('\Kumi');
    }

    /**
     * Gets an array of ChildKumi objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildKumi[] List of ChildKumi objects
     * @throws PropelException
     */
    public function getKumis(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collKumisPartial && !$this->isNew();
        if (null === $this->collKumis || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collKumis) {
                // return empty collection
                $this->initKumis();
            } else {
                $collKumis = ChildKumiQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collKumisPartial && count($collKumis)) {
                        $this->initKumis(false);

                        foreach ($collKumis as $obj) {
                            if (false == $this->collKumis->contains($obj)) {
                                $this->collKumis->append($obj);
                            }
                        }

                        $this->collKumisPartial = true;
                    }

                    return $collKumis;
                }

                if ($partial && $this->collKumis) {
                    foreach ($this->collKumis as $obj) {
                        if ($obj->isNew()) {
                            $collKumis[] = $obj;
                        }
                    }
                }

                $this->collKumis = $collKumis;
                $this->collKumisPartial = false;
            }
        }

        return $this->collKumis;
    }

    /**
     * Sets a collection of ChildKumi objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $kumis A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setKumis(Collection $kumis, ConnectionInterface $con = null)
    {
        /** @var ChildKumi[] $kumisToDelete */
        $kumisToDelete = $this->getKumis(new Criteria(), $con)->diff($kumis);


        $this->kumisScheduledForDeletion = $kumisToDelete;

        foreach ($kumisToDelete as $kumiRemoved) {
            $kumiRemoved->setUser(null);
        }

        $this->collKumis = null;
        foreach ($kumis as $kumi) {
            $this->addKumi($kumi);
        }

        $this->collKumis = $kumis;
        $this->collKumisPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Kumi objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Kumi objects.
     * @throws PropelException
     */
    public function countKumis(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collKumisPartial && !$this->isNew();
        if (null === $this->collKumis || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collKumis) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getKumis());
            }

            $query = ChildKumiQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collKumis);
    }

    /**
     * Method called to associate a ChildKumi object to this object
     * through the ChildKumi foreign key attribute.
     *
     * @param  ChildKumi $l ChildKumi
     * @return $this|\User The current object (for fluent API support)
     */
    public function addKumi(ChildKumi $l)
    {
        if ($this->collKumis === null) {
            $this->initKumis();
            $this->collKumisPartial = true;
        }

        if (!$this->collKumis->contains($l)) {
            $this->doAddKumi($l);
        }

        return $this;
    }

    /**
     * @param ChildKumi $kumi The ChildKumi object to add.
     */
    protected function doAddKumi(ChildKumi $kumi)
    {
        $this->collKumis[]= $kumi;
        $kumi->setUser($this);
    }

    /**
     * @param  ChildKumi $kumi The ChildKumi object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeKumi(ChildKumi $kumi)
    {
        if ($this->getKumis()->contains($kumi)) {
            $pos = $this->collKumis->search($kumi);
            $this->collKumis->remove($pos);
            if (null === $this->kumisScheduledForDeletion) {
                $this->kumisScheduledForDeletion = clone $this->collKumis;
                $this->kumisScheduledForDeletion->clear();
            }
            $this->kumisScheduledForDeletion[]= clone $kumi;
            $kumi->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collStockTexts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStockTexts()
     */
    public function clearStockTexts()
    {
        $this->collStockTexts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStockTexts collection loaded partially.
     */
    public function resetPartialStockTexts($v = true)
    {
        $this->collStockTextsPartial = $v;
    }

    /**
     * Initializes the collStockTexts collection.
     *
     * By default this just sets the collStockTexts collection to an empty array (like clearcollStockTexts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockTexts($overrideExisting = true)
    {
        if (null !== $this->collStockTexts && !$overrideExisting) {
            return;
        }
        $this->collStockTexts = new ObjectCollection();
        $this->collStockTexts->setModel('\StockText');
    }

    /**
     * Gets an array of ChildStockText objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStockText[] List of ChildStockText objects
     * @throws PropelException
     */
    public function getStockTexts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStockTextsPartial && !$this->isNew();
        if (null === $this->collStockTexts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStockTexts) {
                // return empty collection
                $this->initStockTexts();
            } else {
                $collStockTexts = ChildStockTextQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStockTextsPartial && count($collStockTexts)) {
                        $this->initStockTexts(false);

                        foreach ($collStockTexts as $obj) {
                            if (false == $this->collStockTexts->contains($obj)) {
                                $this->collStockTexts->append($obj);
                            }
                        }

                        $this->collStockTextsPartial = true;
                    }

                    return $collStockTexts;
                }

                if ($partial && $this->collStockTexts) {
                    foreach ($this->collStockTexts as $obj) {
                        if ($obj->isNew()) {
                            $collStockTexts[] = $obj;
                        }
                    }
                }

                $this->collStockTexts = $collStockTexts;
                $this->collStockTextsPartial = false;
            }
        }

        return $this->collStockTexts;
    }

    /**
     * Sets a collection of ChildStockText objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $stockTexts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setStockTexts(Collection $stockTexts, ConnectionInterface $con = null)
    {
        /** @var ChildStockText[] $stockTextsToDelete */
        $stockTextsToDelete = $this->getStockTexts(new Criteria(), $con)->diff($stockTexts);


        $this->stockTextsScheduledForDeletion = $stockTextsToDelete;

        foreach ($stockTextsToDelete as $stockTextRemoved) {
            $stockTextRemoved->setUser(null);
        }

        $this->collStockTexts = null;
        foreach ($stockTexts as $stockText) {
            $this->addStockText($stockText);
        }

        $this->collStockTexts = $stockTexts;
        $this->collStockTextsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StockText objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StockText objects.
     * @throws PropelException
     */
    public function countStockTexts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStockTextsPartial && !$this->isNew();
        if (null === $this->collStockTexts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockTexts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockTexts());
            }

            $query = ChildStockTextQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collStockTexts);
    }

    /**
     * Method called to associate a ChildStockText object to this object
     * through the ChildStockText foreign key attribute.
     *
     * @param  ChildStockText $l ChildStockText
     * @return $this|\User The current object (for fluent API support)
     */
    public function addStockText(ChildStockText $l)
    {
        if ($this->collStockTexts === null) {
            $this->initStockTexts();
            $this->collStockTextsPartial = true;
        }

        if (!$this->collStockTexts->contains($l)) {
            $this->doAddStockText($l);
        }

        return $this;
    }

    /**
     * @param ChildStockText $stockText The ChildStockText object to add.
     */
    protected function doAddStockText(ChildStockText $stockText)
    {
        $this->collStockTexts[]= $stockText;
        $stockText->setUser($this);
    }

    /**
     * @param  ChildStockText $stockText The ChildStockText object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeStockText(ChildStockText $stockText)
    {
        if ($this->getStockTexts()->contains($stockText)) {
            $pos = $this->collStockTexts->search($stockText);
            $this->collStockTexts->remove($pos);
            if (null === $this->stockTextsScheduledForDeletion) {
                $this->stockTextsScheduledForDeletion = clone $this->collStockTexts;
                $this->stockTextsScheduledForDeletion->clear();
            }
            $this->stockTextsScheduledForDeletion[]= clone $stockText;
            $stockText->setUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collQuestionScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestionScores()
     */
    public function clearQuestionScores()
    {
        $this->collQuestionScores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collQuestionScores collection loaded partially.
     */
    public function resetPartialQuestionScores($v = true)
    {
        $this->collQuestionScoresPartial = $v;
    }

    /**
     * Initializes the collQuestionScores collection.
     *
     * By default this just sets the collQuestionScores collection to an empty array (like clearcollQuestionScores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestionScores($overrideExisting = true)
    {
        if (null !== $this->collQuestionScores && !$overrideExisting) {
            return;
        }
        $this->collQuestionScores = new ObjectCollection();
        $this->collQuestionScores->setModel('\QuestionScore');
    }

    /**
     * Gets an array of ChildQuestionScore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestionScore[] List of ChildQuestionScore objects
     * @throws PropelException
     */
    public function getQuestionScores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionScoresPartial && !$this->isNew();
        if (null === $this->collQuestionScores || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuestionScores) {
                // return empty collection
                $this->initQuestionScores();
            } else {
                $collQuestionScores = ChildQuestionScoreQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collQuestionScoresPartial && count($collQuestionScores)) {
                        $this->initQuestionScores(false);

                        foreach ($collQuestionScores as $obj) {
                            if (false == $this->collQuestionScores->contains($obj)) {
                                $this->collQuestionScores->append($obj);
                            }
                        }

                        $this->collQuestionScoresPartial = true;
                    }

                    return $collQuestionScores;
                }

                if ($partial && $this->collQuestionScores) {
                    foreach ($this->collQuestionScores as $obj) {
                        if ($obj->isNew()) {
                            $collQuestionScores[] = $obj;
                        }
                    }
                }

                $this->collQuestionScores = $collQuestionScores;
                $this->collQuestionScoresPartial = false;
            }
        }

        return $this->collQuestionScores;
    }

    /**
     * Sets a collection of ChildQuestionScore objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questionScores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setQuestionScores(Collection $questionScores, ConnectionInterface $con = null)
    {
        /** @var ChildQuestionScore[] $questionScoresToDelete */
        $questionScoresToDelete = $this->getQuestionScores(new Criteria(), $con)->diff($questionScores);


        $this->questionScoresScheduledForDeletion = $questionScoresToDelete;

        foreach ($questionScoresToDelete as $questionScoreRemoved) {
            $questionScoreRemoved->setUser(null);
        }

        $this->collQuestionScores = null;
        foreach ($questionScores as $questionScore) {
            $this->addQuestionScore($questionScore);
        }

        $this->collQuestionScores = $questionScores;
        $this->collQuestionScoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related QuestionScore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related QuestionScore objects.
     * @throws PropelException
     */
    public function countQuestionScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionScoresPartial && !$this->isNew();
        if (null === $this->collQuestionScores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestionScores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getQuestionScores());
            }

            $query = ChildQuestionScoreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collQuestionScores);
    }

    /**
     * Method called to associate a ChildQuestionScore object to this object
     * through the ChildQuestionScore foreign key attribute.
     *
     * @param  ChildQuestionScore $l ChildQuestionScore
     * @return $this|\User The current object (for fluent API support)
     */
    public function addQuestionScore(ChildQuestionScore $l)
    {
        if ($this->collQuestionScores === null) {
            $this->initQuestionScores();
            $this->collQuestionScoresPartial = true;
        }

        if (!$this->collQuestionScores->contains($l)) {
            $this->doAddQuestionScore($l);
        }

        return $this;
    }

    /**
     * @param ChildQuestionScore $questionScore The ChildQuestionScore object to add.
     */
    protected function doAddQuestionScore(ChildQuestionScore $questionScore)
    {
        $this->collQuestionScores[]= $questionScore;
        $questionScore->setUser($this);
    }

    /**
     * @param  ChildQuestionScore $questionScore The ChildQuestionScore object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeQuestionScore(ChildQuestionScore $questionScore)
    {
        if ($this->getQuestionScores()->contains($questionScore)) {
            $pos = $this->collQuestionScores->search($questionScore);
            $this->collQuestionScores->remove($pos);
            if (null === $this->questionScoresScheduledForDeletion) {
                $this->questionScoresScheduledForDeletion = clone $this->collQuestionScores;
                $this->questionScoresScheduledForDeletion->clear();
            }
            $this->questionScoresScheduledForDeletion[]= clone $questionScore;
            $questionScore->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related QuestionScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildQuestionScore[] List of ChildQuestionScore objects
     */
    public function getQuestionScoresJoinExam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildQuestionScoreQuery::create(null, $criteria);
        $query->joinWith('Exam', $joinBehavior);

        return $this->getQuestionScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related QuestionScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildQuestionScore[] List of ChildQuestionScore objects
     */
    public function getQuestionScoresJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildQuestionScoreQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getQuestionScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related QuestionScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildQuestionScore[] List of ChildQuestionScore objects
     */
    public function getQuestionScoresJoinQuestion(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildQuestionScoreQuery::create(null, $criteria);
        $query->joinWith('Question', $joinBehavior);

        return $this->getQuestionScores($query, $con);
    }

    /**
     * Clears out the collElementScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addElementScores()
     */
    public function clearElementScores()
    {
        $this->collElementScores = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collElementScores collection loaded partially.
     */
    public function resetPartialElementScores($v = true)
    {
        $this->collElementScoresPartial = $v;
    }

    /**
     * Initializes the collElementScores collection.
     *
     * By default this just sets the collElementScores collection to an empty array (like clearcollElementScores());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementScores($overrideExisting = true)
    {
        if (null !== $this->collElementScores && !$overrideExisting) {
            return;
        }
        $this->collElementScores = new ObjectCollection();
        $this->collElementScores->setModel('\ElementScore');
    }

    /**
     * Gets an array of ChildElementScore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildElementScore[] List of ChildElementScore objects
     * @throws PropelException
     */
    public function getElementScores(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collElementScoresPartial && !$this->isNew();
        if (null === $this->collElementScores || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementScores) {
                // return empty collection
                $this->initElementScores();
            } else {
                $collElementScores = ChildElementScoreQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collElementScoresPartial && count($collElementScores)) {
                        $this->initElementScores(false);

                        foreach ($collElementScores as $obj) {
                            if (false == $this->collElementScores->contains($obj)) {
                                $this->collElementScores->append($obj);
                            }
                        }

                        $this->collElementScoresPartial = true;
                    }

                    return $collElementScores;
                }

                if ($partial && $this->collElementScores) {
                    foreach ($this->collElementScores as $obj) {
                        if ($obj->isNew()) {
                            $collElementScores[] = $obj;
                        }
                    }
                }

                $this->collElementScores = $collElementScores;
                $this->collElementScoresPartial = false;
            }
        }

        return $this->collElementScores;
    }

    /**
     * Sets a collection of ChildElementScore objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $elementScores A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setElementScores(Collection $elementScores, ConnectionInterface $con = null)
    {
        /** @var ChildElementScore[] $elementScoresToDelete */
        $elementScoresToDelete = $this->getElementScores(new Criteria(), $con)->diff($elementScores);


        $this->elementScoresScheduledForDeletion = $elementScoresToDelete;

        foreach ($elementScoresToDelete as $elementScoreRemoved) {
            $elementScoreRemoved->setUser(null);
        }

        $this->collElementScores = null;
        foreach ($elementScores as $elementScore) {
            $this->addElementScore($elementScore);
        }

        $this->collElementScores = $elementScores;
        $this->collElementScoresPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementScore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ElementScore objects.
     * @throws PropelException
     */
    public function countElementScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collElementScoresPartial && !$this->isNew();
        if (null === $this->collElementScores || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementScores) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getElementScores());
            }

            $query = ChildElementScoreQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collElementScores);
    }

    /**
     * Method called to associate a ChildElementScore object to this object
     * through the ChildElementScore foreign key attribute.
     *
     * @param  ChildElementScore $l ChildElementScore
     * @return $this|\User The current object (for fluent API support)
     */
    public function addElementScore(ChildElementScore $l)
    {
        if ($this->collElementScores === null) {
            $this->initElementScores();
            $this->collElementScoresPartial = true;
        }

        if (!$this->collElementScores->contains($l)) {
            $this->doAddElementScore($l);
        }

        return $this;
    }

    /**
     * @param ChildElementScore $elementScore The ChildElementScore object to add.
     */
    protected function doAddElementScore(ChildElementScore $elementScore)
    {
        $this->collElementScores[]= $elementScore;
        $elementScore->setUser($this);
    }

    /**
     * @param  ChildElementScore $elementScore The ChildElementScore object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeElementScore(ChildElementScore $elementScore)
    {
        if ($this->getElementScores()->contains($elementScore)) {
            $pos = $this->collElementScores->search($elementScore);
            $this->collElementScores->remove($pos);
            if (null === $this->elementScoresScheduledForDeletion) {
                $this->elementScoresScheduledForDeletion = clone $this->collElementScores;
                $this->elementScoresScheduledForDeletion->clear();
            }
            $this->elementScoresScheduledForDeletion[]= clone $elementScore;
            $elementScore->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ElementScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementScore[] List of ChildElementScore objects
     */
    public function getElementScoresJoinExam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildElementScoreQuery::create(null, $criteria);
        $query->joinWith('Exam', $joinBehavior);

        return $this->getElementScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ElementScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementScore[] List of ChildElementScore objects
     */
    public function getElementScoresJoinElement(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildElementScoreQuery::create(null, $criteria);
        $query->joinWith('Element', $joinBehavior);

        return $this->getElementScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ElementScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementScore[] List of ChildElementScore objects
     */
    public function getElementScoresJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildElementScoreQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getElementScores($query, $con);
    }

    /**
     * Clears out the collExamInfos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExamInfos()
     */
    public function clearExamInfos()
    {
        $this->collExamInfos = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExamInfos collection loaded partially.
     */
    public function resetPartialExamInfos($v = true)
    {
        $this->collExamInfosPartial = $v;
    }

    /**
     * Initializes the collExamInfos collection.
     *
     * By default this just sets the collExamInfos collection to an empty array (like clearcollExamInfos());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExamInfos($overrideExisting = true)
    {
        if (null !== $this->collExamInfos && !$overrideExisting) {
            return;
        }
        $this->collExamInfos = new ObjectCollection();
        $this->collExamInfos->setModel('\ExamInfo');
    }

    /**
     * Gets an array of ChildExamInfo objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExamInfo[] List of ChildExamInfo objects
     * @throws PropelException
     */
    public function getExamInfos(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExamInfosPartial && !$this->isNew();
        if (null === $this->collExamInfos || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExamInfos) {
                // return empty collection
                $this->initExamInfos();
            } else {
                $collExamInfos = ChildExamInfoQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExamInfosPartial && count($collExamInfos)) {
                        $this->initExamInfos(false);

                        foreach ($collExamInfos as $obj) {
                            if (false == $this->collExamInfos->contains($obj)) {
                                $this->collExamInfos->append($obj);
                            }
                        }

                        $this->collExamInfosPartial = true;
                    }

                    return $collExamInfos;
                }

                if ($partial && $this->collExamInfos) {
                    foreach ($this->collExamInfos as $obj) {
                        if ($obj->isNew()) {
                            $collExamInfos[] = $obj;
                        }
                    }
                }

                $this->collExamInfos = $collExamInfos;
                $this->collExamInfosPartial = false;
            }
        }

        return $this->collExamInfos;
    }

    /**
     * Sets a collection of ChildExamInfo objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $examInfos A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setExamInfos(Collection $examInfos, ConnectionInterface $con = null)
    {
        /** @var ChildExamInfo[] $examInfosToDelete */
        $examInfosToDelete = $this->getExamInfos(new Criteria(), $con)->diff($examInfos);


        $this->examInfosScheduledForDeletion = $examInfosToDelete;

        foreach ($examInfosToDelete as $examInfoRemoved) {
            $examInfoRemoved->setUser(null);
        }

        $this->collExamInfos = null;
        foreach ($examInfos as $examInfo) {
            $this->addExamInfo($examInfo);
        }

        $this->collExamInfos = $examInfos;
        $this->collExamInfosPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ExamInfo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ExamInfo objects.
     * @throws PropelException
     */
    public function countExamInfos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExamInfosPartial && !$this->isNew();
        if (null === $this->collExamInfos || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExamInfos) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExamInfos());
            }

            $query = ChildExamInfoQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collExamInfos);
    }

    /**
     * Method called to associate a ChildExamInfo object to this object
     * through the ChildExamInfo foreign key attribute.
     *
     * @param  ChildExamInfo $l ChildExamInfo
     * @return $this|\User The current object (for fluent API support)
     */
    public function addExamInfo(ChildExamInfo $l)
    {
        if ($this->collExamInfos === null) {
            $this->initExamInfos();
            $this->collExamInfosPartial = true;
        }

        if (!$this->collExamInfos->contains($l)) {
            $this->doAddExamInfo($l);
        }

        return $this;
    }

    /**
     * @param ChildExamInfo $examInfo The ChildExamInfo object to add.
     */
    protected function doAddExamInfo(ChildExamInfo $examInfo)
    {
        $this->collExamInfos[]= $examInfo;
        $examInfo->setUser($this);
    }

    /**
     * @param  ChildExamInfo $examInfo The ChildExamInfo object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeExamInfo(ChildExamInfo $examInfo)
    {
        if ($this->getExamInfos()->contains($examInfo)) {
            $pos = $this->collExamInfos->search($examInfo);
            $this->collExamInfos->remove($pos);
            if (null === $this->examInfosScheduledForDeletion) {
                $this->examInfosScheduledForDeletion = clone $this->collExamInfos;
                $this->examInfosScheduledForDeletion->clear();
            }
            $this->examInfosScheduledForDeletion[]= clone $examInfo;
            $examInfo->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ExamInfos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamInfo[] List of ChildExamInfo objects
     */
    public function getExamInfosJoinExam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamInfoQuery::create(null, $criteria);
        $query->joinWith('Exam', $joinBehavior);

        return $this->getExamInfos($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related ExamInfos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamInfo[] List of ChildExamInfo objects
     */
    public function getExamInfosJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamInfoQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getExamInfos($query, $con);
    }

    /**
     * Clears out the collGradingTimes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGradingTimes()
     */
    public function clearGradingTimes()
    {
        $this->collGradingTimes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGradingTimes collection loaded partially.
     */
    public function resetPartialGradingTimes($v = true)
    {
        $this->collGradingTimesPartial = $v;
    }

    /**
     * Initializes the collGradingTimes collection.
     *
     * By default this just sets the collGradingTimes collection to an empty array (like clearcollGradingTimes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGradingTimes($overrideExisting = true)
    {
        if (null !== $this->collGradingTimes && !$overrideExisting) {
            return;
        }
        $this->collGradingTimes = new ObjectCollection();
        $this->collGradingTimes->setModel('\GradingTime');
    }

    /**
     * Gets an array of ChildGradingTime objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGradingTime[] List of ChildGradingTime objects
     * @throws PropelException
     */
    public function getGradingTimes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGradingTimesPartial && !$this->isNew();
        if (null === $this->collGradingTimes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGradingTimes) {
                // return empty collection
                $this->initGradingTimes();
            } else {
                $collGradingTimes = ChildGradingTimeQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGradingTimesPartial && count($collGradingTimes)) {
                        $this->initGradingTimes(false);

                        foreach ($collGradingTimes as $obj) {
                            if (false == $this->collGradingTimes->contains($obj)) {
                                $this->collGradingTimes->append($obj);
                            }
                        }

                        $this->collGradingTimesPartial = true;
                    }

                    return $collGradingTimes;
                }

                if ($partial && $this->collGradingTimes) {
                    foreach ($this->collGradingTimes as $obj) {
                        if ($obj->isNew()) {
                            $collGradingTimes[] = $obj;
                        }
                    }
                }

                $this->collGradingTimes = $collGradingTimes;
                $this->collGradingTimesPartial = false;
            }
        }

        return $this->collGradingTimes;
    }

    /**
     * Sets a collection of ChildGradingTime objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $gradingTimes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setGradingTimes(Collection $gradingTimes, ConnectionInterface $con = null)
    {
        /** @var ChildGradingTime[] $gradingTimesToDelete */
        $gradingTimesToDelete = $this->getGradingTimes(new Criteria(), $con)->diff($gradingTimes);


        $this->gradingTimesScheduledForDeletion = $gradingTimesToDelete;

        foreach ($gradingTimesToDelete as $gradingTimeRemoved) {
            $gradingTimeRemoved->setUser(null);
        }

        $this->collGradingTimes = null;
        foreach ($gradingTimes as $gradingTime) {
            $this->addGradingTime($gradingTime);
        }

        $this->collGradingTimes = $gradingTimes;
        $this->collGradingTimesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GradingTime objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GradingTime objects.
     * @throws PropelException
     */
    public function countGradingTimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGradingTimesPartial && !$this->isNew();
        if (null === $this->collGradingTimes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGradingTimes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGradingTimes());
            }

            $query = ChildGradingTimeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collGradingTimes);
    }

    /**
     * Method called to associate a ChildGradingTime object to this object
     * through the ChildGradingTime foreign key attribute.
     *
     * @param  ChildGradingTime $l ChildGradingTime
     * @return $this|\User The current object (for fluent API support)
     */
    public function addGradingTime(ChildGradingTime $l)
    {
        if ($this->collGradingTimes === null) {
            $this->initGradingTimes();
            $this->collGradingTimesPartial = true;
        }

        if (!$this->collGradingTimes->contains($l)) {
            $this->doAddGradingTime($l);
        }

        return $this;
    }

    /**
     * @param ChildGradingTime $gradingTime The ChildGradingTime object to add.
     */
    protected function doAddGradingTime(ChildGradingTime $gradingTime)
    {
        $this->collGradingTimes[]= $gradingTime;
        $gradingTime->setUser($this);
    }

    /**
     * @param  ChildGradingTime $gradingTime The ChildGradingTime object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeGradingTime(ChildGradingTime $gradingTime)
    {
        if ($this->getGradingTimes()->contains($gradingTime)) {
            $pos = $this->collGradingTimes->search($gradingTime);
            $this->collGradingTimes->remove($pos);
            if (null === $this->gradingTimesScheduledForDeletion) {
                $this->gradingTimesScheduledForDeletion = clone $this->collGradingTimes;
                $this->gradingTimesScheduledForDeletion->clear();
            }
            $this->gradingTimesScheduledForDeletion[]= clone $gradingTime;
            $gradingTime->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related GradingTimes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGradingTime[] List of ChildGradingTime objects
     */
    public function getGradingTimesJoinExam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGradingTimeQuery::create(null, $criteria);
        $query->joinWith('Exam', $joinBehavior);

        return $this->getGradingTimes($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related GradingTimes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGradingTime[] List of ChildGradingTime objects
     */
    public function getGradingTimesJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGradingTimeQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getGradingTimes($query, $con);
    }

    /**
     * Clears out the collGroupTimes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGroupTimes()
     */
    public function clearGroupTimes()
    {
        $this->collGroupTimes = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collGroupTimes collection loaded partially.
     */
    public function resetPartialGroupTimes($v = true)
    {
        $this->collGroupTimesPartial = $v;
    }

    /**
     * Initializes the collGroupTimes collection.
     *
     * By default this just sets the collGroupTimes collection to an empty array (like clearcollGroupTimes());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initGroupTimes($overrideExisting = true)
    {
        if (null !== $this->collGroupTimes && !$overrideExisting) {
            return;
        }
        $this->collGroupTimes = new ObjectCollection();
        $this->collGroupTimes->setModel('\GroupTime');
    }

    /**
     * Gets an array of ChildGroupTime objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildGroupTime[] List of ChildGroupTime objects
     * @throws PropelException
     */
    public function getGroupTimes(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupTimesPartial && !$this->isNew();
        if (null === $this->collGroupTimes || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collGroupTimes) {
                // return empty collection
                $this->initGroupTimes();
            } else {
                $collGroupTimes = ChildGroupTimeQuery::create(null, $criteria)
                    ->filterByUser($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collGroupTimesPartial && count($collGroupTimes)) {
                        $this->initGroupTimes(false);

                        foreach ($collGroupTimes as $obj) {
                            if (false == $this->collGroupTimes->contains($obj)) {
                                $this->collGroupTimes->append($obj);
                            }
                        }

                        $this->collGroupTimesPartial = true;
                    }

                    return $collGroupTimes;
                }

                if ($partial && $this->collGroupTimes) {
                    foreach ($this->collGroupTimes as $obj) {
                        if ($obj->isNew()) {
                            $collGroupTimes[] = $obj;
                        }
                    }
                }

                $this->collGroupTimes = $collGroupTimes;
                $this->collGroupTimesPartial = false;
            }
        }

        return $this->collGroupTimes;
    }

    /**
     * Sets a collection of ChildGroupTime objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $groupTimes A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function setGroupTimes(Collection $groupTimes, ConnectionInterface $con = null)
    {
        /** @var ChildGroupTime[] $groupTimesToDelete */
        $groupTimesToDelete = $this->getGroupTimes(new Criteria(), $con)->diff($groupTimes);


        $this->groupTimesScheduledForDeletion = $groupTimesToDelete;

        foreach ($groupTimesToDelete as $groupTimeRemoved) {
            $groupTimeRemoved->setUser(null);
        }

        $this->collGroupTimes = null;
        foreach ($groupTimes as $groupTime) {
            $this->addGroupTime($groupTime);
        }

        $this->collGroupTimes = $groupTimes;
        $this->collGroupTimesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related GroupTime objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GroupTime objects.
     * @throws PropelException
     */
    public function countGroupTimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collGroupTimesPartial && !$this->isNew();
        if (null === $this->collGroupTimes || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collGroupTimes) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getGroupTimes());
            }

            $query = ChildGroupTimeQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUser($this)
                ->count($con);
        }

        return count($this->collGroupTimes);
    }

    /**
     * Method called to associate a ChildGroupTime object to this object
     * through the ChildGroupTime foreign key attribute.
     *
     * @param  ChildGroupTime $l ChildGroupTime
     * @return $this|\User The current object (for fluent API support)
     */
    public function addGroupTime(ChildGroupTime $l)
    {
        if ($this->collGroupTimes === null) {
            $this->initGroupTimes();
            $this->collGroupTimesPartial = true;
        }

        if (!$this->collGroupTimes->contains($l)) {
            $this->doAddGroupTime($l);
        }

        return $this;
    }

    /**
     * @param ChildGroupTime $groupTime The ChildGroupTime object to add.
     */
    protected function doAddGroupTime(ChildGroupTime $groupTime)
    {
        $this->collGroupTimes[]= $groupTime;
        $groupTime->setUser($this);
    }

    /**
     * @param  ChildGroupTime $groupTime The ChildGroupTime object to remove.
     * @return $this|ChildUser The current object (for fluent API support)
     */
    public function removeGroupTime(ChildGroupTime $groupTime)
    {
        if ($this->getGroupTimes()->contains($groupTime)) {
            $pos = $this->collGroupTimes->search($groupTime);
            $this->collGroupTimes->remove($pos);
            if (null === $this->groupTimesScheduledForDeletion) {
                $this->groupTimesScheduledForDeletion = clone $this->collGroupTimes;
                $this->groupTimesScheduledForDeletion->clear();
            }
            $this->groupTimesScheduledForDeletion[]= clone $groupTime;
            $groupTime->setUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this User is new, it will return
     * an empty collection; or if this User has previously
     * been saved, it will retrieve related GroupTimes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in User.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGroupTime[] List of ChildGroupTime objects
     */
    public function getGroupTimesJoinExam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGroupTimeQuery::create(null, $criteria);
        $query->joinWith('Exam', $joinBehavior);

        return $this->getGroupTimes($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->displayname = null;
        $this->password = null;
        $this->email = null;
        $this->activation_token = null;
        $this->last_activation_request = null;
        $this->lost_password_request = null;
        $this->active = null;
        $this->title = null;
        $this->sign_up_stamp = null;
        $this->last_sign_in_stamp = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collTerms) {
                foreach ($this->collTerms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTopics) {
                foreach ($this->collTopics as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collYears) {
                foreach ($this->collYears as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExams) {
                foreach ($this->collExams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuestions) {
                foreach ($this->collQuestions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElements) {
                foreach ($this->collElements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudents) {
                foreach ($this->collStudents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collKumis) {
                foreach ($this->collKumis as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStockTexts) {
                foreach ($this->collStockTexts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuestionScores) {
                foreach ($this->collQuestionScores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElementScores) {
                foreach ($this->collElementScores as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExamInfos) {
                foreach ($this->collExamInfos as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGradingTimes) {
                foreach ($this->collGradingTimes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collGroupTimes) {
                foreach ($this->collGroupTimes as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTerms = null;
        $this->collTopics = null;
        $this->collYears = null;
        $this->collExams = null;
        $this->collQuestions = null;
        $this->collElements = null;
        $this->collStudents = null;
        $this->collKumis = null;
        $this->collStockTexts = null;
        $this->collQuestionScores = null;
        $this->collElementScores = null;
        $this->collExamInfos = null;
        $this->collGradingTimes = null;
        $this->collGroupTimes = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UserTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildUser The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[UserTableMap::COL_UPDATED_AT] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
