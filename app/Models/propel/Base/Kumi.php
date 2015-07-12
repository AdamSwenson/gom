<?php

namespace Base;

use \Exam as ChildExam;
use \ExamClassAssignment as ChildExamClassAssignment;
use \ExamClassAssignmentQuery as ChildExamClassAssignmentQuery;
use \ExamQuery as ChildExamQuery;
use \Kumi as ChildKumi;
use \KumiQuery as ChildKumiQuery;
use \Student as ChildStudent;
use \StudentClassAssignment as ChildStudentClassAssignment;
use \StudentClassAssignmentQuery as ChildStudentClassAssignmentQuery;
use \StudentQuery as ChildStudentQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\KumiTableMap;
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
 * Base class that represents a row from the 'classes' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Kumi implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\KumiTableMap';


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
     * The value for the year field.
     * @var        int
     */
    protected $year;

    /**
     * The value for the nickname field.
     * @var        string
     */
    protected $nickname;

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
     * @var        ObjectCollection|ChildStudentClassAssignment[] Collection to store aggregation of ChildStudentClassAssignment objects.
     */
    protected $collStudentClassAssignments;
    protected $collStudentClassAssignmentsPartial;

    /**
     * @var        ObjectCollection|ChildExamClassAssignment[] Collection to store aggregation of ChildExamClassAssignment objects.
     */
    protected $collExamClassAssignments;
    protected $collExamClassAssignmentsPartial;

    /**
     * @var        ObjectCollection|ChildStudent[] Cross Collection to store aggregation of ChildStudent objects.
     */
    protected $collStudents;

    /**
     * @var bool
     */
    protected $collStudentsPartial;

    /**
     * @var        ObjectCollection|ChildExam[] Cross Collection to store aggregation of ChildExam objects.
     */
    protected $collExams;

    /**
     * @var bool
     */
    protected $collExamsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStudent[]
     */
    protected $studentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExam[]
     */
    protected $examsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildStudentClassAssignment[]
     */
    protected $studentClassAssignmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildExamClassAssignment[]
     */
    protected $examClassAssignmentsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Kumi object.
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
     * Compares this with another <code>Kumi</code> instance.  If
     * <code>obj</code> is an instance of <code>Kumi</code>, delegates to
     * <code>equals(Kumi)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Kumi The current object, for fluid interface
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
     * Get the [year] column value.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Get the [nickname] column value.
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
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
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[KumiTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [year] column.
     *
     * @param int $v new value
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function setYear($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->year !== $v) {
            $this->year = $v;
            $this->modifiedColumns[KumiTableMap::COL_YEAR] = true;
        }

        return $this;
    } // setYear()

    /**
     * Set the value of [nickname] column.
     *
     * @param string $v new value
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function setNickname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nickname !== $v) {
            $this->nickname = $v;
            $this->modifiedColumns[KumiTableMap::COL_NICKNAME] = true;
        }

        return $this;
    } // setNickname()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[KumiTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[KumiTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : KumiTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : KumiTableMap::translateFieldName('Year', TableMap::TYPE_PHPNAME, $indexType)];
            $this->year = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : KumiTableMap::translateFieldName('Nickname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nickname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : KumiTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : KumiTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = KumiTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Kumi'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(KumiTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildKumiQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collStudentClassAssignments = null;

            $this->collExamClassAssignments = null;

            $this->collStudents = null;
            $this->collExams = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Kumi::setDeleted()
     * @see Kumi::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(KumiTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildKumiQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(KumiTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(KumiTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(KumiTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(KumiTableMap::COL_UPDATED_AT)) {
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
                KumiTableMap::addInstanceToPool($this);
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

            if ($this->studentsScheduledForDeletion !== null) {
                if (!$this->studentsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->studentsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[1] = $this->getId();
                        $entryPk[0] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \StudentClassAssignmentQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->studentsScheduledForDeletion = null;
                }

            }

            if ($this->collStudents) {
                foreach ($this->collStudents as $student) {
                    if (!$student->isDeleted() && ($student->isNew() || $student->isModified())) {
                        $student->save($con);
                    }
                }
            }


            if ($this->examsScheduledForDeletion !== null) {
                if (!$this->examsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->examsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \ExamClassAssignmentQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->examsScheduledForDeletion = null;
                }

            }

            if ($this->collExams) {
                foreach ($this->collExams as $exam) {
                    if (!$exam->isDeleted() && ($exam->isNew() || $exam->isModified())) {
                        $exam->save($con);
                    }
                }
            }


            if ($this->studentClassAssignmentsScheduledForDeletion !== null) {
                if (!$this->studentClassAssignmentsScheduledForDeletion->isEmpty()) {
                    \StudentClassAssignmentQuery::create()
                        ->filterByPrimaryKeys($this->studentClassAssignmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studentClassAssignmentsScheduledForDeletion = null;
                }
            }

            if ($this->collStudentClassAssignments !== null) {
                foreach ($this->collStudentClassAssignments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->examClassAssignmentsScheduledForDeletion !== null) {
                if (!$this->examClassAssignmentsScheduledForDeletion->isEmpty()) {
                    \ExamClassAssignmentQuery::create()
                        ->filterByPrimaryKeys($this->examClassAssignmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->examClassAssignmentsScheduledForDeletion = null;
                }
            }

            if ($this->collExamClassAssignments !== null) {
                foreach ($this->collExamClassAssignments as $referrerFK) {
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

        $this->modifiedColumns[KumiTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . KumiTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(KumiTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(KumiTableMap::COL_YEAR)) {
            $modifiedColumns[':p' . $index++]  = 'year';
        }
        if ($this->isColumnModified(KumiTableMap::COL_NICKNAME)) {
            $modifiedColumns[':p' . $index++]  = 'nickname';
        }
        if ($this->isColumnModified(KumiTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(KumiTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO classes (%s) VALUES (%s)',
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
                    case 'year':
                        $stmt->bindValue($identifier, $this->year, PDO::PARAM_INT);
                        break;
                    case 'nickname':
                        $stmt->bindValue($identifier, $this->nickname, PDO::PARAM_STR);
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
        $pos = KumiTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getYear();
                break;
            case 2:
                return $this->getNickname();
                break;
            case 3:
                return $this->getCreatedAt();
                break;
            case 4:
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

        if (isset($alreadyDumpedObjects['Kumi'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Kumi'][$this->hashCode()] = true;
        $keys = KumiTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getYear(),
            $keys[2] => $this->getNickname(),
            $keys[3] => $this->getCreatedAt(),
            $keys[4] => $this->getUpdatedAt(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[3]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[3]];
            $result[$keys[3]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collStudentClassAssignments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'studentClassAssignments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'studentsXclassess';
                        break;
                    default:
                        $key = 'StudentClassAssignments';
                }

                $result[$key] = $this->collStudentClassAssignments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collExamClassAssignments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'examClassAssignments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'examsXclassess';
                        break;
                    default:
                        $key = 'ExamClassAssignments';
                }

                $result[$key] = $this->collExamClassAssignments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Kumi
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = KumiTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Kumi
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setYear($value);
                break;
            case 2:
                $this->setNickname($value);
                break;
            case 3:
                $this->setCreatedAt($value);
                break;
            case 4:
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
        $keys = KumiTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setYear($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNickname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatedAt($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setUpdatedAt($arr[$keys[4]]);
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
     * @return $this|\Kumi The current object, for fluid interface
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
        $criteria = new Criteria(KumiTableMap::DATABASE_NAME);

        if ($this->isColumnModified(KumiTableMap::COL_ID)) {
            $criteria->add(KumiTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(KumiTableMap::COL_YEAR)) {
            $criteria->add(KumiTableMap::COL_YEAR, $this->year);
        }
        if ($this->isColumnModified(KumiTableMap::COL_NICKNAME)) {
            $criteria->add(KumiTableMap::COL_NICKNAME, $this->nickname);
        }
        if ($this->isColumnModified(KumiTableMap::COL_CREATED_AT)) {
            $criteria->add(KumiTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(KumiTableMap::COL_UPDATED_AT)) {
            $criteria->add(KumiTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildKumiQuery::create();
        $criteria->add(KumiTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Kumi (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setYear($this->getYear());
        $copyObj->setNickname($this->getNickname());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getStudentClassAssignments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudentClassAssignment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getExamClassAssignments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExamClassAssignment($relObj->copy($deepCopy));
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
     * @return \Kumi Clone of current object.
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
        if ('StudentClassAssignment' == $relationName) {
            return $this->initStudentClassAssignments();
        }
        if ('ExamClassAssignment' == $relationName) {
            return $this->initExamClassAssignments();
        }
    }

    /**
     * Clears out the collStudentClassAssignments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addStudentClassAssignments()
     */
    public function clearStudentClassAssignments()
    {
        $this->collStudentClassAssignments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collStudentClassAssignments collection loaded partially.
     */
    public function resetPartialStudentClassAssignments($v = true)
    {
        $this->collStudentClassAssignmentsPartial = $v;
    }

    /**
     * Initializes the collStudentClassAssignments collection.
     *
     * By default this just sets the collStudentClassAssignments collection to an empty array (like clearcollStudentClassAssignments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudentClassAssignments($overrideExisting = true)
    {
        if (null !== $this->collStudentClassAssignments && !$overrideExisting) {
            return;
        }
        $this->collStudentClassAssignments = new ObjectCollection();
        $this->collStudentClassAssignments->setModel('\StudentClassAssignment');
    }

    /**
     * Gets an array of ChildStudentClassAssignment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildKumi is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildStudentClassAssignment[] List of ChildStudentClassAssignment objects
     * @throws PropelException
     */
    public function getStudentClassAssignments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentClassAssignmentsPartial && !$this->isNew();
        if (null === $this->collStudentClassAssignments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudentClassAssignments) {
                // return empty collection
                $this->initStudentClassAssignments();
            } else {
                $collStudentClassAssignments = ChildStudentClassAssignmentQuery::create(null, $criteria)
                    ->filterByKumi($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collStudentClassAssignmentsPartial && count($collStudentClassAssignments)) {
                        $this->initStudentClassAssignments(false);

                        foreach ($collStudentClassAssignments as $obj) {
                            if (false == $this->collStudentClassAssignments->contains($obj)) {
                                $this->collStudentClassAssignments->append($obj);
                            }
                        }

                        $this->collStudentClassAssignmentsPartial = true;
                    }

                    return $collStudentClassAssignments;
                }

                if ($partial && $this->collStudentClassAssignments) {
                    foreach ($this->collStudentClassAssignments as $obj) {
                        if ($obj->isNew()) {
                            $collStudentClassAssignments[] = $obj;
                        }
                    }
                }

                $this->collStudentClassAssignments = $collStudentClassAssignments;
                $this->collStudentClassAssignmentsPartial = false;
            }
        }

        return $this->collStudentClassAssignments;
    }

    /**
     * Sets a collection of ChildStudentClassAssignment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $studentClassAssignments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildKumi The current object (for fluent API support)
     */
    public function setStudentClassAssignments(Collection $studentClassAssignments, ConnectionInterface $con = null)
    {
        /** @var ChildStudentClassAssignment[] $studentClassAssignmentsToDelete */
        $studentClassAssignmentsToDelete = $this->getStudentClassAssignments(new Criteria(), $con)->diff($studentClassAssignments);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->studentClassAssignmentsScheduledForDeletion = clone $studentClassAssignmentsToDelete;

        foreach ($studentClassAssignmentsToDelete as $studentClassAssignmentRemoved) {
            $studentClassAssignmentRemoved->setKumi(null);
        }

        $this->collStudentClassAssignments = null;
        foreach ($studentClassAssignments as $studentClassAssignment) {
            $this->addStudentClassAssignment($studentClassAssignment);
        }

        $this->collStudentClassAssignments = $studentClassAssignments;
        $this->collStudentClassAssignmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StudentClassAssignment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related StudentClassAssignment objects.
     * @throws PropelException
     */
    public function countStudentClassAssignments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentClassAssignmentsPartial && !$this->isNew();
        if (null === $this->collStudentClassAssignments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudentClassAssignments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStudentClassAssignments());
            }

            $query = ChildStudentClassAssignmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByKumi($this)
                ->count($con);
        }

        return count($this->collStudentClassAssignments);
    }

    /**
     * Method called to associate a ChildStudentClassAssignment object to this object
     * through the ChildStudentClassAssignment foreign key attribute.
     *
     * @param  ChildStudentClassAssignment $l ChildStudentClassAssignment
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function addStudentClassAssignment(ChildStudentClassAssignment $l)
    {
        if ($this->collStudentClassAssignments === null) {
            $this->initStudentClassAssignments();
            $this->collStudentClassAssignmentsPartial = true;
        }

        if (!$this->collStudentClassAssignments->contains($l)) {
            $this->doAddStudentClassAssignment($l);
        }

        return $this;
    }

    /**
     * @param ChildStudentClassAssignment $studentClassAssignment The ChildStudentClassAssignment object to add.
     */
    protected function doAddStudentClassAssignment(ChildStudentClassAssignment $studentClassAssignment)
    {
        $this->collStudentClassAssignments[]= $studentClassAssignment;
        $studentClassAssignment->setKumi($this);
    }

    /**
     * @param  ChildStudentClassAssignment $studentClassAssignment The ChildStudentClassAssignment object to remove.
     * @return $this|ChildKumi The current object (for fluent API support)
     */
    public function removeStudentClassAssignment(ChildStudentClassAssignment $studentClassAssignment)
    {
        if ($this->getStudentClassAssignments()->contains($studentClassAssignment)) {
            $pos = $this->collStudentClassAssignments->search($studentClassAssignment);
            $this->collStudentClassAssignments->remove($pos);
            if (null === $this->studentClassAssignmentsScheduledForDeletion) {
                $this->studentClassAssignmentsScheduledForDeletion = clone $this->collStudentClassAssignments;
                $this->studentClassAssignmentsScheduledForDeletion->clear();
            }
            $this->studentClassAssignmentsScheduledForDeletion[]= clone $studentClassAssignment;
            $studentClassAssignment->setKumi(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Kumi is new, it will return
     * an empty collection; or if this Kumi has previously
     * been saved, it will retrieve related StudentClassAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Kumi.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildStudentClassAssignment[] List of ChildStudentClassAssignment objects
     */
    public function getStudentClassAssignmentsJoinStudent(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildStudentClassAssignmentQuery::create(null, $criteria);
        $query->joinWith('Student', $joinBehavior);

        return $this->getStudentClassAssignments($query, $con);
    }

    /**
     * Clears out the collExamClassAssignments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExamClassAssignments()
     */
    public function clearExamClassAssignments()
    {
        $this->collExamClassAssignments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collExamClassAssignments collection loaded partially.
     */
    public function resetPartialExamClassAssignments($v = true)
    {
        $this->collExamClassAssignmentsPartial = $v;
    }

    /**
     * Initializes the collExamClassAssignments collection.
     *
     * By default this just sets the collExamClassAssignments collection to an empty array (like clearcollExamClassAssignments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExamClassAssignments($overrideExisting = true)
    {
        if (null !== $this->collExamClassAssignments && !$overrideExisting) {
            return;
        }
        $this->collExamClassAssignments = new ObjectCollection();
        $this->collExamClassAssignments->setModel('\ExamClassAssignment');
    }

    /**
     * Gets an array of ChildExamClassAssignment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildKumi is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExamClassAssignment[] List of ChildExamClassAssignment objects
     * @throws PropelException
     */
    public function getExamClassAssignments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExamClassAssignmentsPartial && !$this->isNew();
        if (null === $this->collExamClassAssignments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExamClassAssignments) {
                // return empty collection
                $this->initExamClassAssignments();
            } else {
                $collExamClassAssignments = ChildExamClassAssignmentQuery::create(null, $criteria)
                    ->filterByKumi($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collExamClassAssignmentsPartial && count($collExamClassAssignments)) {
                        $this->initExamClassAssignments(false);

                        foreach ($collExamClassAssignments as $obj) {
                            if (false == $this->collExamClassAssignments->contains($obj)) {
                                $this->collExamClassAssignments->append($obj);
                            }
                        }

                        $this->collExamClassAssignmentsPartial = true;
                    }

                    return $collExamClassAssignments;
                }

                if ($partial && $this->collExamClassAssignments) {
                    foreach ($this->collExamClassAssignments as $obj) {
                        if ($obj->isNew()) {
                            $collExamClassAssignments[] = $obj;
                        }
                    }
                }

                $this->collExamClassAssignments = $collExamClassAssignments;
                $this->collExamClassAssignmentsPartial = false;
            }
        }

        return $this->collExamClassAssignments;
    }

    /**
     * Sets a collection of ChildExamClassAssignment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $examClassAssignments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildKumi The current object (for fluent API support)
     */
    public function setExamClassAssignments(Collection $examClassAssignments, ConnectionInterface $con = null)
    {
        /** @var ChildExamClassAssignment[] $examClassAssignmentsToDelete */
        $examClassAssignmentsToDelete = $this->getExamClassAssignments(new Criteria(), $con)->diff($examClassAssignments);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->examClassAssignmentsScheduledForDeletion = clone $examClassAssignmentsToDelete;

        foreach ($examClassAssignmentsToDelete as $examClassAssignmentRemoved) {
            $examClassAssignmentRemoved->setKumi(null);
        }

        $this->collExamClassAssignments = null;
        foreach ($examClassAssignments as $examClassAssignment) {
            $this->addExamClassAssignment($examClassAssignment);
        }

        $this->collExamClassAssignments = $examClassAssignments;
        $this->collExamClassAssignmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ExamClassAssignment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ExamClassAssignment objects.
     * @throws PropelException
     */
    public function countExamClassAssignments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExamClassAssignmentsPartial && !$this->isNew();
        if (null === $this->collExamClassAssignments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExamClassAssignments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getExamClassAssignments());
            }

            $query = ChildExamClassAssignmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByKumi($this)
                ->count($con);
        }

        return count($this->collExamClassAssignments);
    }

    /**
     * Method called to associate a ChildExamClassAssignment object to this object
     * through the ChildExamClassAssignment foreign key attribute.
     *
     * @param  ChildExamClassAssignment $l ChildExamClassAssignment
     * @return $this|\Kumi The current object (for fluent API support)
     */
    public function addExamClassAssignment(ChildExamClassAssignment $l)
    {
        if ($this->collExamClassAssignments === null) {
            $this->initExamClassAssignments();
            $this->collExamClassAssignmentsPartial = true;
        }

        if (!$this->collExamClassAssignments->contains($l)) {
            $this->doAddExamClassAssignment($l);
        }

        return $this;
    }

    /**
     * @param ChildExamClassAssignment $examClassAssignment The ChildExamClassAssignment object to add.
     */
    protected function doAddExamClassAssignment(ChildExamClassAssignment $examClassAssignment)
    {
        $this->collExamClassAssignments[]= $examClassAssignment;
        $examClassAssignment->setKumi($this);
    }

    /**
     * @param  ChildExamClassAssignment $examClassAssignment The ChildExamClassAssignment object to remove.
     * @return $this|ChildKumi The current object (for fluent API support)
     */
    public function removeExamClassAssignment(ChildExamClassAssignment $examClassAssignment)
    {
        if ($this->getExamClassAssignments()->contains($examClassAssignment)) {
            $pos = $this->collExamClassAssignments->search($examClassAssignment);
            $this->collExamClassAssignments->remove($pos);
            if (null === $this->examClassAssignmentsScheduledForDeletion) {
                $this->examClassAssignmentsScheduledForDeletion = clone $this->collExamClassAssignments;
                $this->examClassAssignmentsScheduledForDeletion->clear();
            }
            $this->examClassAssignmentsScheduledForDeletion[]= clone $examClassAssignment;
            $examClassAssignment->setKumi(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Kumi is new, it will return
     * an empty collection; or if this Kumi has previously
     * been saved, it will retrieve related ExamClassAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Kumi.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamClassAssignment[] List of ChildExamClassAssignment objects
     */
    public function getExamClassAssignmentsJoinExam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildExamClassAssignmentQuery::create(null, $criteria);
        $query->joinWith('Exam', $joinBehavior);

        return $this->getExamClassAssignments($query, $con);
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
     * Initializes the collStudents crossRef collection.
     *
     * By default this just sets the collStudents collection to an empty collection (like clearStudents());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initStudents()
    {
        $this->collStudents = new ObjectCollection();
        $this->collStudentsPartial = true;

        $this->collStudents->setModel('\Student');
    }

    /**
     * Checks if the collStudents collection is loaded.
     *
     * @return bool
     */
    public function isStudentsLoaded()
    {
        return null !== $this->collStudents;
    }

    /**
     * Gets a collection of ChildStudent objects related by a many-to-many relationship
     * to the current object by way of the studentsXclasses cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildKumi is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildStudent[] List of ChildStudent objects
     */
    public function getStudents(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentsPartial && !$this->isNew();
        if (null === $this->collStudents || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collStudents) {
                    $this->initStudents();
                }
            } else {

                $query = ChildStudentQuery::create(null, $criteria)
                    ->filterByKumi($this);
                $collStudents = $query->find($con);
                if (null !== $criteria) {
                    return $collStudents;
                }

                if ($partial && $this->collStudents) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collStudents as $obj) {
                        if (!$collStudents->contains($obj)) {
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
     * Sets a collection of Student objects related by a many-to-many relationship
     * to the current object by way of the studentsXclasses cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $students A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildKumi The current object (for fluent API support)
     */
    public function setStudents(Collection $students, ConnectionInterface $con = null)
    {
        $this->clearStudents();
        $currentStudents = $this->getStudents();

        $studentsScheduledForDeletion = $currentStudents->diff($students);

        foreach ($studentsScheduledForDeletion as $toDelete) {
            $this->removeStudent($toDelete);
        }

        foreach ($students as $student) {
            if (!$currentStudents->contains($student)) {
                $this->doAddStudent($student);
            }
        }

        $this->collStudentsPartial = false;
        $this->collStudents = $students;

        return $this;
    }

    /**
     * Gets the number of Student objects related by a many-to-many relationship
     * to the current object by way of the studentsXclasses cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Student objects
     */
    public function countStudents(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collStudentsPartial && !$this->isNew();
        if (null === $this->collStudents || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudents) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getStudents());
                }

                $query = ChildStudentQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByKumi($this)
                    ->count($con);
            }
        } else {
            return count($this->collStudents);
        }
    }

    /**
     * Associate a ChildStudent to this object
     * through the studentsXclasses cross reference table.
     *
     * @param ChildStudent $student
     * @return ChildKumi The current object (for fluent API support)
     */
    public function addStudent(ChildStudent $student)
    {
        if ($this->collStudents === null) {
            $this->initStudents();
        }

        if (!$this->getStudents()->contains($student)) {
            // only add it if the **same** object is not already associated
            $this->collStudents->push($student);
            $this->doAddStudent($student);
        }

        return $this;
    }

    /**
     *
     * @param ChildStudent $student
     */
    protected function doAddStudent(ChildStudent $student)
    {
        $studentClassAssignment = new ChildStudentClassAssignment();

        $studentClassAssignment->setStudent($student);

        $studentClassAssignment->setKumi($this);

        $this->addStudentClassAssignment($studentClassAssignment);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$student->isKumisLoaded()) {
            $student->initKumis();
            $student->getKumis()->push($this);
        } elseif (!$student->getKumis()->contains($this)) {
            $student->getKumis()->push($this);
        }

    }

    /**
     * Remove student of this object
     * through the studentsXclasses cross reference table.
     *
     * @param ChildStudent $student
     * @return ChildKumi The current object (for fluent API support)
     */
    public function removeStudent(ChildStudent $student)
    {
        if ($this->getStudents()->contains($student)) { $studentClassAssignment = new ChildStudentClassAssignment();

            $studentClassAssignment->setStudent($student);
            if ($student->isKumisLoaded()) {
                //remove the back reference if available
                $student->getKumis()->removeObject($this);
            }

            $studentClassAssignment->setKumi($this);
            $this->removeStudentClassAssignment(clone $studentClassAssignment);
            $studentClassAssignment->clear();

            $this->collStudents->remove($this->collStudents->search($student));

            if (null === $this->studentsScheduledForDeletion) {
                $this->studentsScheduledForDeletion = clone $this->collStudents;
                $this->studentsScheduledForDeletion->clear();
            }

            $this->studentsScheduledForDeletion->push($student);
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
     * Initializes the collExams crossRef collection.
     *
     * By default this just sets the collExams collection to an empty collection (like clearExams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initExams()
    {
        $this->collExams = new ObjectCollection();
        $this->collExamsPartial = true;

        $this->collExams->setModel('\Exam');
    }

    /**
     * Checks if the collExams collection is loaded.
     *
     * @return bool
     */
    public function isExamsLoaded()
    {
        return null !== $this->collExams;
    }

    /**
     * Gets a collection of ChildExam objects related by a many-to-many relationship
     * to the current object by way of the examsXclasses cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildKumi is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildExam[] List of ChildExam objects
     */
    public function getExams(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collExamsPartial && !$this->isNew();
        if (null === $this->collExams || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collExams) {
                    $this->initExams();
                }
            } else {

                $query = ChildExamQuery::create(null, $criteria)
                    ->filterByKumi($this);
                $collExams = $query->find($con);
                if (null !== $criteria) {
                    return $collExams;
                }

                if ($partial && $this->collExams) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collExams as $obj) {
                        if (!$collExams->contains($obj)) {
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
     * Sets a collection of Exam objects related by a many-to-many relationship
     * to the current object by way of the examsXclasses cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $exams A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildKumi The current object (for fluent API support)
     */
    public function setExams(Collection $exams, ConnectionInterface $con = null)
    {
        $this->clearExams();
        $currentExams = $this->getExams();

        $examsScheduledForDeletion = $currentExams->diff($exams);

        foreach ($examsScheduledForDeletion as $toDelete) {
            $this->removeExam($toDelete);
        }

        foreach ($exams as $exam) {
            if (!$currentExams->contains($exam)) {
                $this->doAddExam($exam);
            }
        }

        $this->collExamsPartial = false;
        $this->collExams = $exams;

        return $this;
    }

    /**
     * Gets the number of Exam objects related by a many-to-many relationship
     * to the current object by way of the examsXclasses cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Exam objects
     */
    public function countExams(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collExamsPartial && !$this->isNew();
        if (null === $this->collExams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExams) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getExams());
                }

                $query = ChildExamQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByKumi($this)
                    ->count($con);
            }
        } else {
            return count($this->collExams);
        }
    }

    /**
     * Associate a ChildExam to this object
     * through the examsXclasses cross reference table.
     *
     * @param ChildExam $exam
     * @return ChildKumi The current object (for fluent API support)
     */
    public function addExam(ChildExam $exam)
    {
        if ($this->collExams === null) {
            $this->initExams();
        }

        if (!$this->getExams()->contains($exam)) {
            // only add it if the **same** object is not already associated
            $this->collExams->push($exam);
            $this->doAddExam($exam);
        }

        return $this;
    }

    /**
     *
     * @param ChildExam $exam
     */
    protected function doAddExam(ChildExam $exam)
    {
        $examClassAssignment = new ChildExamClassAssignment();

        $examClassAssignment->setExam($exam);

        $examClassAssignment->setKumi($this);

        $this->addExamClassAssignment($examClassAssignment);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$exam->isKumisLoaded()) {
            $exam->initKumis();
            $exam->getKumis()->push($this);
        } elseif (!$exam->getKumis()->contains($this)) {
            $exam->getKumis()->push($this);
        }

    }

    /**
     * Remove exam of this object
     * through the examsXclasses cross reference table.
     *
     * @param ChildExam $exam
     * @return ChildKumi The current object (for fluent API support)
     */
    public function removeExam(ChildExam $exam)
    {
        if ($this->getExams()->contains($exam)) { $examClassAssignment = new ChildExamClassAssignment();

            $examClassAssignment->setExam($exam);
            if ($exam->isKumisLoaded()) {
                //remove the back reference if available
                $exam->getKumis()->removeObject($this);
            }

            $examClassAssignment->setKumi($this);
            $this->removeExamClassAssignment(clone $examClassAssignment);
            $examClassAssignment->clear();

            $this->collExams->remove($this->collExams->search($exam));

            if (null === $this->examsScheduledForDeletion) {
                $this->examsScheduledForDeletion = clone $this->collExams;
                $this->examsScheduledForDeletion->clear();
            }

            $this->examsScheduledForDeletion->push($exam);
        }


        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->year = null;
        $this->nickname = null;
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
            if ($this->collStudentClassAssignments) {
                foreach ($this->collStudentClassAssignments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExamClassAssignments) {
                foreach ($this->collExamClassAssignments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudents) {
                foreach ($this->collStudents as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collExams) {
                foreach ($this->collExams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collStudentClassAssignments = null;
        $this->collExamClassAssignments = null;
        $this->collStudents = null;
        $this->collExams = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(KumiTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildKumi The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[KumiTableMap::COL_UPDATED_AT] = true;

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
