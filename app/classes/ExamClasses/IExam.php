<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/20/15
 * Time: 9:06 AM
 */
namespace ExamClasses;

use Base\Exam;
use DateTime;
use ElementAssignment as ChildElementAssignment;
use ElementScore as ChildElementScore;
use Exam as ChildExam;
use ExamClassAssignment as ChildExamClassAssignment;
use ExamInfo as ChildExamInfo;
use GradingTime as ChildGradingTime;
use GroupTime as ChildGroupTime;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use PseudoID as ChildPseudoID;
use QuestionAssigner as ChildQuestionAssigner;
use QuestionScore as ChildQuestionScore;
use User as ChildUser;


/**
 * Base class that represents a row from the 'exams' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
interface IExam
{
    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues();

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified();

    /**
     * Has specified column been modified?
     *
     * @param  string $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col);

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns();

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew();

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b);

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted();

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b);

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null);

    /**
     * Compares this with another <code>Exam</code> instance.  If
     * <code>obj</code> is an instance of <code>Exam</code>, delegates to
     * <code>equals(Exam)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj);

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns();

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name);

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name);

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name The virtual column name
     * @param mixed $value The value to give to the virtual column
     *
     * @return $this|Exam The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value);

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed $parser A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true);

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId();

    /**
     * Get the [examterm] column value.
     *
     * @return string
     */
    public function getExamterm();

    /**
     * Get the [examtopic] column value.
     *
     * @return string
     */
    public function getExamtopic();

    /**
     * Get the [examyear] column value.
     *
     * @return int
     */
    public function getExamyear();

    /**
     * Get the [locked] column value.
     *
     * @return int
     */
    public function getLocked();

    /**
     * Get the [released] column value.
     *
     * @return int
     */
    public function getReleased();

    /**
     * Get the [user_id] column value.
     *
     * @return int
     */
    public function getUserId();

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
    public function getCreatedAt($format = null);

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
    public function getUpdatedAt($format = null);

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setId($v);

    /**
     * Set the value of [examterm] column.
     *
     * @param string $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setExamterm($v);

    /**
     * Set the value of [examtopic] column.
     *
     * @param string $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setExamtopic($v);

    /**
     * Set the value of [examyear] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setExamyear($v);

    /**
     * Set the value of [locked] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setLocked($v);

    /**
     * Set the value of [released] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setReleased($v);

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setUserId($v);

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setCreatedAt($v);

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function setUpdatedAt($v);

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues();

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by DataFetcher->fetch().
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
     * One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM);

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
    public function ensureConsistency();

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
    public function reload($deep = false, ConnectionInterface $con = null);

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Exam::setDeleted()
     * @see Exam::isDeleted()
     */
    public function delete(ConnectionInterface $con = null);

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
    public function save(ConnectionInterface $con = null);

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
    public function getByName($name, $type = TableMap::TYPE_PHPNAME);

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos);

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray(
        $keyType = TableMap::TYPE_PHPNAME,
        $includeLazyLoadColumns = true,
        $alreadyDumpedObjects = array(),
        $includeForeignObjects = false
    );

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Exam
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME);

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Exam
     */
    public function setByPosition($pos, $value);

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
     * @param      array $arr An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME);

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
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME);

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria();

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
    public function buildPkeyCriteria();

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode();

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey();

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key);

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull();

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
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true);

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
    public function copy($deepCopy = false);

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Exam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUser(ChildUser $v = null);

    /**
     * Get the associated ChildUser object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUser The associated ChildUser object.
     * @throws PropelException
     */
    public function getUser(ConnectionInterface $con = null);

    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName);

    /**
     * Clears out the collQuestionScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestionScores()
     */
    public function clearQuestionScores();

    /**
     * Reset is the collQuestionScores collection loaded partially.
     */
    public function resetPartialQuestionScores($v = true);

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
    public function initQuestionScores($overrideExisting = true);

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
    public function getQuestionScores(Criteria $criteria = null, ConnectionInterface $con = null);

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
    public function setQuestionScores(Collection $questionScores, ConnectionInterface $con = null);

    /**
     * Returns the number of related QuestionScore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related QuestionScore objects.
     * @throws PropelException
     */
    public function countQuestionScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);

    /**
     * Method called to associate a ChildQuestionScore object to this object
     * through the ChildQuestionScore foreign key attribute.
     *
     * @param  ChildQuestionScore $l ChildQuestionScore
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addQuestionScore(ChildQuestionScore $l);

    /**
     * @param  ChildQuestionScore $questionScore The ChildQuestionScore object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeQuestionScore(ChildQuestionScore $questionScore);

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
    public function getQuestionScoresJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

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
    public function getQuestionScoresJoinStudent(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

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
    public function getQuestionScoresJoinQuestion(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collElementScores collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addElementScores()
     */
    public function clearElementScores();

    /**
     * Reset is the collElementScores collection loaded partially.
     */
    public function resetPartialElementScores($v = true);

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
    public function initElementScores($overrideExisting = true);

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
    public function getElementScores(Criteria $criteria = null, ConnectionInterface $con = null);

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
    public function setElementScores(Collection $elementScores, ConnectionInterface $con = null);

    /**
     * Returns the number of related ElementScore objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ElementScore objects.
     * @throws PropelException
     */
    public function countElementScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);

    /**
     * Method called to associate a ChildElementScore object to this object
     * through the ChildElementScore foreign key attribute.
     *
     * @param  ChildElementScore $l ChildElementScore
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addElementScore(ChildElementScore $l);

    /**
     * @param  ChildElementScore $elementScore The ChildElementScore object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeElementScore(ChildElementScore $elementScore);

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
    public function getElementScoresJoinElement(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

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
    public function getElementScoresJoinStudent(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

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
    public function getElementScoresJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collExamInfos collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExamInfos()
     */
    public function clearExamInfos();

    /**
     * Reset is the collExamInfos collection loaded partially.
     */
    public function resetPartialExamInfos($v = true);

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
    public function initExamInfos($overrideExisting = true);

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
    public function getExamInfos(Criteria $criteria = null, ConnectionInterface $con = null);

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
    public function setExamInfos(Collection $examInfos, ConnectionInterface $con = null);

    /**
     * Returns the number of related ExamInfo objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ExamInfo objects.
     * @throws PropelException
     */
    public function countExamInfos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);

    /**
     * Method called to associate a ChildExamInfo object to this object
     * through the ChildExamInfo foreign key attribute.
     *
     * @param  ChildExamInfo $l ChildExamInfo
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addExamInfo(ChildExamInfo $l);

    /**
     * @param  ChildExamInfo $examInfo The ChildExamInfo object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeExamInfo(ChildExamInfo $examInfo);

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
    public function getExamInfosJoinStudent(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

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
    public function getExamInfosJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collQuestionAssigners collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addQuestionAssigners()
     */
    public function clearQuestionAssigners();

    /**
     * Reset is the collQuestionAssigners collection loaded partially.
     */
    public function resetPartialQuestionAssigners($v = true);

    /**
     * Initializes the collQuestionAssigners collection.
     *
     * By default this just sets the collQuestionAssigners collection to an empty array (like clearcollQuestionAssigners());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuestionAssigners($overrideExisting = true);

    /**
     * Gets an array of ChildQuestionAssigner objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildQuestionAssigner[] List of ChildQuestionAssigner objects
     * @throws PropelException
     */
    public function getQuestionAssigners(Criteria $criteria = null, ConnectionInterface $con = null);

    /**
     * Sets a collection of ChildQuestionAssigner objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $questionAssigners A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setQuestionAssigners(Collection $questionAssigners, ConnectionInterface $con = null);

    /**
     * Returns the number of related QuestionAssigner objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related QuestionAssigner objects.
     * @throws PropelException
     */
    public function countQuestionAssigners(
        Criteria $criteria = null,
        $distinct = false,
        ConnectionInterface $con = null
    );

    /**
     * Method called to associate a ChildQuestionAssigner object to this object
     * through the ChildQuestionAssigner foreign key attribute.
     *
     * @param  ChildQuestionAssigner $l ChildQuestionAssigner
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addQuestionAssigner(ChildQuestionAssigner $l);

    /**
     * @param  ChildQuestionAssigner $questionAssigner The ChildQuestionAssigner object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeQuestionAssigner(ChildQuestionAssigner $questionAssigner);

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related QuestionAssigners from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildQuestionAssigner[] List of ChildQuestionAssigner objects
     */
    public function getQuestionAssignersJoinQuestion(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related QuestionAssigners from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildQuestionAssigner[] List of ChildQuestionAssigner objects
     */
    public function getQuestionAssignersJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collElementAssignments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addElementAssignments()
     */
    public function clearElementAssignments();

    /**
     * Reset is the collElementAssignments collection loaded partially.
     */
    public function resetPartialElementAssignments($v = true);

    /**
     * Initializes the collElementAssignments collection.
     *
     * By default this just sets the collElementAssignments collection to an empty array (like clearcollElementAssignments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementAssignments($overrideExisting = true);

    /**
     * Gets an array of ChildElementAssignment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildElementAssignment[] List of ChildElementAssignment objects
     * @throws PropelException
     */
    public function getElementAssignments(Criteria $criteria = null, ConnectionInterface $con = null);

    /**
     * Sets a collection of ChildElementAssignment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $elementAssignments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setElementAssignments(Collection $elementAssignments, ConnectionInterface $con = null);

    /**
     * Returns the number of related ElementAssignment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ElementAssignment objects.
     * @throws PropelException
     */
    public function countElementAssignments(
        Criteria $criteria = null,
        $distinct = false,
        ConnectionInterface $con = null
    );

    /**
     * Method called to associate a ChildElementAssignment object to this object
     * through the ChildElementAssignment foreign key attribute.
     *
     * @param  ChildElementAssignment $l ChildElementAssignment
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addElementAssignment(ChildElementAssignment $l);

    /**
     * @param  ChildElementAssignment $elementAssignment The ChildElementAssignment object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeElementAssignment(ChildElementAssignment $elementAssignment);

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ElementAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementAssignment[] List of ChildElementAssignment objects
     */
    public function getElementAssignmentsJoinQuestion(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ElementAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementAssignment[] List of ChildElementAssignment objects
     */
    public function getElementAssignmentsJoinElement(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ElementAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildElementAssignment[] List of ChildElementAssignment objects
     */
    public function getElementAssignmentsJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collExamClassAssignments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addExamClassAssignments()
     */
    public function clearExamClassAssignments();

    /**
     * Reset is the collExamClassAssignments collection loaded partially.
     */
    public function resetPartialExamClassAssignments($v = true);

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
    public function initExamClassAssignments($overrideExisting = true);

    /**
     * Gets an array of ChildExamClassAssignment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildExamClassAssignment[] List of ChildExamClassAssignment objects
     * @throws PropelException
     */
    public function getExamClassAssignments(Criteria $criteria = null, ConnectionInterface $con = null);

    /**
     * Sets a collection of ChildExamClassAssignment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $examClassAssignments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setExamClassAssignments(Collection $examClassAssignments, ConnectionInterface $con = null);

    /**
     * Returns the number of related ExamClassAssignment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related ExamClassAssignment objects.
     * @throws PropelException
     */
    public function countExamClassAssignments(
        Criteria $criteria = null,
        $distinct = false,
        ConnectionInterface $con = null
    );

    /**
     * Method called to associate a ChildExamClassAssignment object to this object
     * through the ChildExamClassAssignment foreign key attribute.
     *
     * @param  ChildExamClassAssignment $l ChildExamClassAssignment
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addExamClassAssignment(ChildExamClassAssignment $l);

    /**
     * @param  ChildExamClassAssignment $examClassAssignment The ChildExamClassAssignment object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeExamClassAssignment(ChildExamClassAssignment $examClassAssignment);

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ExamClassAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamClassAssignment[] List of ChildExamClassAssignment objects
     */
    public function getExamClassAssignmentsJoinKumi(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related ExamClassAssignments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildExamClassAssignment[] List of ChildExamClassAssignment objects
     */
    public function getExamClassAssignmentsJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collGradingTimes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGradingTimes()
     */
    public function clearGradingTimes();

    /**
     * Reset is the collGradingTimes collection loaded partially.
     */
    public function resetPartialGradingTimes($v = true);

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
    public function initGradingTimes($overrideExisting = true);

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
    public function getGradingTimes(Criteria $criteria = null, ConnectionInterface $con = null);

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
    public function setGradingTimes(Collection $gradingTimes, ConnectionInterface $con = null);

    /**
     * Returns the number of related GradingTime objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GradingTime objects.
     * @throws PropelException
     */
    public function countGradingTimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);

    /**
     * Method called to associate a ChildGradingTime object to this object
     * through the ChildGradingTime foreign key attribute.
     *
     * @param  ChildGradingTime $l ChildGradingTime
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addGradingTime(ChildGradingTime $l);

    /**
     * @param  ChildGradingTime $gradingTime The ChildGradingTime object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeGradingTime(ChildGradingTime $gradingTime);

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
    public function getGradingTimesJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

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
    public function getGradingTimesJoinStudent(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collGroupTimes collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addGroupTimes()
     */
    public function clearGroupTimes();

    /**
     * Reset is the collGroupTimes collection loaded partially.
     */
    public function resetPartialGroupTimes($v = true);

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
    public function initGroupTimes($overrideExisting = true);

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
    public function getGroupTimes(Criteria $criteria = null, ConnectionInterface $con = null);

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
    public function setGroupTimes(Collection $groupTimes, ConnectionInterface $con = null);

    /**
     * Returns the number of related GroupTime objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related GroupTime objects.
     * @throws PropelException
     */
    public function countGroupTimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);

    /**
     * Method called to associate a ChildGroupTime object to this object
     * through the ChildGroupTime foreign key attribute.
     *
     * @param  ChildGroupTime $l ChildGroupTime
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addGroupTime(ChildGroupTime $l);

    /**
     * @param  ChildGroupTime $groupTime The ChildGroupTime object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removeGroupTime(ChildGroupTime $groupTime);

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
    public function getGroupTimesJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears out the collPseudoIDs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPseudoIDs()
     */
    public function clearPseudoIDs();

    /**
     * Reset is the collPseudoIDs collection loaded partially.
     */
    public function resetPartialPseudoIDs($v = true);

    /**
     * Initializes the collPseudoIDs collection.
     *
     * By default this just sets the collPseudoIDs collection to an empty array (like clearcollPseudoIDs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPseudoIDs($overrideExisting = true);

    /**
     * Gets an array of ChildPseudoID objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildExam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPseudoID[] List of ChildPseudoID objects
     * @throws PropelException
     */
    public function getPseudoIDs(Criteria $criteria = null, ConnectionInterface $con = null);

    /**
     * Sets a collection of ChildPseudoID objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $pseudoIDs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function setPseudoIDs(Collection $pseudoIDs, ConnectionInterface $con = null);

    /**
     * Returns the number of related PseudoID objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PseudoID objects.
     * @throws PropelException
     */
    public function countPseudoIDs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);

    /**
     * Method called to associate a ChildPseudoID object to this object
     * through the ChildPseudoID foreign key attribute.
     *
     * @param  ChildPseudoID $l ChildPseudoID
     * @return $this|\Exam The current object (for fluent API support)
     */
    public function addPseudoID(ChildPseudoID $l);

    /**
     * @param  ChildPseudoID $pseudoID The ChildPseudoID object to remove.
     * @return $this|ChildExam The current object (for fluent API support)
     */
    public function removePseudoID(ChildPseudoID $pseudoID);

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related PseudoIDs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPseudoID[] List of ChildPseudoID objects
     */
    public function getPseudoIDsJoinUser(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Exam is new, it will return
     * an empty collection; or if this Exam has previously
     * been saved, it will retrieve related PseudoIDs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Exam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPseudoID[] List of ChildPseudoID objects
     */
    public function getPseudoIDsJoinStudent(
        Criteria $criteria = null,
        ConnectionInterface $con = null,
        $joinBehavior = Criteria::LEFT_JOIN
    );

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear();

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false);

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildExam The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged();

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null);

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null);

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null);

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null);

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null);

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null);

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null);

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null);
}