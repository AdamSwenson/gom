<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 7/20/15
 * Time: 9:06 AM
 */
namespace App\classes\ObjectInterfaces;


/**
 * Base class that represents a row from the 'exams' table.
 *
 *
 */
interface IExam
{

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId();

    /**
     * [deprecated] Get the [examterm] column value.
     * Alias for getTerm
     *
     * @deprecated
     * @return string
     */
    public function getExamterm();

    /**
     * Get the term column value
     * @return string
     */
    public function getTerm();


    /**
     * [deprecated] Get the name column value.
     * Alias for getName
     *
     * @deprecated
     * @return string
     */
    public function getExamtopic();

    /**
     * Get the name column value
     * @return string
     */
    public function getName();

    /**
     * [deprecated] Get the [examyear] column value.
     * Alias for getYear()
     *
     * @deprecated
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

//    /**
//     * Get the [optionally formatted] temporal [created_at] column value.
//     *
//     *
//     * @param      string $format The date/time format string (either date()-style or strftime()-style).
//     *                            If format is NULL, then the raw DateTime object will be returned.
//     *
//     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
//     *
//     * @throws PropelException - if unable to parse/validate the date/time value.
//     */
//    public function getCreatedAt($format = null);
//
//    /**
//     * Get the [optionally formatted] temporal [updated_at] column value.
//     *
//     *
//     * @param      string $format The date/time format string (either date()-style or strftime()-style).
//     *                            If format is NULL, then the raw DateTime object will be returned.
//     *
//     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
//     *
//     * @throws PropelException - if unable to parse/validate the date/time value.
//     */
//    public function getUpdatedAt($format = null);


    /**
     * [deprecated] Set the value of [examterm] column.
     * Alias for setTerm
     *
     * @deprecated
     * @param $term
     * @return $this|\Exam The current object (for fluent API support)
     * @internal param string $v new value
     */
    public function setExamterm($term);

    /**
     * Sets the value of the term column.
     * @param string $term
     * @return $this The current object (for fluent API support)
     */
    public function setTerm($term);

    /**
     * [deprecated] Alias for set exam name column.
     * @deprecated Vestigial from propel model version
     * @param $topic
     * @return $this The current object (for fluent API support)
     */
    public function setExamtopic($topic);

    /**
     * Set exam name
     * @param string $name
     * @return $this The current object (for fluent API support)
     */
    public function setName($name);

    /**
     * [deprecated] Set the value of [examyear] column.
     * Alias for setYear
     *
     * @deprecated
     * @param $year
     * @return $this The current object (for fluent API support)
     */
    public function setExamyear($year);

    /**
     * Sets the year of the exam.
     *
     * @param integer|string $year
     * @return $this|\Exam The current object (for fluent API support)
     *
     */
    public function setYear($year);


