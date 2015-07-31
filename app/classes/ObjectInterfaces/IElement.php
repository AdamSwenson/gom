<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/20/15
 * Time: 5:18 PM
 */
namespace ObjectInterfaces;

use Base\Element;
use DateTime;
use Element as ChildElement;
use ElementAssignment as ChildElementAssignment;
use ElementScore as ChildElementScore;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use User as ChildUser;


/**
 * Base class that represents a row from the 'elements' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
interface IElement
{
    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId();

    /**
     * Get the [elementname] column value.
     *
     * @return string
     */
    public function getElementname();

    /**
     * Get the [displaytext] column value.
     *
     * @return string
     */
    public function getDisplaytext();

    /**
     * Get the [commenttext] column value.
     *
     * @return string
     */
    public function getCommenttext();

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
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setId($v);

    /**
     * Set the value of [elementname] column.
     *
     * @param string $v new value
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setElementname($v);

    /**
     * Set the value of [displaytext] column.
     *
     * @param string $v new value
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setDisplaytext($v);

    /**
     * Set the value of [commenttext] column.
     *
     * @param string $v new value
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setCommenttext($v);

    /**
     * Set the value of [user_id] column.
     *
     * @param int $v new value
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setUserId($v);

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setCreatedAt($v);

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\Element The current object (for fluent API support)
     */
    public function setUpdatedAt($v);
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
     * @see Element::setDeleted()
     * @see Element::isDeleted()
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
    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Element Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false);

    /**
     * Declares an association between this object and a ChildUser object.
     *
     * @param  ChildUser $v
     * @return $this|\Element The current object (for fluent API support)
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
     * Gets an array of ChildElementScore objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildElement is new, it will return
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
     * @return $this|ChildElement The current object (for fluent API support)
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
     * @return $this|\Element The current object (for fluent API support)
     */
    public function addElementScore(ChildElementScore $l);

    /**
     * @param  ChildElementScore $elementScore The ChildElementScore object to remove.
     * @return $this|ChildElement The current object (for fluent API support)
     */
    public function removeElementScore(ChildElementScore $elementScore);

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
     * Gets an array of ChildElementAssignment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildElement is new, it will return
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
     * @return $this|ChildElement The current object (for fluent API support)
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
     * @return $this|\Element The current object (for fluent API support)
     */
    public function addElementAssignment(ChildElementAssignment $l);

    /**
     * @param  ChildElementAssignment $elementAssignment The ChildElementAssignment object to remove.
     * @return $this|ChildElement The current object (for fluent API support)
     */
    public function removeElementAssignment(ChildElementAssignment $elementAssignment);


    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear();

}