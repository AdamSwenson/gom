<?php

namespace Base;

use \Element as ChildElement;
use \ElementQuery as ChildElementQuery;
use \Question as ChildQuestion;
use \QuestionQuery as ChildQuestionQuery;
use \Tag as ChildTag;
use \TagQuery as ChildTagQuery;
use \TaggedElement as ChildTaggedElement;
use \TaggedElementQuery as ChildTaggedElementQuery;
use \TaggedQuestion as ChildTaggedQuestion;
use \TaggedQuestionQuery as ChildTaggedQuestionQuery;
use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\TagTableMap;
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
 * Base class that represents a row from the 'tags' table.
 *
 *
 *
* @package    propel.generator..Base
*/
abstract class Tag implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\TagTableMap';


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
     * The value for the tag field.
     * @var        string
     */
    protected $tag;

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
     * @var        ObjectCollection|ChildTaggedQuestion[] Collection to store aggregation of ChildTaggedQuestion objects.
     */
    protected $collTaggedQuestions;
    protected $collTaggedQuestionsPartial;

    /**
     * @var        ObjectCollection|ChildTaggedElement[] Collection to store aggregation of ChildTaggedElement objects.
     */
    protected $collTaggedElements;
    protected $collTaggedElementsPartial;

    /**
     * @var        ObjectCollection|ChildQuestion[] Cross Collection to store aggregation of ChildQuestion objects.
     */
    protected $collQuestions;

    /**
     * @var bool
     */
    protected $collQuestionsPartial;

    /**
     * @var        ObjectCollection|ChildElement[] Cross Collection to store aggregation of ChildElement objects.
     */
    protected $collElements;

    /**
     * @var bool
     */
    protected $collElementsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

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
     * @var ObjectCollection|ChildTaggedQuestion[]
     */
    protected $taggedQuestionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTaggedElement[]
     */
    protected $taggedElementsScheduledForDeletion = null;

    /**
     * Initializes internal state of Base\Tag object.
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
     * Compares this with another <code>Tag</code> instance.  If
     * <code>obj</code> is an instance of <code>Tag</code>, delegates to
     * <code>equals(Tag)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Tag The current object, for fluid interface
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
     * Get the [tag] column value.
     *
     * @return string
     */
    public function getTag()
    {
        return $this->tag;
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
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[TagTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [tag] column.
     *
     * @param string $v new value
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function setTag($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->tag !== $v) {
            $this->tag = $v;
            $this->modifiedColumns[TagTableMap::COL_TAG] = true;
        }

        return $this;
    } // setTag()

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function setUserId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->user_id !== $v) {
            $this->user_id = $v;
            $this->modifiedColumns[TagTableMap::COL_USER_ID] = true;
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
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TagTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            if ($this->updated_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->updated_at->format("Y-m-d H:i:s")) {
                $this->updated_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TagTableMap::COL_UPDATED_AT] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TagTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TagTableMap::translateFieldName('Tag', TableMap::TYPE_PHPNAME, $indexType)];
            $this->tag = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TagTableMap::translateFieldName('UserId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->user_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TagTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TagTableMap::translateFieldName('UpdatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->updated_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = TagTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Tag'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(TagTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTagQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUser = null;
            $this->collTaggedQuestions = null;

            $this->collTaggedElements = null;

            $this->collQuestions = null;
            $this->collElements = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Tag::setDeleted()
     * @see Tag::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTagQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(TagTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior

                if (!$this->isColumnModified(TagTableMap::COL_CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(TagTableMap::COL_UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(TagTableMap::COL_UPDATED_AT)) {
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
                TagTableMap::addInstanceToPool($this);
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

            if ($this->questionsScheduledForDeletion !== null) {
                if (!$this->questionsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->questionsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \TaggedQuestionQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->questionsScheduledForDeletion = null;
                }

            }

            if ($this->collQuestions) {
                foreach ($this->collQuestions as $question) {
                    if (!$question->isDeleted() && ($question->isNew() || $question->isModified())) {
                        $question->save($con);
                    }
                }
            }


            if ($this->elementsScheduledForDeletion !== null) {
                if (!$this->elementsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    foreach ($this->elementsScheduledForDeletion as $entry) {
                        $entryPk = [];

                        $entryPk[0] = $this->getId();
                        $entryPk[1] = $entry->getId();
                        $pks[] = $entryPk;
                    }

                    \TaggedElementQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);

                    $this->elementsScheduledForDeletion = null;
                }

            }

            if ($this->collElements) {
                foreach ($this->collElements as $element) {
                    if (!$element->isDeleted() && ($element->isNew() || $element->isModified())) {
                        $element->save($con);
                    }
                }
            }


            if ($this->taggedQuestionsScheduledForDeletion !== null) {
                if (!$this->taggedQuestionsScheduledForDeletion->isEmpty()) {
                    \TaggedQuestionQuery::create()
                        ->filterByPrimaryKeys($this->taggedQuestionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->taggedQuestionsScheduledForDeletion = null;
                }
            }

            if ($this->collTaggedQuestions !== null) {
                foreach ($this->collTaggedQuestions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->taggedElementsScheduledForDeletion !== null) {
                if (!$this->taggedElementsScheduledForDeletion->isEmpty()) {
                    \TaggedElementQuery::create()
                        ->filterByPrimaryKeys($this->taggedElementsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->taggedElementsScheduledForDeletion = null;
                }
            }

            if ($this->collTaggedElements !== null) {
                foreach ($this->collTaggedElements as $referrerFK) {
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

        $this->modifiedColumns[TagTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TagTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TagTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(TagTableMap::COL_TAG)) {
            $modifiedColumns[':p' . $index++]  = 'tag';
        }
        if ($this->isColumnModified(TagTableMap::COL_USER_ID)) {
            $modifiedColumns[':p' . $index++]  = 'user_id';
        }
        if ($this->isColumnModified(TagTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(TagTableMap::COL_UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'updated_at';
        }

        $sql = sprintf(
            'INSERT INTO tags (%s) VALUES (%s)',
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
                    case 'tag':
                        $stmt->bindValue($identifier, $this->tag, PDO::PARAM_STR);
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
        $pos = TagTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTag();
                break;
            case 2:
                return $this->getUserId();
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

        if (isset($alreadyDumpedObjects['Tag'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Tag'][$this->hashCode()] = true;
        $keys = TagTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTag(),
            $keys[2] => $this->getUserId(),
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
            if (null !== $this->collTaggedQuestions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'taggedQuestions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'tagsXquestionss';
                        break;
                    default:
                        $key = 'TaggedQuestions';
                }

                $result[$key] = $this->collTaggedQuestions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTaggedElements) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'taggedElements';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'tagsXelementss';
                        break;
                    default:
                        $key = 'TaggedElements';
                }

                $result[$key] = $this->collTaggedElements->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Tag
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TagTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Tag
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTag($value);
                break;
            case 2:
                $this->setUserId($value);
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
        $keys = TagTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTag($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setUserId($arr[$keys[2]]);
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
     * @return $this|\Tag The current object, for fluid interface
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
        $criteria = new Criteria(TagTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TagTableMap::COL_ID)) {
            $criteria->add(TagTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(TagTableMap::COL_TAG)) {
            $criteria->add(TagTableMap::COL_TAG, $this->tag);
        }
        if ($this->isColumnModified(TagTableMap::COL_USER_ID)) {
            $criteria->add(TagTableMap::COL_USER_ID, $this->user_id);
        }
        if ($this->isColumnModified(TagTableMap::COL_CREATED_AT)) {
            $criteria->add(TagTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TagTableMap::COL_UPDATED_AT)) {
            $criteria->add(TagTableMap::COL_UPDATED_AT, $this->updated_at);
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
        $criteria = ChildTagQuery::create();
        $criteria->add(TagTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Tag (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTag($this->getTag());
        $copyObj->setUserId($this->getUserId());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTaggedQuestions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTaggedQuestion($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTaggedElements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTaggedElement($relObj->copy($deepCopy));
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
     * @return \Tag Clone of current object.
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
     * @return $this|\Tag The current object (for fluent API support)
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
            $v->addTag($this);
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
                $this->aUser->addTags($this);
             */
        }

        return $this->aUser;
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
        if ('TaggedQuestion' == $relationName) {
            return $this->initTaggedQuestions();
        }
        if ('TaggedElement' == $relationName) {
            return $this->initTaggedElements();
        }
    }

    /**
     * Clears out the collTaggedQuestions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTaggedQuestions()
     */
    public function clearTaggedQuestions()
    {
        $this->collTaggedQuestions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTaggedQuestions collection loaded partially.
     */
    public function resetPartialTaggedQuestions($v = true)
    {
        $this->collTaggedQuestionsPartial = $v;
    }

    /**
     * Initializes the collTaggedQuestions collection.
     *
     * By default this just sets the collTaggedQuestions collection to an empty array (like clearcollTaggedQuestions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTaggedQuestions($overrideExisting = true)
    {
        if (null !== $this->collTaggedQuestions && !$overrideExisting) {
            return;
        }
        $this->collTaggedQuestions = new ObjectCollection();
        $this->collTaggedQuestions->setModel('\TaggedQuestion');
    }

    /**
     * Gets an array of ChildTaggedQuestion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTaggedQuestion[] List of ChildTaggedQuestion objects
     * @throws PropelException
     */
    public function getTaggedQuestions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTaggedQuestionsPartial && !$this->isNew();
        if (null === $this->collTaggedQuestions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTaggedQuestions) {
                // return empty collection
                $this->initTaggedQuestions();
            } else {
                $collTaggedQuestions = ChildTaggedQuestionQuery::create(null, $criteria)
                    ->filterByTag($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTaggedQuestionsPartial && count($collTaggedQuestions)) {
                        $this->initTaggedQuestions(false);

                        foreach ($collTaggedQuestions as $obj) {
                            if (false == $this->collTaggedQuestions->contains($obj)) {
                                $this->collTaggedQuestions->append($obj);
                            }
                        }

                        $this->collTaggedQuestionsPartial = true;
                    }

                    return $collTaggedQuestions;
                }

                if ($partial && $this->collTaggedQuestions) {
                    foreach ($this->collTaggedQuestions as $obj) {
                        if ($obj->isNew()) {
                            $collTaggedQuestions[] = $obj;
                        }
                    }
                }

                $this->collTaggedQuestions = $collTaggedQuestions;
                $this->collTaggedQuestionsPartial = false;
            }
        }

        return $this->collTaggedQuestions;
    }

    /**
     * Sets a collection of ChildTaggedQuestion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $taggedQuestions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTag The current object (for fluent API support)
     */
    public function setTaggedQuestions(Collection $taggedQuestions, ConnectionInterface $con = null)
    {
        /** @var ChildTaggedQuestion[] $taggedQuestionsToDelete */
        $taggedQuestionsToDelete = $this->getTaggedQuestions(new Criteria(), $con)->diff($taggedQuestions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->taggedQuestionsScheduledForDeletion = clone $taggedQuestionsToDelete;

        foreach ($taggedQuestionsToDelete as $taggedQuestionRemoved) {
            $taggedQuestionRemoved->setTag(null);
        }

        $this->collTaggedQuestions = null;
        foreach ($taggedQuestions as $taggedQuestion) {
            $this->addTaggedQuestion($taggedQuestion);
        }

        $this->collTaggedQuestions = $taggedQuestions;
        $this->collTaggedQuestionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TaggedQuestion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TaggedQuestion objects.
     * @throws PropelException
     */
    public function countTaggedQuestions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTaggedQuestionsPartial && !$this->isNew();
        if (null === $this->collTaggedQuestions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTaggedQuestions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTaggedQuestions());
            }

            $query = ChildTaggedQuestionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTag($this)
                ->count($con);
        }

        return count($this->collTaggedQuestions);
    }

    /**
     * Method called to associate a ChildTaggedQuestion object to this object
     * through the ChildTaggedQuestion foreign key attribute.
     *
     * @param  ChildTaggedQuestion $l ChildTaggedQuestion
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function addTaggedQuestion(ChildTaggedQuestion $l)
    {
        if ($this->collTaggedQuestions === null) {
            $this->initTaggedQuestions();
            $this->collTaggedQuestionsPartial = true;
        }

        if (!$this->collTaggedQuestions->contains($l)) {
            $this->doAddTaggedQuestion($l);
        }

        return $this;
    }

    /**
     * @param ChildTaggedQuestion $taggedQuestion The ChildTaggedQuestion object to add.
     */
    protected function doAddTaggedQuestion(ChildTaggedQuestion $taggedQuestion)
    {
        $this->collTaggedQuestions[]= $taggedQuestion;
        $taggedQuestion->setTag($this);
    }

    /**
     * @param  ChildTaggedQuestion $taggedQuestion The ChildTaggedQuestion object to remove.
     * @return $this|ChildTag The current object (for fluent API support)
     */
    public function removeTaggedQuestion(ChildTaggedQuestion $taggedQuestion)
    {
        if ($this->getTaggedQuestions()->contains($taggedQuestion)) {
            $pos = $this->collTaggedQuestions->search($taggedQuestion);
            $this->collTaggedQuestions->remove($pos);
            if (null === $this->taggedQuestionsScheduledForDeletion) {
                $this->taggedQuestionsScheduledForDeletion = clone $this->collTaggedQuestions;
                $this->taggedQuestionsScheduledForDeletion->clear();
            }
            $this->taggedQuestionsScheduledForDeletion[]= clone $taggedQuestion;
            $taggedQuestion->setTag(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tag is new, it will return
     * an empty collection; or if this Tag has previously
     * been saved, it will retrieve related TaggedQuestions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tag.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTaggedQuestion[] List of ChildTaggedQuestion objects
     */
    public function getTaggedQuestionsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTaggedQuestionQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getTaggedQuestions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tag is new, it will return
     * an empty collection; or if this Tag has previously
     * been saved, it will retrieve related TaggedQuestions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tag.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTaggedQuestion[] List of ChildTaggedQuestion objects
     */
    public function getTaggedQuestionsJoinQuestion(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTaggedQuestionQuery::create(null, $criteria);
        $query->joinWith('Question', $joinBehavior);

        return $this->getTaggedQuestions($query, $con);
    }

    /**
     * Clears out the collTaggedElements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTaggedElements()
     */
    public function clearTaggedElements()
    {
        $this->collTaggedElements = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTaggedElements collection loaded partially.
     */
    public function resetPartialTaggedElements($v = true)
    {
        $this->collTaggedElementsPartial = $v;
    }

    /**
     * Initializes the collTaggedElements collection.
     *
     * By default this just sets the collTaggedElements collection to an empty array (like clearcollTaggedElements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTaggedElements($overrideExisting = true)
    {
        if (null !== $this->collTaggedElements && !$overrideExisting) {
            return;
        }
        $this->collTaggedElements = new ObjectCollection();
        $this->collTaggedElements->setModel('\TaggedElement');
    }

    /**
     * Gets an array of ChildTaggedElement objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTaggedElement[] List of ChildTaggedElement objects
     * @throws PropelException
     */
    public function getTaggedElements(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTaggedElementsPartial && !$this->isNew();
        if (null === $this->collTaggedElements || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTaggedElements) {
                // return empty collection
                $this->initTaggedElements();
            } else {
                $collTaggedElements = ChildTaggedElementQuery::create(null, $criteria)
                    ->filterByTag($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTaggedElementsPartial && count($collTaggedElements)) {
                        $this->initTaggedElements(false);

                        foreach ($collTaggedElements as $obj) {
                            if (false == $this->collTaggedElements->contains($obj)) {
                                $this->collTaggedElements->append($obj);
                            }
                        }

                        $this->collTaggedElementsPartial = true;
                    }

                    return $collTaggedElements;
                }

                if ($partial && $this->collTaggedElements) {
                    foreach ($this->collTaggedElements as $obj) {
                        if ($obj->isNew()) {
                            $collTaggedElements[] = $obj;
                        }
                    }
                }

                $this->collTaggedElements = $collTaggedElements;
                $this->collTaggedElementsPartial = false;
            }
        }

        return $this->collTaggedElements;
    }

    /**
     * Sets a collection of ChildTaggedElement objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $taggedElements A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildTag The current object (for fluent API support)
     */
    public function setTaggedElements(Collection $taggedElements, ConnectionInterface $con = null)
    {
        /** @var ChildTaggedElement[] $taggedElementsToDelete */
        $taggedElementsToDelete = $this->getTaggedElements(new Criteria(), $con)->diff($taggedElements);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->taggedElementsScheduledForDeletion = clone $taggedElementsToDelete;

        foreach ($taggedElementsToDelete as $taggedElementRemoved) {
            $taggedElementRemoved->setTag(null);
        }

        $this->collTaggedElements = null;
        foreach ($taggedElements as $taggedElement) {
            $this->addTaggedElement($taggedElement);
        }

        $this->collTaggedElements = $taggedElements;
        $this->collTaggedElementsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TaggedElement objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TaggedElement objects.
     * @throws PropelException
     */
    public function countTaggedElements(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTaggedElementsPartial && !$this->isNew();
        if (null === $this->collTaggedElements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTaggedElements) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTaggedElements());
            }

            $query = ChildTaggedElementQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTag($this)
                ->count($con);
        }

        return count($this->collTaggedElements);
    }

    /**
     * Method called to associate a ChildTaggedElement object to this object
     * through the ChildTaggedElement foreign key attribute.
     *
     * @param  ChildTaggedElement $l ChildTaggedElement
     * @return $this|\Tag The current object (for fluent API support)
     */
    public function addTaggedElement(ChildTaggedElement $l)
    {
        if ($this->collTaggedElements === null) {
            $this->initTaggedElements();
            $this->collTaggedElementsPartial = true;
        }

        if (!$this->collTaggedElements->contains($l)) {
            $this->doAddTaggedElement($l);
        }

        return $this;
    }

    /**
     * @param ChildTaggedElement $taggedElement The ChildTaggedElement object to add.
     */
    protected function doAddTaggedElement(ChildTaggedElement $taggedElement)
    {
        $this->collTaggedElements[]= $taggedElement;
        $taggedElement->setTag($this);
    }

    /**
     * @param  ChildTaggedElement $taggedElement The ChildTaggedElement object to remove.
     * @return $this|ChildTag The current object (for fluent API support)
     */
    public function removeTaggedElement(ChildTaggedElement $taggedElement)
    {
        if ($this->getTaggedElements()->contains($taggedElement)) {
            $pos = $this->collTaggedElements->search($taggedElement);
            $this->collTaggedElements->remove($pos);
            if (null === $this->taggedElementsScheduledForDeletion) {
                $this->taggedElementsScheduledForDeletion = clone $this->collTaggedElements;
                $this->taggedElementsScheduledForDeletion->clear();
            }
            $this->taggedElementsScheduledForDeletion[]= clone $taggedElement;
            $taggedElement->setTag(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tag is new, it will return
     * an empty collection; or if this Tag has previously
     * been saved, it will retrieve related TaggedElements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tag.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTaggedElement[] List of ChildTaggedElement objects
     */
    public function getTaggedElementsJoinUser(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTaggedElementQuery::create(null, $criteria);
        $query->joinWith('User', $joinBehavior);

        return $this->getTaggedElements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tag is new, it will return
     * an empty collection; or if this Tag has previously
     * been saved, it will retrieve related TaggedElements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tag.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTaggedElement[] List of ChildTaggedElement objects
     */
    public function getTaggedElementsJoinElement(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTaggedElementQuery::create(null, $criteria);
        $query->joinWith('Element', $joinBehavior);

        return $this->getTaggedElements($query, $con);
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
     * Initializes the collQuestions crossRef collection.
     *
     * By default this just sets the collQuestions collection to an empty collection (like clearQuestions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initQuestions()
    {
        $this->collQuestions = new ObjectCollection();
        $this->collQuestionsPartial = true;

        $this->collQuestions->setModel('\Question');
    }

    /**
     * Checks if the collQuestions collection is loaded.
     *
     * @return bool
     */
    public function isQuestionsLoaded()
    {
        return null !== $this->collQuestions;
    }

    /**
     * Gets a collection of ChildQuestion objects related by a many-to-many relationship
     * to the current object by way of the tagsXquestions cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildQuestion[] List of ChildQuestion objects
     */
    public function getQuestions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collQuestions) {
                    $this->initQuestions();
                }
            } else {

                $query = ChildQuestionQuery::create(null, $criteria)
                    ->filterByTag($this);
                $collQuestions = $query->find($con);
                if (null !== $criteria) {
                    return $collQuestions;
                }

                if ($partial && $this->collQuestions) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collQuestions as $obj) {
                        if (!$collQuestions->contains($obj)) {
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
     * Sets a collection of Question objects related by a many-to-many relationship
     * to the current object by way of the tagsXquestions cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $questions A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTag The current object (for fluent API support)
     */
    public function setQuestions(Collection $questions, ConnectionInterface $con = null)
    {
        $this->clearQuestions();
        $currentQuestions = $this->getQuestions();

        $questionsScheduledForDeletion = $currentQuestions->diff($questions);

        foreach ($questionsScheduledForDeletion as $toDelete) {
            $this->removeQuestion($toDelete);
        }

        foreach ($questions as $question) {
            if (!$currentQuestions->contains($question)) {
                $this->doAddQuestion($question);
            }
        }

        $this->collQuestionsPartial = false;
        $this->collQuestions = $questions;

        return $this;
    }

    /**
     * Gets the number of Question objects related by a many-to-many relationship
     * to the current object by way of the tagsXquestions cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Question objects
     */
    public function countQuestions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collQuestionsPartial && !$this->isNew();
        if (null === $this->collQuestions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuestions) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getQuestions());
                }

                $query = ChildQuestionQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByTag($this)
                    ->count($con);
            }
        } else {
            return count($this->collQuestions);
        }
    }

    /**
     * Associate a ChildQuestion to this object
     * through the tagsXquestions cross reference table.
     *
     * @param ChildQuestion $question
     * @return ChildTag The current object (for fluent API support)
     */
    public function addQuestion(ChildQuestion $question)
    {
        if ($this->collQuestions === null) {
            $this->initQuestions();
        }

        if (!$this->getQuestions()->contains($question)) {
            // only add it if the **same** object is not already associated
            $this->collQuestions->push($question);
            $this->doAddQuestion($question);
        }

        return $this;
    }

    /**
     *
     * @param ChildQuestion $question
     */
    protected function doAddQuestion(ChildQuestion $question)
    {
        $taggedQuestion = new ChildTaggedQuestion();

        $taggedQuestion->setQuestion($question);

        $taggedQuestion->setTag($this);

        $this->addTaggedQuestion($taggedQuestion);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$question->isTagsLoaded()) {
            $question->initTags();
            $question->getTags()->push($this);
        } elseif (!$question->getTags()->contains($this)) {
            $question->getTags()->push($this);
        }

    }

    /**
     * Remove question of this object
     * through the tagsXquestions cross reference table.
     *
     * @param ChildQuestion $question
     * @return ChildTag The current object (for fluent API support)
     */
    public function removeQuestion(ChildQuestion $question)
    {
        if ($this->getQuestions()->contains($question)) { $taggedQuestion = new ChildTaggedQuestion();

            $taggedQuestion->setQuestion($question);
            if ($question->isTagsLoaded()) {
                //remove the back reference if available
                $question->getTags()->removeObject($this);
            }

            $taggedQuestion->setTag($this);
            $this->removeTaggedQuestion(clone $taggedQuestion);
            $taggedQuestion->clear();

            $this->collQuestions->remove($this->collQuestions->search($question));

            if (null === $this->questionsScheduledForDeletion) {
                $this->questionsScheduledForDeletion = clone $this->collQuestions;
                $this->questionsScheduledForDeletion->clear();
            }

            $this->questionsScheduledForDeletion->push($question);
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
     * Initializes the collElements crossRef collection.
     *
     * By default this just sets the collElements collection to an empty collection (like clearElements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initElements()
    {
        $this->collElements = new ObjectCollection();
        $this->collElementsPartial = true;

        $this->collElements->setModel('\Element');
    }

    /**
     * Checks if the collElements collection is loaded.
     *
     * @return bool
     */
    public function isElementsLoaded()
    {
        return null !== $this->collElements;
    }

    /**
     * Gets a collection of ChildElement objects related by a many-to-many relationship
     * to the current object by way of the tagsXelements cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildTag is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return ObjectCollection|ChildElement[] List of ChildElement objects
     */
    public function getElements(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria || $partial) {
            if ($this->isNew()) {
                // return empty collection
                if (null === $this->collElements) {
                    $this->initElements();
                }
            } else {

                $query = ChildElementQuery::create(null, $criteria)
                    ->filterByTag($this);
                $collElements = $query->find($con);
                if (null !== $criteria) {
                    return $collElements;
                }

                if ($partial && $this->collElements) {
                    //make sure that already added objects gets added to the list of the database.
                    foreach ($this->collElements as $obj) {
                        if (!$collElements->contains($obj)) {
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
     * Sets a collection of Element objects related by a many-to-many relationship
     * to the current object by way of the tagsXelements cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param  Collection $elements A Propel collection.
     * @param  ConnectionInterface $con Optional connection object
     * @return $this|ChildTag The current object (for fluent API support)
     */
    public function setElements(Collection $elements, ConnectionInterface $con = null)
    {
        $this->clearElements();
        $currentElements = $this->getElements();

        $elementsScheduledForDeletion = $currentElements->diff($elements);

        foreach ($elementsScheduledForDeletion as $toDelete) {
            $this->removeElement($toDelete);
        }

        foreach ($elements as $element) {
            if (!$currentElements->contains($element)) {
                $this->doAddElement($element);
            }
        }

        $this->collElementsPartial = false;
        $this->collElements = $elements;

        return $this;
    }

    /**
     * Gets the number of Element objects related by a many-to-many relationship
     * to the current object by way of the tagsXelements cross-reference table.
     *
     * @param      Criteria $criteria Optional query object to filter the query
     * @param      boolean $distinct Set to true to force count distinct
     * @param      ConnectionInterface $con Optional connection object
     *
     * @return int the number of related Element objects
     */
    public function countElements(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                return 0;
            } else {

                if ($partial && !$criteria) {
                    return count($this->getElements());
                }

                $query = ChildElementQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterByTag($this)
                    ->count($con);
            }
        } else {
            return count($this->collElements);
        }
    }

    /**
     * Associate a ChildElement to this object
     * through the tagsXelements cross reference table.
     *
     * @param ChildElement $element
     * @return ChildTag The current object (for fluent API support)
     */
    public function addElement(ChildElement $element)
    {
        if ($this->collElements === null) {
            $this->initElements();
        }

        if (!$this->getElements()->contains($element)) {
            // only add it if the **same** object is not already associated
            $this->collElements->push($element);
            $this->doAddElement($element);
        }

        return $this;
    }

    /**
     *
     * @param ChildElement $element
     */
    protected function doAddElement(ChildElement $element)
    {
        $taggedElement = new ChildTaggedElement();

        $taggedElement->setElement($element);

        $taggedElement->setTag($this);

        $this->addTaggedElement($taggedElement);

        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$element->isTagsLoaded()) {
            $element->initTags();
            $element->getTags()->push($this);
        } elseif (!$element->getTags()->contains($this)) {
            $element->getTags()->push($this);
        }

    }

    /**
     * Remove element of this object
     * through the tagsXelements cross reference table.
     *
     * @param ChildElement $element
     * @return ChildTag The current object (for fluent API support)
     */
    public function removeElement(ChildElement $element)
    {
        if ($this->getElements()->contains($element)) { $taggedElement = new ChildTaggedElement();

            $taggedElement->setElement($element);
            if ($element->isTagsLoaded()) {
                //remove the back reference if available
                $element->getTags()->removeObject($this);
            }

            $taggedElement->setTag($this);
            $this->removeTaggedElement(clone $taggedElement);
            $taggedElement->clear();

            $this->collElements->remove($this->collElements->search($element));

            if (null === $this->elementsScheduledForDeletion) {
                $this->elementsScheduledForDeletion = clone $this->collElements;
                $this->elementsScheduledForDeletion->clear();
            }

            $this->elementsScheduledForDeletion->push($element);
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
        if (null !== $this->aUser) {
            $this->aUser->removeTag($this);
        }
        $this->id = null;
        $this->tag = null;
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
            if ($this->collTaggedQuestions) {
                foreach ($this->collTaggedQuestions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTaggedElements) {
                foreach ($this->collTaggedElements as $o) {
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
        } // if ($deep)

        $this->collTaggedQuestions = null;
        $this->collTaggedElements = null;
        $this->collQuestions = null;
        $this->collElements = null;
        $this->aUser = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TagTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildTag The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[TagTableMap::COL_UPDATED_AT] = true;

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