    /**
     * Set the value of [locked] column.
     *
     * @param boolean|int $v new value
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

//    /**
//     * Set the value of [user_id] column.
//     *
//     * @param int $v new value
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function setUserId($v);
//
//    /**
//     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
//     *
//     * @param  mixed $v string, integer (timestamp), or \DateTime value.
//     *               Empty strings are treated as NULL.
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function setCreatedAt($v);
//
//    /**
//     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
//     *
//     * @param  mixed $v string, integer (timestamp), or \DateTime value.
//     *               Empty strings are treated as NULL.
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function setUpdatedAt($v);
//
//    /**
//     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
//     *
//     * This will only work if the object has been saved and has a valid primary key set.
//     *
//     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
//     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
//     * @return void
//     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
//     */
//    public function reload($deep = false, ConnectionInterface $con = null);
//
//    /**
//     * Removes this object from datastore and sets delete attribute.
//     *
//     * @param      ConnectionInterface $con
//     * @return void
//     * @throws PropelException
//     * @see Exam::setDeleted()
//     * @see Exam::isDeleted()
//     */
//    public function delete(ConnectionInterface $con = null);
//
//    /**
//     * Persists this object to the database.
//     *
//     * If the object is new, it inserts it; otherwise an update is performed.
//     * All modified related objects will also be persisted in the doSave()
//     * method.  This method wraps all precipitate database operations in a
//     * single transaction.
//     *
//     * @param      ConnectionInterface $con
//     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
//     * @throws PropelException
//     * @see doSave()
//     */
//    public function save(ConnectionInterface $con = null);
//
//
//    /**
//     * Sets contents of passed object to values from current object.
//     *
//     * If desired, this method can also make copies of all associated (fkey referrers)
//     * objects.
//     *
//     * @param      object $copyObj An object of \Exam (or compatible) type.
//     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
//     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
//     * @throws PropelException
//     */
//    public function copyInto($copyObj, $deepCopy = false, $makeNew = true);
//
//    /**
//     * Makes a copy of this object that will be inserted as a new row in table when saved.
//     * It creates a new object filling in the simple attributes, but skipping any primary
//     * keys that are defined for the table.
//     *
//     * If desired, this method can also make copies of all associated (fkey referrers)
//     * objects.
//     *
//     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
//     * @return \Exam Clone of current object.
//     * @throws PropelException
//     */
//    public function copy($deepCopy = false);
//
//    /**
//     * Declares an association between this object and a ChildUser object.
//     *
//     * @param  ChildUser $v
//     * @return $this|\Exam The current object (for fluent API support)
//     * @throws PropelException
//     */
//    public function setUser(ChildUser $v = null);
//
//    /**
//     * Get the associated ChildUser object
//     *
//     * @param  ConnectionInterface $con Optional Connection object.
//     * @return ChildUser The associated ChildUser object.
//     * @throws PropelException
//     */
//    public function getUser(ConnectionInterface $con = null);
//
//    /**
//     * Clears out the collQuestionScores collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addQuestionScores()
//     */
//    public function clearQuestionScores();
//
//    /**
//     * Gets an array of ChildQuestionScore objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildQuestionScore[] List of ChildQuestionScore objects
//     * @throws PropelException
//     */
//    public function getQuestionScores(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildQuestionScore objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $questionScores A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setQuestionScores(Collection $questionScores, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related QuestionScore objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related QuestionScore objects.
//     * @throws PropelException
//     */
//    public function countQuestionScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);
//
//    /**
//     * Method called to associate a ChildQuestionScore object to this object
//     * through the ChildQuestionScore foreign key attribute.
//     *
//     * @param  ChildQuestionScore $l ChildQuestionScore
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addQuestionScore(ChildQuestionScore $l);
//
//    /**
//     * @param  ChildQuestionScore $questionScore The ChildQuestionScore object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeQuestionScore(ChildQuestionScore $questionScore);
//
//    /**
//     * Clears out the collElementScores collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addElementScores()
//     */
//    public function clearElementScores();
//
//    /**
//     * Gets an array of ChildElementScore objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildElementScore[] List of ChildElementScore objects
//     * @throws PropelException
//     */
//    public function getElementScores(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildElementScore objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $elementScores A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setElementScores(Collection $elementScores, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related ElementScore objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related ElementScore objects.
//     * @throws PropelException
//     */
//    public function countElementScores(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);
//
//    /**
//     * Method called to associate a ChildElementScore object to this object
//     * through the ChildElementScore foreign key attribute.
//     *
//     * @param  ChildElementScore $l ChildElementScore
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addElementScore(ChildElementScore $l);
//
//    /**
//     * @param  ChildElementScore $elementScore The ChildElementScore object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeElementScore(ChildElementScore $elementScore);
//
//
//    /**
//     * Clears out the collExamInfos collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addExamInfos()
//     */
//    public function clearExamInfos();
//
//    /**
//     * Gets an array of ChildExamInfo objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildExamInfo[] List of ChildExamInfo objects
//     * @throws PropelException
//     */
//    public function getExamInfos(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildExamInfo objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $examInfos A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setExamInfos(Collection $examInfos, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related ExamInfo objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related ExamInfo objects.
//     * @throws PropelException
//     */
//    public function countExamInfos(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);
//
//    /**
//     * Method called to associate a ChildExamInfo object to this object
//     * through the ChildExamInfo foreign key attribute.
//     *
//     * @param  ChildExamInfo $l ChildExamInfo
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addExamInfo(ChildExamInfo $l);
//
//    /**
//     * @param  ChildExamInfo $examInfo The ChildExamInfo object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeExamInfo(ChildExamInfo $examInfo);
//
//    /**
//     * Clears out the collQuestionAssigners collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addQuestionAssigners()
//     */
//    public function clearQuestionAssigners();
//
//
//    /**
//     * Gets an array of ChildQuestionAssigner objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildQuestionAssigner[] List of ChildQuestionAssigner objects
//     * @throws PropelException
//     */
//    public function getQuestionAssigners(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildQuestionAssigner objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $questionAssigners A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setQuestionAssigners(Collection $questionAssigners, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related QuestionAssigner objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related QuestionAssigner objects.
//     * @throws PropelException
//     */
//    public function countQuestionAssigners(
//        Criteria $criteria = null,
//        $distinct = false,
//        ConnectionInterface $con = null
//    );
//
//    /**
//     * Method called to associate a ChildQuestionAssigner object to this object
//     * through the ChildQuestionAssigner foreign key attribute.
//     *
//     * @param  ChildQuestionAssigner $l ChildQuestionAssigner
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addQuestionAssigner(ChildQuestionAssigner $l);
//
//    /**
//     * @param  ChildQuestionAssigner $questionAssigner The ChildQuestionAssigner object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeQuestionAssigner(ChildQuestionAssigner $questionAssigner);
//
//
//    /**
//     * Clears out the collElementAssignments collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addElementAssignments()
//     */
//    public function clearElementAssignments();
//
//
//    /**
//     * Gets an array of ChildElementAssignment objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildElementAssignment[] List of ChildElementAssignment objects
//     * @throws PropelException
//     */
//    public function getElementAssignments(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildElementAssignment objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $elementAssignments A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setElementAssignments(Collection $elementAssignments, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related ElementAssignment objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related ElementAssignment objects.
//     * @throws PropelException
//     */
//    public function countElementAssignments(
//        Criteria $criteria = null,
//        $distinct = false,
//        ConnectionInterface $con = null
//    );
//
//    /**
//     * Method called to associate a ChildElementAssignment object to this object
//     * through the ChildElementAssignment foreign key attribute.
//     *
//     * @param  ChildElementAssignment $l ChildElementAssignment
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addElementAssignment(ChildElementAssignment $l);
//
//    /**
//     * @param  ChildElementAssignment $elementAssignment The ChildElementAssignment object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeElementAssignment(ChildElementAssignment $elementAssignment);
//
//
//    /**
//     * Clears out the collExamClassAssignments collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addExamClassAssignments()
//     */
//    public function clearExamClassAssignments();
//
//
//    /**
//     * Gets an array of ChildExamClassAssignment objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildExamClassAssignment[] List of ChildExamClassAssignment objects
//     * @throws PropelException
//     */
//    public function getExamClassAssignments(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildExamClassAssignment objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $examClassAssignments A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setExamClassAssignments(Collection $examClassAssignments, ConnectionInterface $con = null);
//
//
//    /**
//     * Method called to associate a ChildExamClassAssignment object to this object
//     * through the ChildExamClassAssignment foreign key attribute.
//     *
//     * @param  ChildExamClassAssignment $l ChildExamClassAssignment
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addExamClassAssignment(ChildExamClassAssignment $l);
//
//    /**
//     * @param  ChildExamClassAssignment $examClassAssignment The ChildExamClassAssignment object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeExamClassAssignment(ChildExamClassAssignment $examClassAssignment);
//

//    /**
//     * Clears out the collGradingTimes collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addGradingTimes()
//     */
//    public function clearGradingTimes();
//
//
//    /**
//     * Gets an array of ChildGradingTime objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildGradingTime[] List of ChildGradingTime objects
//     * @throws PropelException
//     */
//    public function getGradingTimes(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildGradingTime objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $gradingTimes A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setGradingTimes(Collection $gradingTimes, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related GradingTime objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related GradingTime objects.
//     * @throws PropelException
//     */
//    public function countGradingTimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);
//
//    /**
//     * Method called to associate a ChildGradingTime object to this object
//     * through the ChildGradingTime foreign key attribute.
//     *
//     * @param  ChildGradingTime $l ChildGradingTime
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addGradingTime(ChildGradingTime $l);
//
//    /**
//     * @param  ChildGradingTime $gradingTime The ChildGradingTime object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeGradingTime(ChildGradingTime $gradingTime);
//
//
//    /**
//     * Gets an array of ChildGroupTime objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildGroupTime[] List of ChildGroupTime objects
//     * @throws PropelException
//     */
//    public function getGroupTimes(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildGroupTime objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $groupTimes A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setGroupTimes(Collection $groupTimes, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related GroupTime objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related GroupTime objects.
//     * @throws PropelException
//     */
//    public function countGroupTimes(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);
//
//    /**
//     * Method called to associate a ChildGroupTime object to this object
//     * through the ChildGroupTime foreign key attribute.
//     *
//     * @param  ChildGroupTime $l ChildGroupTime
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addGroupTime(ChildGroupTime $l);
//
//    /**
//     * @param  ChildGroupTime $groupTime The ChildGroupTime object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removeGroupTime(ChildGroupTime $groupTime);


//    /**
//     * Clears out the collPseudoIDs collection
//     *
//     * This does not modify the database; however, it will remove any associated objects, causing
//     * them to be refetched by subsequent calls to accessor method.
//     *
//     * @return void
//     * @see        addPseudoIDs()
//     */
//    public function clearPseudoIDs();
//
//    /**
//     * Gets an array of ChildPseudoID objects which contain a foreign key that references this object.
//     *
//     * If the $criteria is not null, it is used to always fetch the results from the database.
//     * Otherwise the results are fetched from the database the first time, then cached.
//     * Next time the same method is called without $criteria, the cached collection is returned.
//     * If this ChildExam is new, it will return
//     * an empty collection or the current collection; the criteria is ignored on a new object.
//     *
//     * @param      Criteria $criteria optional Criteria object to narrow the query
//     * @param      ConnectionInterface $con optional connection object
//     * @return ObjectCollection|ChildPseudoID[] List of ChildPseudoID objects
//     * @throws PropelException
//     */
//    public function getPseudoIDs(Criteria $criteria = null, ConnectionInterface $con = null);
//
//    /**
//     * Sets a collection of ChildPseudoID objects related by a one-to-many relationship
//     * to the current object.
//     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
//     * and new objects from the given Propel collection.
//     *
//     * @param      Collection $pseudoIDs A Propel collection.
//     * @param      ConnectionInterface $con Optional connection object
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function setPseudoIDs(Collection $pseudoIDs, ConnectionInterface $con = null);
//
//    /**
//     * Returns the number of related PseudoID objects.
//     *
//     * @param      Criteria $criteria
//     * @param      boolean $distinct
//     * @param      ConnectionInterface $con
//     * @return int             Count of related PseudoID objects.
//     * @throws PropelException
//     */
//    public function countPseudoIDs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null);
//
//    /**
//     * Method called to associate a ChildPseudoID object to this object
//     * through the ChildPseudoID foreign key attribute.
//     *
//     * @param  ChildPseudoID $l ChildPseudoID
//     * @return $this|\Exam The current object (for fluent API support)
//     */
//    public function addPseudoID(ChildPseudoID $l);
//
//    /**
//     * @param  ChildPseudoID $pseudoID The ChildPseudoID object to remove.
//     * @return $this|ChildExam The current object (for fluent API support)
//     */
//    public function removePseudoID(ChildPseudoID $pseudoID);
//
//
//    /**
//     * Clears the current object, sets all attributes to their default values and removes
//     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
//     * change of those foreign objects when you call `save` there).
//     */
//    public function clear();


}