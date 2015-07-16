<?php

namespace Base;

use \ElementAssignment as ChildElementAssignment;
use \ElementAssignmentQuery as ChildElementAssignmentQuery;
use \Exception;
use \PDO;
use Map\ElementAssignmentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'elementXquestions' table.
 *
 *
 *
 * @method     ChildElementAssignmentQuery orderByExamid($order = Criteria::ASC) Order by the examID column
 * @method     ChildElementAssignmentQuery orderByQuestionid($order = Criteria::ASC) Order by the questionID column
 * @method     ChildElementAssignmentQuery orderBySubtask($order = Criteria::ASC) Order by the subtask column
 * @method     ChildElementAssignmentQuery orderByElementid($order = Criteria::ASC) Order by the elementID column
 * @method     ChildElementAssignmentQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildElementAssignmentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildElementAssignmentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildElementAssignmentQuery groupByExamid() Group by the examID column
 * @method     ChildElementAssignmentQuery groupByQuestionid() Group by the questionID column
 * @method     ChildElementAssignmentQuery groupBySubtask() Group by the subtask column
 * @method     ChildElementAssignmentQuery groupByElementid() Group by the elementID column
 * @method     ChildElementAssignmentQuery groupByUserId() Group by the user_id column
 * @method     ChildElementAssignmentQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildElementAssignmentQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildElementAssignmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildElementAssignmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildElementAssignmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildElementAssignmentQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildElementAssignmentQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildElementAssignmentQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildElementAssignmentQuery leftJoinExam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exam relation
 * @method     ChildElementAssignmentQuery rightJoinExam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exam relation
 * @method     ChildElementAssignmentQuery innerJoinExam($relationAlias = null) Adds a INNER JOIN clause to the query using the Exam relation
 *
 * @method     ChildElementAssignmentQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     ChildElementAssignmentQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     ChildElementAssignmentQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     ChildElementAssignmentQuery leftJoinElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Element relation
 * @method     ChildElementAssignmentQuery rightJoinElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Element relation
 * @method     ChildElementAssignmentQuery innerJoinElement($relationAlias = null) Adds a INNER JOIN clause to the query using the Element relation
 *
 * @method     \UserQuery|\ExamQuery|\QuestionQuery|\ElementQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildElementAssignment findOne(ConnectionInterface $con = null) Return the first ChildElementAssignment matching the query
 * @method     ChildElementAssignment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildElementAssignment matching the query, or a new ChildElementAssignment object populated from the query conditions when no match is found
 *
 * @method     ChildElementAssignment findOneByExamid(int $examID) Return the first ChildElementAssignment filtered by the examID column
 * @method     ChildElementAssignment findOneByQuestionid(int $questionID) Return the first ChildElementAssignment filtered by the questionID column
 * @method     ChildElementAssignment findOneBySubtask(int $subtask) Return the first ChildElementAssignment filtered by the subtask column
 * @method     ChildElementAssignment findOneByElementid(int $elementID) Return the first ChildElementAssignment filtered by the elementID column
 * @method     ChildElementAssignment findOneByUserId(int $user_id) Return the first ChildElementAssignment filtered by the user_id column
 * @method     ChildElementAssignment findOneByCreatedAt(string $created_at) Return the first ChildElementAssignment filtered by the created_at column
 * @method     ChildElementAssignment findOneByUpdatedAt(string $updated_at) Return the first ChildElementAssignment filtered by the updated_at column *

 * @method     ChildElementAssignment requirePk($key, ConnectionInterface $con = null) Return the ChildElementAssignment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOne(ConnectionInterface $con = null) Return the first ChildElementAssignment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildElementAssignment requireOneByExamid(int $examID) Return the first ChildElementAssignment filtered by the examID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOneByQuestionid(int $questionID) Return the first ChildElementAssignment filtered by the questionID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOneBySubtask(int $subtask) Return the first ChildElementAssignment filtered by the subtask column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOneByElementid(int $elementID) Return the first ChildElementAssignment filtered by the elementID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOneByUserId(int $user_id) Return the first ChildElementAssignment filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOneByCreatedAt(string $created_at) Return the first ChildElementAssignment filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildElementAssignment requireOneByUpdatedAt(string $updated_at) Return the first ChildElementAssignment filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildElementAssignment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildElementAssignment objects based on current ModelCriteria
 * @method     ChildElementAssignment[]|ObjectCollection findByExamid(int $examID) Return ChildElementAssignment objects filtered by the examID column
 * @method     ChildElementAssignment[]|ObjectCollection findByQuestionid(int $questionID) Return ChildElementAssignment objects filtered by the questionID column
 * @method     ChildElementAssignment[]|ObjectCollection findBySubtask(int $subtask) Return ChildElementAssignment objects filtered by the subtask column
 * @method     ChildElementAssignment[]|ObjectCollection findByElementid(int $elementID) Return ChildElementAssignment objects filtered by the elementID column
 * @method     ChildElementAssignment[]|ObjectCollection findByUserId(int $user_id) Return ChildElementAssignment objects filtered by the user_id column
 * @method     ChildElementAssignment[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildElementAssignment objects filtered by the created_at column
 * @method     ChildElementAssignment[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildElementAssignment objects filtered by the updated_at column
 * @method     ChildElementAssignment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ElementAssignmentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ElementAssignmentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\ElementAssignment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildElementAssignmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildElementAssignmentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildElementAssignmentQuery) {
            return $criteria;
        }
        $query = new ChildElementAssignmentQuery();
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
     * $obj = $c->findPk(array(12, 34, 56), $con);
     * </code>
     *
     * @param array[$examID, $questionID, $subtask] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildElementAssignment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ElementAssignmentTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1], (string) $key[2]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ElementAssignmentTableMap::DATABASE_NAME);
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
     * @return ChildElementAssignment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT examID, questionID, subtask, elementID, user_id, created_at, updated_at FROM elementXquestions WHERE examID = :p0 AND questionID = :p1 AND subtask = :p2';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->bindValue(':p2', $key[2], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildElementAssignment $obj */
            $obj = new ChildElementAssignment();
            $obj->hydrate($row);
            ElementAssignmentTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1], (string) $key[2])));
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
     * @return ChildElementAssignment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ElementAssignmentTableMap::COL_EXAMID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ElementAssignmentTableMap::COL_QUESTIONID, $key[1], Criteria::EQUAL);
        $this->addUsingAlias(ElementAssignmentTableMap::COL_SUBTASK, $key[2], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ElementAssignmentTableMap::COL_EXAMID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ElementAssignmentTableMap::COL_QUESTIONID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $cton2 = $this->getNewCriterion(ElementAssignmentTableMap::COL_SUBTASK, $key[2], Criteria::EQUAL);
            $cton0->addAnd($cton2);
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByExamid($examid = null, $comparison = null)
    {
        if (is_array($examid)) {
            $useMinMax = false;
            if (isset($examid['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_EXAMID, $examid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examid['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_EXAMID, $examid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_EXAMID, $examid, $comparison);
    }

    /**
     * Filter the query on the questionID column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestionid(1234); // WHERE questionID = 1234
     * $query->filterByQuestionid(array(12, 34)); // WHERE questionID IN (12, 34)
     * $query->filterByQuestionid(array('min' => 12)); // WHERE questionID > 12
     * </code>
     *
     * @see       filterByQuestion()
     *
     * @param     mixed $questionid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByQuestionid($questionid = null, $comparison = null)
    {
        if (is_array($questionid)) {
            $useMinMax = false;
            if (isset($questionid['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_QUESTIONID, $questionid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($questionid['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_QUESTIONID, $questionid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_QUESTIONID, $questionid, $comparison);
    }

    /**
     * Filter the query on the subtask column
     *
     * Example usage:
     * <code>
     * $query->filterBySubtask(1234); // WHERE subtask = 1234
     * $query->filterBySubtask(array(12, 34)); // WHERE subtask IN (12, 34)
     * $query->filterBySubtask(array('min' => 12)); // WHERE subtask > 12
     * </code>
     *
     * @param     mixed $subtask The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterBySubtask($subtask = null, $comparison = null)
    {
        if (is_array($subtask)) {
            $useMinMax = false;
            if (isset($subtask['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_SUBTASK, $subtask['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subtask['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_SUBTASK, $subtask['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_SUBTASK, $subtask, $comparison);
    }

    /**
     * Filter the query on the elementID column
     *
     * Example usage:
     * <code>
     * $query->filterByElementid(1234); // WHERE elementID = 1234
     * $query->filterByElementid(array(12, 34)); // WHERE elementID IN (12, 34)
     * $query->filterByElementid(array('min' => 12)); // WHERE elementID > 12
     * </code>
     *
     * @see       filterByElement()
     *
     * @param     mixed $elementid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByElementid($elementid = null, $comparison = null)
    {
        if (is_array($elementid)) {
            $useMinMax = false;
            if (isset($elementid['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_ELEMENTID, $elementid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($elementid['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_ELEMENTID, $elementid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_ELEMENTID, $elementid, $comparison);
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ElementAssignmentTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementAssignmentTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
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
     * Filter the query by a related \Exam object
     *
     * @param \Exam|ObjectCollection $exam The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByExam($exam, $comparison = null)
    {
        if ($exam instanceof \Exam) {
            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_EXAMID, $exam->getId(), $comparison);
        } elseif ($exam instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_EXAMID, $exam->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
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
     * Filter the query by a related \Question object
     *
     * @param \Question|ObjectCollection $question The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByQuestion($question, $comparison = null)
    {
        if ($question instanceof \Question) {
            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_QUESTIONID, $question->getId(), $comparison);
        } elseif ($question instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_QUESTIONID, $question->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByQuestion() only accepts arguments of type \Question or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Question relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function joinQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Question');

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
            $this->addJoinObject($join, 'Question');
        }

        return $this;
    }

    /**
     * Use the Question relation Question object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \QuestionQuery A secondary query class using the current class as primary query
     */
    public function useQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuestion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Question', '\QuestionQuery');
    }

    /**
     * Filter the query by a related \Element object
     *
     * @param \Element|ObjectCollection $element The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function filterByElement($element, $comparison = null)
    {
        if ($element instanceof \Element) {
            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_ELEMENTID, $element->getId(), $comparison);
        } elseif ($element instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementAssignmentTableMap::COL_ELEMENTID, $element->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByElement() only accepts arguments of type \Element or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Element relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function joinElement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Element');

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
            $this->addJoinObject($join, 'Element');
        }

        return $this;
    }

    /**
     * Use the Element relation Element object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ElementQuery A secondary query class using the current class as primary query
     */
    public function useElementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Element', '\ElementQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildElementAssignment $elementAssignment Object to remove from the list of results
     *
     * @return $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function prune($elementAssignment = null)
    {
        if ($elementAssignment) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ElementAssignmentTableMap::COL_EXAMID), $elementAssignment->getExamid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ElementAssignmentTableMap::COL_QUESTIONID), $elementAssignment->getQuestionid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond2', $this->getAliasedColName(ElementAssignmentTableMap::COL_SUBTASK), $elementAssignment->getSubtask(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1', 'pruneCond2'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the elementXquestions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ElementAssignmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ElementAssignmentTableMap::clearInstancePool();
            ElementAssignmentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ElementAssignmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ElementAssignmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ElementAssignmentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ElementAssignmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ElementAssignmentTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ElementAssignmentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ElementAssignmentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ElementAssignmentTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ElementAssignmentTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildElementAssignmentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ElementAssignmentTableMap::COL_CREATED_AT);
    }

} // ElementAssignmentQuery
