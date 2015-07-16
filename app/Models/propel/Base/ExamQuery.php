<?php

namespace Base;

use \Exam as ChildExam;
use \ExamQuery as ChildExamQuery;
use \Exception;
use \PDO;
use Map\ExamTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'exams' table.
 *
 *
 *
 * @method     ChildExamQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildExamQuery orderByExamterm($order = Criteria::ASC) Order by the examTerm column
 * @method     ChildExamQuery orderByExamtopic($order = Criteria::ASC) Order by the examTopic column
 * @method     ChildExamQuery orderByExamyear($order = Criteria::ASC) Order by the examYear column
 * @method     ChildExamQuery orderByLocked($order = Criteria::ASC) Order by the locked column
 * @method     ChildExamQuery orderByReleased($order = Criteria::ASC) Order by the released column
 * @method     ChildExamQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildExamQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildExamQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildExamQuery groupById() Group by the id column
 * @method     ChildExamQuery groupByExamterm() Group by the examTerm column
 * @method     ChildExamQuery groupByExamtopic() Group by the examTopic column
 * @method     ChildExamQuery groupByExamyear() Group by the examYear column
 * @method     ChildExamQuery groupByLocked() Group by the locked column
 * @method     ChildExamQuery groupByReleased() Group by the released column
 * @method     ChildExamQuery groupByUserId() Group by the user_id column
 * @method     ChildExamQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildExamQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildExamQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExamQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExamQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExamQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildExamQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildExamQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     ChildExamQuery leftJoinTerm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Term relation
 * @method     ChildExamQuery rightJoinTerm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Term relation
 * @method     ChildExamQuery innerJoinTerm($relationAlias = null) Adds a INNER JOIN clause to the query using the Term relation
 *
 * @method     ChildExamQuery leftJoinTopic($relationAlias = null) Adds a LEFT JOIN clause to the query using the Topic relation
 * @method     ChildExamQuery rightJoinTopic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Topic relation
 * @method     ChildExamQuery innerJoinTopic($relationAlias = null) Adds a INNER JOIN clause to the query using the Topic relation
 *
 * @method     ChildExamQuery leftJoinYear($relationAlias = null) Adds a LEFT JOIN clause to the query using the Year relation
 * @method     ChildExamQuery rightJoinYear($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Year relation
 * @method     ChildExamQuery innerJoinYear($relationAlias = null) Adds a INNER JOIN clause to the query using the Year relation
 *
 * @method     ChildExamQuery leftJoinQuestionScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuestionScore relation
 * @method     ChildExamQuery rightJoinQuestionScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuestionScore relation
 * @method     ChildExamQuery innerJoinQuestionScore($relationAlias = null) Adds a INNER JOIN clause to the query using the QuestionScore relation
 *
 * @method     ChildExamQuery leftJoinElementScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementScore relation
 * @method     ChildExamQuery rightJoinElementScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementScore relation
 * @method     ChildExamQuery innerJoinElementScore($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementScore relation
 *
 * @method     ChildExamQuery leftJoinExamInfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExamInfo relation
 * @method     ChildExamQuery rightJoinExamInfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExamInfo relation
 * @method     ChildExamQuery innerJoinExamInfo($relationAlias = null) Adds a INNER JOIN clause to the query using the ExamInfo relation
 *
 * @method     ChildExamQuery leftJoinGradingTime($relationAlias = null) Adds a LEFT JOIN clause to the query using the GradingTime relation
 * @method     ChildExamQuery rightJoinGradingTime($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GradingTime relation
 * @method     ChildExamQuery innerJoinGradingTime($relationAlias = null) Adds a INNER JOIN clause to the query using the GradingTime relation
 *
 * @method     ChildExamQuery leftJoinGroupTime($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupTime relation
 * @method     ChildExamQuery rightJoinGroupTime($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupTime relation
 * @method     ChildExamQuery innerJoinGroupTime($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupTime relation
 *
 * @method     \UserQuery|\TermQuery|\TopicQuery|\YearQuery|\QuestionScoreQuery|\ElementScoreQuery|\ExamInfoQuery|\GradingTimeQuery|\GroupTimeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildExam findOne(ConnectionInterface $con = null) Return the first ChildExam matching the query
 * @method     ChildExam findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExam matching the query, or a new ChildExam object populated from the query conditions when no match is found
 *
 * @method     ChildExam findOneById(int $id) Return the first ChildExam filtered by the id column
 * @method     ChildExam findOneByExamterm(string $examTerm) Return the first ChildExam filtered by the examTerm column
 * @method     ChildExam findOneByExamtopic(string $examTopic) Return the first ChildExam filtered by the examTopic column
 * @method     ChildExam findOneByExamyear(int $examYear) Return the first ChildExam filtered by the examYear column
 * @method     ChildExam findOneByLocked(int $locked) Return the first ChildExam filtered by the locked column
 * @method     ChildExam findOneByReleased(int $released) Return the first ChildExam filtered by the released column
 * @method     ChildExam findOneByUserId(int $user_id) Return the first ChildExam filtered by the user_id column
 * @method     ChildExam findOneByCreatedAt(string $created_at) Return the first ChildExam filtered by the created_at column
 * @method     ChildExam findOneByUpdatedAt(string $updated_at) Return the first ChildExam filtered by the updated_at column *

 * @method     ChildExam requirePk($key, ConnectionInterface $con = null) Return the ChildExam by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOne(ConnectionInterface $con = null) Return the first ChildExam matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExam requireOneById(int $id) Return the first ChildExam filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByExamterm(string $examTerm) Return the first ChildExam filtered by the examTerm column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByExamtopic(string $examTopic) Return the first ChildExam filtered by the examTopic column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByExamyear(int $examYear) Return the first ChildExam filtered by the examYear column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByLocked(int $locked) Return the first ChildExam filtered by the locked column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByReleased(int $released) Return the first ChildExam filtered by the released column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByUserId(int $user_id) Return the first ChildExam filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByCreatedAt(string $created_at) Return the first ChildExam filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExam requireOneByUpdatedAt(string $updated_at) Return the first ChildExam filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExam[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExam objects based on current ModelCriteria
 * @method     ChildExam[]|ObjectCollection findById(int $id) Return ChildExam objects filtered by the id column
 * @method     ChildExam[]|ObjectCollection findByExamterm(string $examTerm) Return ChildExam objects filtered by the examTerm column
 * @method     ChildExam[]|ObjectCollection findByExamtopic(string $examTopic) Return ChildExam objects filtered by the examTopic column
 * @method     ChildExam[]|ObjectCollection findByExamyear(int $examYear) Return ChildExam objects filtered by the examYear column
 * @method     ChildExam[]|ObjectCollection findByLocked(int $locked) Return ChildExam objects filtered by the locked column
 * @method     ChildExam[]|ObjectCollection findByReleased(int $released) Return ChildExam objects filtered by the released column
 * @method     ChildExam[]|ObjectCollection findByUserId(int $user_id) Return ChildExam objects filtered by the user_id column
 * @method     ChildExam[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildExam objects filtered by the created_at column
 * @method     ChildExam[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildExam objects filtered by the updated_at column
 * @method     ChildExam[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExamQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ExamQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\Exam', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExamQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExamQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExamQuery) {
            return $criteria;
        }
        $query = new ChildExamQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildExam|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExamTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExamTableMap::DATABASE_NAME);
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
     * @return ChildExam A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, examTerm, examTopic, examYear, locked, released, user_id, created_at, updated_at FROM exams WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildExam $obj */
            $obj = new ChildExam();
            $obj->hydrate($row);
            ExamTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildExam|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExamTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExamTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the examTerm column
     *
     * Example usage:
     * <code>
     * $query->filterByExamterm('fooValue');   // WHERE examTerm = 'fooValue'
     * $query->filterByExamterm('%fooValue%'); // WHERE examTerm LIKE '%fooValue%'
     * </code>
     *
     * @param     string $examterm The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByExamterm($examterm = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($examterm)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $examterm)) {
                $examterm = str_replace('*', '%', $examterm);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_EXAMTERM, $examterm, $comparison);
    }

    /**
     * Filter the query on the examTopic column
     *
     * Example usage:
     * <code>
     * $query->filterByExamtopic('fooValue');   // WHERE examTopic = 'fooValue'
     * $query->filterByExamtopic('%fooValue%'); // WHERE examTopic LIKE '%fooValue%'
     * </code>
     *
     * @param     string $examtopic The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByExamtopic($examtopic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($examtopic)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $examtopic)) {
                $examtopic = str_replace('*', '%', $examtopic);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_EXAMTOPIC, $examtopic, $comparison);
    }

    /**
     * Filter the query on the examYear column
     *
     * Example usage:
     * <code>
     * $query->filterByExamyear(1234); // WHERE examYear = 1234
     * $query->filterByExamyear(array(12, 34)); // WHERE examYear IN (12, 34)
     * $query->filterByExamyear(array('min' => 12)); // WHERE examYear > 12
     * </code>
     *
     * @see       filterByYear()
     *
     * @param     mixed $examyear The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByExamyear($examyear = null, $comparison = null)
    {
        if (is_array($examyear)) {
            $useMinMax = false;
            if (isset($examyear['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_EXAMYEAR, $examyear['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examyear['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_EXAMYEAR, $examyear['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_EXAMYEAR, $examyear, $comparison);
    }

    /**
     * Filter the query on the locked column
     *
     * Example usage:
     * <code>
     * $query->filterByLocked(1234); // WHERE locked = 1234
     * $query->filterByLocked(array(12, 34)); // WHERE locked IN (12, 34)
     * $query->filterByLocked(array('min' => 12)); // WHERE locked > 12
     * </code>
     *
     * @param     mixed $locked The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByLocked($locked = null, $comparison = null)
    {
        if (is_array($locked)) {
            $useMinMax = false;
            if (isset($locked['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_LOCKED, $locked['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locked['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_LOCKED, $locked['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_LOCKED, $locked, $comparison);
    }

    /**
     * Filter the query on the released column
     *
     * Example usage:
     * <code>
     * $query->filterByReleased(1234); // WHERE released = 1234
     * $query->filterByReleased(array(12, 34)); // WHERE released IN (12, 34)
     * $query->filterByReleased(array('min' => 12)); // WHERE released > 12
     * </code>
     *
     * @param     mixed $released The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByReleased($released = null, $comparison = null)
    {
        if (is_array($released)) {
            $useMinMax = false;
            if (isset($released['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_RELEASED, $released['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($released['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_RELEASED, $released['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_RELEASED, $released, $comparison);
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
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ExamTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ExamTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildExamQuery The current query, for fluid interface
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
     * Filter the query by a related \Term object
     *
     * @param \Term|ObjectCollection $term The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByTerm($term, $comparison = null)
    {
        if ($term instanceof \Term) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_EXAMTERM, $term->getContent(), $comparison);
        } elseif ($term instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamTableMap::COL_EXAMTERM, $term->toKeyValue('PrimaryKey', 'Content'), $comparison);
        } else {
            throw new PropelException('filterByTerm() only accepts arguments of type \Term or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Term relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinTerm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Term');

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
            $this->addJoinObject($join, 'Term');
        }

        return $this;
    }

    /**
     * Use the Term relation Term object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TermQuery A secondary query class using the current class as primary query
     */
    public function useTermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTerm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Term', '\TermQuery');
    }

    /**
     * Filter the query by a related \Topic object
     *
     * @param \Topic|ObjectCollection $topic The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByTopic($topic, $comparison = null)
    {
        if ($topic instanceof \Topic) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_EXAMTOPIC, $topic->getContent(), $comparison);
        } elseif ($topic instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamTableMap::COL_EXAMTOPIC, $topic->toKeyValue('PrimaryKey', 'Content'), $comparison);
        } else {
            throw new PropelException('filterByTopic() only accepts arguments of type \Topic or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Topic relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinTopic($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Topic');

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
            $this->addJoinObject($join, 'Topic');
        }

        return $this;
    }

    /**
     * Use the Topic relation Topic object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TopicQuery A secondary query class using the current class as primary query
     */
    public function useTopicQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTopic($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Topic', '\TopicQuery');
    }

    /**
     * Filter the query by a related \Year object
     *
     * @param \Year|ObjectCollection $year The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByYear($year, $comparison = null)
    {
        if ($year instanceof \Year) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_EXAMYEAR, $year->getContent(), $comparison);
        } elseif ($year instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamTableMap::COL_EXAMYEAR, $year->toKeyValue('PrimaryKey', 'Content'), $comparison);
        } else {
            throw new PropelException('filterByYear() only accepts arguments of type \Year or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Year relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinYear($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Year');

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
            $this->addJoinObject($join, 'Year');
        }

        return $this;
    }

    /**
     * Use the Year relation Year object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \YearQuery A secondary query class using the current class as primary query
     */
    public function useYearQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinYear($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Year', '\YearQuery');
    }

    /**
     * Filter the query by a related \QuestionScore object
     *
     * @param \QuestionScore|ObjectCollection $questionScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByQuestionScore($questionScore, $comparison = null)
    {
        if ($questionScore instanceof \QuestionScore) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_ID, $questionScore->getExamid(), $comparison);
        } elseif ($questionScore instanceof ObjectCollection) {
            return $this
                ->useQuestionScoreQuery()
                ->filterByPrimaryKeys($questionScore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuestionScore() only accepts arguments of type \QuestionScore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the QuestionScore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinQuestionScore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('QuestionScore');

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
            $this->addJoinObject($join, 'QuestionScore');
        }

        return $this;
    }

    /**
     * Use the QuestionScore relation QuestionScore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \QuestionScoreQuery A secondary query class using the current class as primary query
     */
    public function useQuestionScoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuestionScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'QuestionScore', '\QuestionScoreQuery');
    }

    /**
     * Filter the query by a related \ElementScore object
     *
     * @param \ElementScore|ObjectCollection $elementScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByElementScore($elementScore, $comparison = null)
    {
        if ($elementScore instanceof \ElementScore) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_ID, $elementScore->getExamid(), $comparison);
        } elseif ($elementScore instanceof ObjectCollection) {
            return $this
                ->useElementScoreQuery()
                ->filterByPrimaryKeys($elementScore->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementScore() only accepts arguments of type \ElementScore or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementScore relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinElementScore($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementScore');

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
            $this->addJoinObject($join, 'ElementScore');
        }

        return $this;
    }

    /**
     * Use the ElementScore relation ElementScore object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ElementScoreQuery A secondary query class using the current class as primary query
     */
    public function useElementScoreQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementScore($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementScore', '\ElementScoreQuery');
    }

    /**
     * Filter the query by a related \ExamInfo object
     *
     * @param \ExamInfo|ObjectCollection $examInfo the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByExamInfo($examInfo, $comparison = null)
    {
        if ($examInfo instanceof \ExamInfo) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_ID, $examInfo->getExamid(), $comparison);
        } elseif ($examInfo instanceof ObjectCollection) {
            return $this
                ->useExamInfoQuery()
                ->filterByPrimaryKeys($examInfo->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExamInfo() only accepts arguments of type \ExamInfo or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ExamInfo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinExamInfo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ExamInfo');

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
            $this->addJoinObject($join, 'ExamInfo');
        }

        return $this;
    }

    /**
     * Use the ExamInfo relation ExamInfo object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ExamInfoQuery A secondary query class using the current class as primary query
     */
    public function useExamInfoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExamInfo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ExamInfo', '\ExamInfoQuery');
    }

    /**
     * Filter the query by a related \GradingTime object
     *
     * @param \GradingTime|ObjectCollection $gradingTime the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByGradingTime($gradingTime, $comparison = null)
    {
        if ($gradingTime instanceof \GradingTime) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_ID, $gradingTime->getExamid(), $comparison);
        } elseif ($gradingTime instanceof ObjectCollection) {
            return $this
                ->useGradingTimeQuery()
                ->filterByPrimaryKeys($gradingTime->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGradingTime() only accepts arguments of type \GradingTime or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GradingTime relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinGradingTime($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GradingTime');

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
            $this->addJoinObject($join, 'GradingTime');
        }

        return $this;
    }

    /**
     * Use the GradingTime relation GradingTime object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GradingTimeQuery A secondary query class using the current class as primary query
     */
    public function useGradingTimeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGradingTime($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GradingTime', '\GradingTimeQuery');
    }

    /**
     * Filter the query by a related \GroupTime object
     *
     * @param \GroupTime|ObjectCollection $groupTime the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildExamQuery The current query, for fluid interface
     */
    public function filterByGroupTime($groupTime, $comparison = null)
    {
        if ($groupTime instanceof \GroupTime) {
            return $this
                ->addUsingAlias(ExamTableMap::COL_ID, $groupTime->getExamid(), $comparison);
        } elseif ($groupTime instanceof ObjectCollection) {
            return $this
                ->useGroupTimeQuery()
                ->filterByPrimaryKeys($groupTime->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGroupTime() only accepts arguments of type \GroupTime or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the GroupTime relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function joinGroupTime($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('GroupTime');

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
            $this->addJoinObject($join, 'GroupTime');
        }

        return $this;
    }

    /**
     * Use the GroupTime relation GroupTime object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \GroupTimeQuery A secondary query class using the current class as primary query
     */
    public function useGroupTimeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGroupTime($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'GroupTime', '\GroupTimeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildExam $exam Object to remove from the list of results
     *
     * @return $this|ChildExamQuery The current query, for fluid interface
     */
    public function prune($exam = null)
    {
        if ($exam) {
            $this->addUsingAlias(ExamTableMap::COL_ID, $exam->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the exams table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExamTableMap::clearInstancePool();
            ExamTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ExamTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExamTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ExamTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ExamTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildExamQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ExamTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildExamQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ExamTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildExamQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ExamTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildExamQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ExamTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildExamQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ExamTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildExamQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ExamTableMap::COL_CREATED_AT);
    }

} // ExamQuery
