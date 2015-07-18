<?php

namespace Base;

use \ExamInfo as ChildExamInfo;
use \ExamInfoQuery as ChildExamInfoQuery;
use \Exception;
use \PDO;
use Map\ExamInfoTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'examInfo' table.
 *
 *
 *
 * @method     ChildExamInfoQuery orderByExamid($order = Criteria::ASC) Order by the examID column
 * @method     ChildExamInfoQuery orderByStudentid($order = Criteria::ASC) Order by the studentID column
 * @method     ChildExamInfoQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildExamInfoQuery orderByCompletionorder($order = Criteria::ASC) Order by the completionOrder column
 * @method     ChildExamInfoQuery orderByPages($order = Criteria::ASC) Order by the pages column
 * @method     ChildExamInfoQuery orderByNotecard($order = Criteria::ASC) Order by the notecard column
 * @method     ChildExamInfoQuery orderByExamgroupnumber($order = Criteria::ASC) Order by the examGroupNumber column
 * @method     ChildExamInfoQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildExamInfoQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildExamInfoQuery groupByExamid() Group by the examID column
 * @method     ChildExamInfoQuery groupByStudentid() Group by the studentID column
 * @method     ChildExamInfoQuery groupByUserId() Group by the user_id column
 * @method     ChildExamInfoQuery groupByCompletionorder() Group by the completionOrder column
 * @method     ChildExamInfoQuery groupByPages() Group by the pages column
 * @method     ChildExamInfoQuery groupByNotecard() Group by the notecard column
 * @method     ChildExamInfoQuery groupByExamgroupnumber() Group by the examGroupNumber column
 * @method     ChildExamInfoQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildExamInfoQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildExamInfoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExamInfoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExamInfoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExamInfoQuery leftJoinExam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exam relation
 * @method     ChildExamInfoQuery rightJoinExam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exam relation
 * @method     ChildExamInfoQuery innerJoinExam($relationAlias = null) Adds a INNER JOIN clause to the query using the Exam relation
 *
 * @method     ChildExamInfoQuery leftJoinStudent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Student relation
 * @method     ChildExamInfoQuery rightJoinStudent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Student relation
 * @method     ChildExamInfoQuery innerJoinStudent($relationAlias = null) Adds a INNER JOIN clause to the query using the Student relation
 *
 * @method     ChildExamInfoQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildExamInfoQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildExamInfoQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     \ExamQuery|\StudentQuery|\UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildExamInfo findOne(ConnectionInterface $con = null) Return the first ChildExamInfo matching the query
 * @method     ChildExamInfo findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExamInfo matching the query, or a new ChildExamInfo object populated from the query conditions when no match is found
 *
 * @method     ChildExamInfo findOneByExamid(int $examID) Return the first ChildExamInfo filtered by the examID column
 * @method     ChildExamInfo findOneByStudentid(int $studentID) Return the first ChildExamInfo filtered by the studentID column
 * @method     ChildExamInfo findOneByUserId(int $user_id) Return the first ChildExamInfo filtered by the user_id column
 * @method     ChildExamInfo findOneByCompletionorder(int $completionOrder) Return the first ChildExamInfo filtered by the completionOrder column
 * @method     ChildExamInfo findOneByPages(double $pages) Return the first ChildExamInfo filtered by the pages column
 * @method     ChildExamInfo findOneByNotecard(double $notecard) Return the first ChildExamInfo filtered by the notecard column
 * @method     ChildExamInfo findOneByExamgroupnumber(int $examGroupNumber) Return the first ChildExamInfo filtered by the examGroupNumber column
 * @method     ChildExamInfo findOneByCreatedAt(string $created_at) Return the first ChildExamInfo filtered by the created_at column
 * @method     ChildExamInfo findOneByUpdatedAt(string $updated_at) Return the first ChildExamInfo filtered by the updated_at column *

 * @method     ChildExamInfo requirePk($key, ConnectionInterface $con = null) Return the ChildExamInfo by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOne(ConnectionInterface $con = null) Return the first ChildExamInfo matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExamInfo requireOneByExamid(int $examID) Return the first ChildExamInfo filtered by the examID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByStudentid(int $studentID) Return the first ChildExamInfo filtered by the studentID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByUserId(int $user_id) Return the first ChildExamInfo filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByCompletionorder(int $completionOrder) Return the first ChildExamInfo filtered by the completionOrder column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByPages(double $pages) Return the first ChildExamInfo filtered by the pages column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByNotecard(double $notecard) Return the first ChildExamInfo filtered by the notecard column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByExamgroupnumber(int $examGroupNumber) Return the first ChildExamInfo filtered by the examGroupNumber column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByCreatedAt(string $created_at) Return the first ChildExamInfo filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamInfo requireOneByUpdatedAt(string $updated_at) Return the first ChildExamInfo filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExamInfo[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExamInfo objects based on current ModelCriteria
 * @method     ChildExamInfo[]|ObjectCollection findByExamid(int $examID) Return ChildExamInfo objects filtered by the examID column
 * @method     ChildExamInfo[]|ObjectCollection findByStudentid(int $studentID) Return ChildExamInfo objects filtered by the studentID column
 * @method     ChildExamInfo[]|ObjectCollection findByUserId(int $user_id) Return ChildExamInfo objects filtered by the user_id column
 * @method     ChildExamInfo[]|ObjectCollection findByCompletionorder(int $completionOrder) Return ChildExamInfo objects filtered by the completionOrder column
 * @method     ChildExamInfo[]|ObjectCollection findByPages(double $pages) Return ChildExamInfo objects filtered by the pages column
 * @method     ChildExamInfo[]|ObjectCollection findByNotecard(double $notecard) Return ChildExamInfo objects filtered by the notecard column
 * @method     ChildExamInfo[]|ObjectCollection findByExamgroupnumber(int $examGroupNumber) Return ChildExamInfo objects filtered by the examGroupNumber column
 * @method     ChildExamInfo[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildExamInfo objects filtered by the created_at column
 * @method     ChildExamInfo[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildExamInfo objects filtered by the updated_at column
 * @method     ChildExamInfo[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExamInfoQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ExamInfoQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\ExamInfo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExamInfoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExamInfoQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExamInfoQuery) {
            return $criteria;
        }
        $query = new ChildExamInfoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$examID, $studentID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildExamInfo|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExamInfoTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExamInfoTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamInfo A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT examID, studentID, user_id, completionOrder, pages, notecard, examGroupNumber, created_at, updated_at FROM examInfo WHERE examID = :p0 AND studentID = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildExamInfo $obj */
            $obj = new ChildExamInfo();
            $obj->hydrate($row);
            ExamInfoTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildExamInfo|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ExamInfoTableMap::COL_EXAMID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ExamInfoTableMap::COL_STUDENTID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ExamInfoTableMap::COL_EXAMID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ExamInfoTableMap::COL_STUDENTID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the examID column
     *
     * Example usage:
     * <code>
     * $query->filterByExamid(1234); // WHERE examID = 1234
     * $query->filterByExamid(array(12, 34)); // WHERE examID IN (12, 34)
     * $query->filterByExamid(array('min' => 12)); // WHERE examID > 12
     * </code>
     *
     * @see       filterByExam()
     *
     * @param     mixed $examid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByExamid($examid = null, $comparison = null)
    {
        if (is_array($examid)) {
            $useMinMax = false;
            if (isset($examid['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_EXAMID, $examid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examid['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_EXAMID, $examid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_EXAMID, $examid, $comparison);
    }

    /**
     * Filter the query on the studentID column
     *
     * Example usage:
     * <code>
     * $query->filterByStudentid(1234); // WHERE studentID = 1234
     * $query->filterByStudentid(array(12, 34)); // WHERE studentID IN (12, 34)
     * $query->filterByStudentid(array('min' => 12)); // WHERE studentID > 12
     * </code>
     *
     * @see       filterByStudent()
     *
     * @param     mixed $studentid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByStudentid($studentid = null, $comparison = null)
    {
        if (is_array($studentid)) {
            $useMinMax = false;
            if (isset($studentid['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_STUDENTID, $studentid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studentid['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_STUDENTID, $studentid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_STUDENTID, $studentid, $comparison);
    }

    /**
     * Filter the query on the user_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserId(1234); // WHERE user_id = 1234
     * $query->filterByUserId(array(12, 34)); // WHERE user_id IN (12, 34)
     * $query->filterByUserId(array('min' => 12)); // WHERE user_id > 12
     * </code>
     *
     * @see       filterByUser()
     *
     * @param     mixed $userId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_USER_ID, $userId, $comparison);
    }

    /**
     * Filter the query on the completionOrder column
     *
     * Example usage:
     * <code>
     * $query->filterByCompletionorder(1234); // WHERE completionOrder = 1234
     * $query->filterByCompletionorder(array(12, 34)); // WHERE completionOrder IN (12, 34)
     * $query->filterByCompletionorder(array('min' => 12)); // WHERE completionOrder > 12
     * </code>
     *
     * @param     mixed $completionorder The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByCompletionorder($completionorder = null, $comparison = null)
    {
        if (is_array($completionorder)) {
            $useMinMax = false;
            if (isset($completionorder['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_COMPLETIONORDER, $completionorder['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($completionorder['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_COMPLETIONORDER, $completionorder['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_COMPLETIONORDER, $completionorder, $comparison);
    }

    /**
     * Filter the query on the pages column
     *
     * Example usage:
     * <code>
     * $query->filterByPages(1234); // WHERE pages = 1234
     * $query->filterByPages(array(12, 34)); // WHERE pages IN (12, 34)
     * $query->filterByPages(array('min' => 12)); // WHERE pages > 12
     * </code>
     *
     * @param     mixed $pages The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByPages($pages = null, $comparison = null)
    {
        if (is_array($pages)) {
            $useMinMax = false;
            if (isset($pages['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_PAGES, $pages['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pages['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_PAGES, $pages['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_PAGES, $pages, $comparison);
    }

    /**
     * Filter the query on the notecard column
     *
     * Example usage:
     * <code>
     * $query->filterByNotecard(1234); // WHERE notecard = 1234
     * $query->filterByNotecard(array(12, 34)); // WHERE notecard IN (12, 34)
     * $query->filterByNotecard(array('min' => 12)); // WHERE notecard > 12
     * </code>
     *
     * @param     mixed $notecard The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByNotecard($notecard = null, $comparison = null)
    {
        if (is_array($notecard)) {
            $useMinMax = false;
            if (isset($notecard['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_NOTECARD, $notecard['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notecard['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_NOTECARD, $notecard['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_NOTECARD, $notecard, $comparison);
    }

    /**
     * Filter the query on the examGroupNumber column
     *
     * Example usage:
     * <code>
     * $query->filterByExamgroupnumber(1234); // WHERE examGroupNumber = 1234
     * $query->filterByExamgroupnumber(array(12, 34)); // WHERE examGroupNumber IN (12, 34)
     * $query->filterByExamgroupnumber(array('min' => 12)); // WHERE examGroupNumber > 12
     * </code>
     *
     * @param     mixed $examgroupnumber The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByExamgroupnumber($examgroupnumber = null, $comparison = null)
    {
        if (is_array($examgroupnumber)) {
            $useMinMax = false;
            if (isset($examgroupnumber['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_EXAMGROUPNUMBER, $examgroupnumber['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examgroupnumber['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_EXAMGROUPNUMBER, $examgroupnumber['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_EXAMGROUPNUMBER, $examgroupnumber, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ExamInfoTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamInfoTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Exam object
     *
     * @param \Exam|ObjectCollection $exam The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByExam($exam, $comparison = null)
    {
        if ($exam instanceof \Exam) {
            return $this
                ->addUsingAlias(ExamInfoTableMap::COL_EXAMID, $exam->getId(), $comparison);
        } elseif ($exam instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamInfoTableMap::COL_EXAMID, $exam->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByExam() only accepts arguments of type \Exam or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Exam relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function joinExam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Exam');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Exam');
        }

        return $this;
    }

    /**
     * Use the Exam relation Exam object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ExamQuery A secondary query class using the current class as primary query
     */
    public function useExamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Exam', '\ExamQuery');
    }

    /**
     * Filter the query by a related \Student object
     *
     * @param \Student|ObjectCollection $student The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByStudent($student, $comparison = null)
    {
        if ($student instanceof \Student) {
            return $this
                ->addUsingAlias(ExamInfoTableMap::COL_STUDENTID, $student->getId(), $comparison);
        } elseif ($student instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamInfoTableMap::COL_STUDENTID, $student->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByStudent() only accepts arguments of type \Student or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Student relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function joinStudent($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Student');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Student');
        }

        return $this;
    }

    /**
     * Use the Student relation Student object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StudentQuery A secondary query class using the current class as primary query
     */
    public function useStudentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudent($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Student', '\StudentQuery');
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamInfoQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(ExamInfoTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamInfoTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUser() only accepts arguments of type \User or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the User relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function joinUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('User');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'User');
        }

        return $this;
    }

    /**
     * Use the User relation User object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \UserQuery A secondary query class using the current class as primary query
     */
    public function useUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'User', '\UserQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildExamInfo $examInfo Object to remove from the list of results
     *
     * @return $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function prune($examInfo = null)
    {
        if ($examInfo) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ExamInfoTableMap::COL_EXAMID), $examInfo->getExamid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ExamInfoTableMap::COL_STUDENTID), $examInfo->getStudentid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the examInfo table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamInfoTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExamInfoTableMap::clearInstancePool();
            ExamInfoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamInfoTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExamInfoTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ExamInfoTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ExamInfoTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ExamInfoTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ExamInfoTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ExamInfoTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ExamInfoTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ExamInfoTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildExamInfoQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ExamInfoTableMap::COL_CREATED_AT);
    }

} // ExamInfoQuery
