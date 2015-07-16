<?php

namespace Base;

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
use \QuestionScore as ChildQuestionScore;
use \QuestionScoreQuery as ChildQuestionScoreQuery;
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
use Map\ExamTableMap;
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
 * Base class that represents a row from the 'exams' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Exam implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\ExamTableMap';


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
     * The value for the examterm field.
     * @var        string
     */
    protected $examterm;

    /**
     * The value for the examtopic field.
     * @var        string
     */
    protected $examtopic;

    /**
     * The value for the examyear field.
     * @var        int
     */
    protected $examyear;

    /**
     * The value for the locked field.
     * @var        int
     */
    protected $locked;

    /**
     * The value for the released field.
     * @var        int
     */
    protected $released;

    /**
     * The value for the user_id field.
     * @var        int
     */
    protected $user_id;

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
     * @var        ChildUser
     */
    protected $aUser;

    /**
     * @var        ChildTerm
     */
    protected $aTerm;

    /**
     * @var        ChildTopic
     */
    protected $aTopic;

    /**
     * @var        ChildYear
     */
    protected $aYear;

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
     * Initializes internal state of Base\Exam object.
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
     * Compares this with another <code>Exam</code> instance.  If
     * <code>obj</code> is an instance of <code>Exam</code>, delegates to
     * <code>equals(Exam)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Exam The current object, for fluid interface
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
     * Get the [examterm] column value.
     *
     * @return string
     */
    public function getExamterm()
    {
        return $this->examterm;
    }

    /**
     * Get the [examtopic] column value.
     *
     * @return string
     */
    public function getExamtopic()
    {
        return $this->examtopic;
    }

    /**
     * Get the [examyear] column value.
     *
     * @return int
     */
    public function getExamyear()
    {
        return $this->examyear;
    }

    /**
     * Get the [locked] column value.
     *
     * @return int
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Get the [released] column value.
     *
     * @return int
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->user_id;
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
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[ExamTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [examterm] column.
     *
     * @param string $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setExamterm($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->examterm !== $v) {
            $this->examterm = $v;
            $this->modifiedColumns[ExamTableMap::COL_EXAMTERM] = true;
        }

        if ($this->aTerm !== null && $this->aTerm->getContent() !== $v) {
            $this->aTerm = null;
        }

        return $this;
    } // setExamterm()

    /**
     * Set the value of [examtopic] column.
     *
     * @param string $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setExamtopic($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->examtopic !== $v) {
            $this->examtopic = $v;
            $this->modifiedColumns[ExamTableMap::COL_EXAMTOPIC] = true;
        }

        if ($this->aTopic !== null && $this->aTopic->getContent() !== $v) {
            $this->aTopic = null;
        }

        return $this;
    } // setExamtopic()

    /**
     * Set the value of [examyear] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setExamyear($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->examyear !== $v) {
            $this->examyear = $v;
            $this->modifiedColumns[ExamTableMap::COL_EXAMYEAR] = true;
        }

        if ($this->aYear !== null && $this->aYear->getContent() !== $v) {
            $this->aYear = null;
        }

        return $this;
    } // setExamyear()

    /**
     * Set the value of [locked] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setLocked($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->locked !== $v) {
            $this->locked = $v;
            $this->modifiedColumns[ExamTableMap::COL_LOCKED] = true;
        }

        return $this;
    } // setLocked()

    /**
     * Set the value of [released] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setReleased($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->released !== $v) {
            $this->released = $v;
            $this->modifiedColumns[ExamTableMap::COL_RELEASED] = true;
        }

        return $this;
    } // setReleased()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[ExamTableMap::COL_USER_ID] = true;
        }

        if ($this->aUser !== null && $this->aUser->getId() !== $v) {
            $this->aUser = null;
        }

        return $this;
    } // setUserId()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ExamTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ExamTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ExamTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ExamTableMap::translateFieldName('Examterm', TableMap::TYPE_PHPNAME, $indexType)];
            $this->examterm = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ExamTableMap::translateFieldName('Examtopic', TableMap::TYPE_PHPNAME, $indexType)];
            $this->examtopic = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ExamTableMap::translateFieldName('Examyear', TableMap::TYPE_PHPNAME, $indexType)];
            $this->examyear = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ExamTableMap::translateFieldName('Locked', TableMap::TYPE_PHPNAME, $indexType)];
            $this->locked = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ExamTableMap::translateFieldName('Released', TableMap::TYPE_PHPNAME, $indexType)];
            $this->released = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ExamTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ExamTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ExamTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 9; // 9 = ExamTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Exam'), 0, $e);
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
        if ($this->aTerm !== null && $this->examterm !== $this->aTerm->getContent()) {
            $this->aTerm = null;
        }
        if ($this->aTopic !== null && $this->examtopic !== $this->aTopic->getContent()) {
            $this->aTopic = null;
        }
        if ($this->aYear !== null && $this->examyear !== $this->aYear->getContent()) {
            $this->aYear = null;
        }
        if ($this->aUser !== null && $this->user_id !== $this->aUser->getId()) {
            $this->aUser = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(ExamTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildExamQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->aTerm = null;
            $this->aTopic = null;
            $this->aYear = null;
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
     * @see Exam::setDeleted()
     * @see Exam::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildExamQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ExamTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(ExamTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(ExamTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(ExamTableMap::COL_UPDATED_AT)) {
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
                ExamTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUser !== null) {
                if ($this->aUser->isModified() || $this->aUser->isNew()) {
                    $affectedRows += $this->aUser->save($con);
                }
                $this->setUser($this->aUser);
            }

            if ($this->aTerm !== null) {
                if ($this->aTerm->isModified() || $this->aTerm->isNew()) {
                    $affectedRows += $this->aTerm->save($con);
                }
                $this->setTerm($this->aTerm);
            }

            if ($this->aTopic !== null) {
                if ($this->aTopic->isModified() || $this->aTopic->isNew()) {
                    $affectedRows += $this->aTopic->save($con);
                }
                $this->setTopic($this->aTopic);
            }

            if ($this->aYear !== null) {
                if ($this->aYear->isModified() || $this->aYear->isNew()) {
                    $affectedRows += $this->aYear->save($con);
                }
                $this->setYear($this->aYear);
            }

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

        $this->modifiedColumns[ExamTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ExamTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ExamTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(ExamTableMap::COL_EXAMTERM)) {
            $modifiedColumns[':p' . $index++]  = 'examTerm';
        }
        if ($this->isColumnModified(ExamTableMap::COL_EXAMTOPIC)) {
            $modifiedColumns[':p' . $index++]  = 'examTopic';
        }
        if ($this->isColumnModified(ExamTableMap::COL_EXAMYEAR)) {
            $modifiedColumns[':p' . $index++]  = 'examYear';
        }
        if ($this->isColumnModified(ExamTableMap::COL_LOCKED)) {
            $modifiedColumns[':p' . $index++]  = 'locked';
        }
        if ($this->isColumnModified(ExamTableMap::COL_RELEASED)) {
            $modifiedColumns[':p' . $index++]  = 'released';
        }
        if ($this->isColumnModified(ExamTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(ExamTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(ExamTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO exams (%s) VALUES (%s)',
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
                    case 'examTerm':
                        $stmt->bindValue($identifier, $this->examterm, PDO::PARAM_STR);
                        break;
                    case 'examTopic':
                        $stmt->bindValue($identifier, $this->examtopic, PDO::PARAM_STR);
                        break;
                    case 'examYear':
                        $stmt->bindValue($identifier, $this->examyear, PDO::PARAM_INT);
                        break;
                    case 'locked':
                        $stmt->bindValue($identifier, $this->locked, PDO::PARAM_INT);
                        break;
                    case 'released':
                        $stmt->bindValue($identifier, $this->released, PDO::PARAM_INT);
                        break;
                    case 'user_id':
                        $stmt->bindValue($identifier, $this->user_id, PDO::PARAM_INT);
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
        $pos = ExamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getExamterm();
                break;
            case 2:
                return $this->getExamtopic();
                break;
            case 3:
                return $this->getExamyear();
                break;
            case 4:
                return $this->getLocked();
                break;
            case 5:
                return $this->getReleased();
                break;
            case 6:
                return $this->getUserId();
                break;
            case 7:
                return $this->getCreatedAt();
                break;
            case 8:
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

        if (isset($alreadyDumpedObjects['Exam'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Exam'][$this->hashCode()] = true;
        $keys = ExamTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getExamterm(),
            $keys[2] => $this->getExamtopic(),
            $keys[3] => $this->getExamyear(),
            $keys[4] => $this->getLocked(),
            $keys[5] => $this->getReleased(),
            $keys[6] => $this->getUserId(),
            $keys[7] => $this->getCreatedAt(),
            $keys[8] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[7]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[7]];
            $result[$keys[7]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[8]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[8]];
            $result[$keys[8]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUser) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'user';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'User';
                }

                $result[$key] = $this->aUser->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTerm) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'term';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'r_terms';
                        break;
                    default:
                        $key = 'Term';
                }

                $result[$key] = $this->aTerm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTopic) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'topic';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'r_examTopics';
                        break;
                    default:
                        $key = 'Topic';
                }

                $result[$key] = $this->aTopic->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aYear) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'year';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'r_years';
                        break;
                    default:
                        $key = 'Year';
                }

                $result[$key] = $this->aYear->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
     * @return $this|\Exam
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ExamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Exam
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setExamterm($value);
                break;
            case 2:
                $this->setExamtopic($value);
                break;
            case 3:
                $this->setExamyear($value);
                break;
            case 4:
                $this->setLocked($value);
                break;
            case 5:
                $this->setReleased($value);
                break;
            case 6:
                $this->setUserId($value);
                break;
            case 7:
                $this->setCreatedAt($value);
                break;
            case 8:
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
        $keys = ExamTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setExamterm($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setExamtopic($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setExamyear($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setLocked($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setReleased($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUserId($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCreatedAt($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setUpdatedAt($arr[$keys[8]]);
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
     * @return $this|\Exam The current object, for fluid interface
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
        $criteria = new Criteria(ExamTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ExamTableMap::COL_ID)) {
            $criteria->add(ExamTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(ExamTableMap::COL_EXAMTERM)) {
            $criteria->add(ExamTableMap::COL_EXAMTERM, $this->examterm);
        }
        if ($this->isColumnModified(ExamTableMap::COL_EXAMTOPIC)) {
            $criteria->add(ExamTableMap::COL_EXAMTOPIC, $this->examtopic);
        }
        if ($this->isColumnModified(ExamTableMap::COL_EXAMYEAR)) {
            $criteria->add(ExamTableMap::COL_EXAMYEAR, $this->examyear);
        }
        if ($this->isColumnModified(ExamTableMap::COL_LOCKED)) {
            $criteria->add(ExamTableMap::COL_LOCKED, $this->locked);
        }
        if ($this->isColumnModified(ExamTableMap::COL_RELEASED)) {
            $criteria->add(ExamTableMap::COL_RELEASED, $this->released);
        }
        if ($this->isColumnModified(ExamTableMap::COL_USER_ID)) {
            $criteria->add(ExamTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(ExamTableMap::COL_CREATED_AT)) {
            $criteria->add(ExamTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(ExamTableMap::COL_UPDATED_AT)) {
            $criteria->add(ExamTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildExamQuery::create();
        $criteria->add(ExamTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Exam (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setExamterm($this->getExamterm());
        $copyObj->setExamtopic($this->getExamtopic());
        $copyObj->setExamyear($this->getExamyear());
        $copyObj->setLocked($this->getLocked());
        $copyObj->setReleased($this->getReleased());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

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
     * @return \Exam Clone of current object.
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
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Exam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null)
    {
        if ($v === null) {
            $this->setUserId(NULL);
        } else {
            $this->setUserId($v->getId());
        }

        $this->aUser = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUser object, it will not be re-added.
        if ($v !== null) {
            $v->addExam($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null)
    {
        if ($this->aUser === null && ($this->user_id !== null)) {
            $this->aUser = ChildUserQuery::create()->findPk($this->user_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUser->addExams($this);
             */
        }

        return $this->aUser;
    }

    /**
     * Declares an association between this object and a ChildTerm object.
     *
     * @param  ChildTerm $v
     * @return $this|\Exam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTerm(ChildTerm $v = null)
    {
        if ($v === null) {
            $this->setExamterm(NULL);
        } else {
            $this->setExamterm($v->getContent());
        }

        $this->aTerm = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTerm object, it will not be re-added.
        if ($v !== null) {
            $v->addExam($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTerm object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTerm The associated ChildTerm object.
     * @throws PropelException
     */
    public function getTerm(ConnectionInterface $con = null)
    {
        if ($this->aTerm === null && (($this->examterm !== "" && $this->examterm !== null))) {
            $this->aTerm = ChildTermQuery::create()->findPk($this->examterm, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTerm->addExams($this);
             */
        }

        return $this->aTerm;
    }

    /**
     * Declares an association between this object and a ChildTopic object.
     *
     * @param  ChildTopic $v
     * @return $this|\Exam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTopic(ChildTopic $v = null)
    {
        if ($v === null) {
            $this->setExamtopic(NULL);
        } else {
            $this->setExamtopic($v->getContent());
        }

        $this->aTopic = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTopic object, it will not be re-added.
        if ($v !== null) {
            $v->addExam($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTopic object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTopic The associated ChildTopic object.
     * @throws PropelException
     */
    public function getTopic(ConnectionInterface $con = null)
    {
        if ($this->aTopic === null && (($this->examtopic !== "" && $this->examtopic !== null))) {
            $this->aTopic = ChildTopicQuery::create()->findPk($this->examtopic, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTopic->addExams($this);
             */
        }

        return $this->aTopic;
    }

    /**
     * Declares an association between this object and a ChildYear object.
     *
     * @param  ChildYear $v
     * @return $this|\Exam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setYear(ChildYear $v = null)
    {
        if ($v === null) {
            $this->setExamyear(NULL);
        } else {
            $this->setExamyear($v->getContent());
        }

        $this->aYear = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildYear object, it will not be re-added.
        if ($v !== null) {
            $v->addExam($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildYear object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildYear The associated ChildYear object.
     * @throws PropelException
     */
    public function getYear(ConnectionInterface $con = null)
    {
        if ($this->aYear === null && ($this->examyear !== null)) {
            $this->aYear = ChildYearQuery::create()->findPk($this->examyear, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aYear->addExams($this);
             */
        }

        return $this->aYear;
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
     * If this ChildExam is new, it will return
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
                    ->filterByExam($this)
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
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setQuestionScores(Collection $questionScores, ConnectionInterface $con = null)
    {
        /** @var ChildQuestionScore[] $questionScoresToDelete */
        $questionScoresToDelete = $this->getQuestionScores(new Criteria(), $con)->diff($questionScores);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->questionScoresScheduledForDeletion = clone $questionScoresToDelete;

        foreach ($questionScoresToDelete as $questionScoreRemoved) {
            $questionScoreRemoved->setExam(null);
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
                ->filterByExam($this)
                ->count($con);
        }

        return count($this->collQuestionScores);
    }

    /**
     * Method called to associate a ChildQuestionScore object to this object
     * through the ChildQuestionScore foreign key attribute.
     *
     * @param  ChildQuestionScore $l ChildQuestionScore
     * @return $this|\Exam The current object (for fluent API support)
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
        $questionScore->setExam($this);
    }

    /**
     * @param  ChildQuestionScore $questionScore The ChildQuestionScore object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
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
            $questionScore->setExam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related QuestionScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildQuestionScore[] List of ChildQuestionScore objects
     */
    public function getQuestionScoresJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildQuestionScoreQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getQuestionScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related QuestionScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
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
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related QuestionScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
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
     * If this ChildExam is new, it will return
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
                    ->filterByExam($this)
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
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setElementScores(Collection $elementScores, ConnectionInterface $con = null)
    {
        /** @var ChildElementScore[] $elementScoresToDelete */
        $elementScoresToDelete = $this->getElementScores(new Criteria(), $con)->diff($elementScores);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->elementScoresScheduledForDeletion = clone $elementScoresToDelete;

        foreach ($elementScoresToDelete as $elementScoreRemoved) {
            $elementScoreRemoved->setExam(null);
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
                ->filterByExam($this)
                ->count($con);
        }

        return count($this->collElementScores);
    }

    /**
     * Method called to associate a ChildElementScore object to this object
     * through the ChildElementScore foreign key attribute.
     *
     * @param  ChildElementScore $l ChildElementScore
     * @return $this|\Exam The current object (for fluent API support)
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
        $elementScore->setExam($this);
    }

    /**
     * @param  ChildElementScore $elementScore The ChildElementScore object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
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
            $elementScore->setExam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ElementScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementScore[] List of ChildElementScore objects
     */
    public function getElementScoresJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildElementScoreQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getElementScores($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ElementScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
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
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ElementScores from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
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
     * If this ChildExam is new, it will return
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
                    ->filterByExam($this)
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
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setExamInfos(Collection $examInfos, ConnectionInterface $con = null)
    {
        /** @var ChildExamInfo[] $examInfosToDelete */
        $examInfosToDelete = $this->getExamInfos(new Criteria(), $con)->diff($examInfos);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->examInfosScheduledForDeletion = clone $examInfosToDelete;

        foreach ($examInfosToDelete as $examInfoRemoved) {
            $examInfoRemoved->setExam(null);
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
                ->filterByExam($this)
                ->count($con);
        }

        return count($this->collExamInfos);
    }

    /**
     * Method called to associate a ChildExamInfo object to this object
     * through the ChildExamInfo foreign key attribute.
     *
     * @param  ChildExamInfo $l ChildExamInfo
     * @return $this|\Exam The current object (for fluent API support)
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
        $examInfo->setExam($this);
    }

    /**
     * @param  ChildExamInfo $examInfo The ChildExamInfo object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
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
            $examInfo->setExam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ExamInfos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamInfo[] List of ChildExamInfo objects
     */
    public function getExamInfosJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamInfoQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getExamInfos($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ExamInfos from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
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
     * If this ChildExam is new, it will return
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
                    ->filterByExam($this)
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
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setGradingTimes(Collection $gradingTimes, ConnectionInterface $con = null)
    {
        /** @var ChildGradingTime[] $gradingTimesToDelete */
        $gradingTimesToDelete = $this->getGradingTimes(new Criteria(), $con)->diff($gradingTimes);


        $this->gradingTimesScheduledForDeletion = $gradingTimesToDelete;

        foreach ($gradingTimesToDelete as $gradingTimeRemoved) {
            $gradingTimeRemoved->setExam(null);
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
                ->filterByExam($this)
                ->count($con);
        }

        return count($this->collGradingTimes);
    }

    /**
     * Method called to associate a ChildGradingTime object to this object
     * through the ChildGradingTime foreign key attribute.
     *
     * @param  ChildGradingTime $l ChildGradingTime
     * @return $this|\Exam The current object (for fluent API support)
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
        $gradingTime->setExam($this);
    }

    /**
     * @param  ChildGradingTime $gradingTime The ChildGradingTime object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
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
            $gradingTime->setExam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related GradingTimes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGradingTime[] List of ChildGradingTime objects
     */
    public function getGradingTimesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGradingTimeQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getGradingTimes($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related GradingTimes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
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
     * If this ChildExam is new, it will return
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
                    ->filterByExam($this)
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
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setGroupTimes(Collection $groupTimes, ConnectionInterface $con = null)
    {
        /** @var ChildGroupTime[] $groupTimesToDelete */
        $groupTimesToDelete = $this->getGroupTimes(new Criteria(), $con)->diff($groupTimes);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->groupTimesScheduledForDeletion = clone $groupTimesToDelete;

        foreach ($groupTimesToDelete as $groupTimeRemoved) {
            $groupTimeRemoved->setExam(null);
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
                ->filterByExam($this)
                ->count($con);
        }

        return count($this->collGroupTimes);
    }

    /**
     * Method called to associate a ChildGroupTime object to this object
     * through the ChildGroupTime foreign key attribute.
     *
     * @param  ChildGroupTime $l ChildGroupTime
     * @return $this|\Exam The current object (for fluent API support)
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
        $groupTime->setExam($this);
    }

    /**
     * @param  ChildGroupTime $groupTime The ChildGroupTime object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
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
            $groupTime->setExam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related GroupTimes from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildGroupTime[] List of ChildGroupTime objects
     */
    public function getGroupTimesJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildGroupTimeQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getGroupTimes($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUser) {
            $this->aUser->removeExam($this);
        }
        if (null !== $this->aTerm) {
            $this->aTerm->removeExam($this);
        }
        if (null !== $this->aTopic) {
            $this->aTopic->removeExam($this);
        }
        if (null !== $this->aYear) {
            $this->aYear->removeExam($this);
        }
        $this->id = null;
        $this->examterm = null;
        $this->examtopic = null;
        $this->examyear = null;
        $this->locked = null;
        $this->released = null;
        $this->user_id = null;
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

        $this->collQuestionScores = null;
        $this->collElementScores = null;
        $this->collExamInfos = null;
        $this->collGradingTimes = null;
        $this->collGroupTimes = null;
        $this->aUser = null;
        $this->aTerm = null;
        $this->aTopic = null;
        $this->aYear = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ExamTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildExam The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[ExamTableMap::COL_UPDATED_AT] = true;

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
