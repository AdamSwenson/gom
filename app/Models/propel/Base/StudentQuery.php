<?php

namespace Base;

use \Student as ChildStudent;
use \StudentQuery as ChildStudentQuery;
use \Exception;
use \PDO;
use Map\StudentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'students' table.
 *
 *
 *
 * @method     ChildStudentQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildStudentQuery orderBySid($order = Criteria::ASC) Order by the sid column
 * @method     ChildStudentQuery orderByStudentname($order = Criteria::ASC) Order by the studentName column
 * @method     ChildStudentQuery orderByEmail($order = Criteria::ASC) Order by the emails column
 * @method     ChildStudentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildStudentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildStudentQuery groupById() Group by the id column
 * @method     ChildStudentQuery groupBySid() Group by the sid column
 * @method     ChildStudentQuery groupByStudentname() Group by the studentName column
 * @method     ChildStudentQuery groupByEmail() Group by the emails column
 * @method     ChildStudentQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildStudentQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildStudentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildStudentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildStudentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildStudentQuery leftJoinQuestionScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuestionScore relation
 * @method     ChildStudentQuery rightJoinQuestionScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuestionScore relation
 * @method     ChildStudentQuery innerJoinQuestionScore($relationAlias = null) Adds a INNER JOIN clause to the query using the QuestionScore relation
 *
 * @method     ChildStudentQuery leftJoinElementScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementScore relation
 * @method     ChildStudentQuery rightJoinElementScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementScore relation
 * @method     ChildStudentQuery innerJoinElementScore($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementScore relation
 *
 * @method     ChildStudentQuery leftJoinExamInfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExamInfo relation
 * @method     ChildStudentQuery rightJoinExamInfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExamInfo relation
 * @method     ChildStudentQuery innerJoinExamInfo($relationAlias = null) Adds a INNER JOIN clause to the query using the ExamInfo relation
 *
 * @method     ChildStudentQuery leftJoinStudentClassAssignment($relationAlias = null) Adds a LEFT JOIN clause to the query using the StudentClassAssignment relation
 * @method     ChildStudentQuery rightJoinStudentClassAssignment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StudentClassAssignment relation
 * @method     ChildStudentQuery innerJoinStudentClassAssignment($relationAlias = null) Adds a INNER JOIN clause to the query using the StudentClassAssignment relation
 *
 * @method     ChildStudentQuery leftJoinGradingTime($relationAlias = null) Adds a LEFT JOIN clause to the query using the GradingTime relation
 * @method     ChildStudentQuery rightJoinGradingTime($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GradingTime relation
 * @method     ChildStudentQuery innerJoinGradingTime($relationAlias = null) Adds a INNER JOIN clause to the query using the GradingTime relation
 *
 * @method     ChildStudentQuery leftJoinPseudoID($relationAlias = null) Adds a LEFT JOIN clause to the query using the PseudoID relation
 * @method     ChildStudentQuery rightJoinPseudoID($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PseudoID relation
 * @method     ChildStudentQuery innerJoinPseudoID($relationAlias = null) Adds a INNER JOIN clause to the query using the PseudoID relation
 *
 * @method     \QuestionScoreQuery|\ElementScoreQuery|\ExamInfoQuery|\StudentClassAssignmentQuery|\GradingTimeQuery|\PseudoIDQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildStudent findOne(ConnectionInterface $con = null) Return the first ChildStudent matching the query
 * @method     ChildStudent findOneOrCreate(ConnectionInterface $con = null) Return the first ChildStudent matching the query, or a new ChildStudent object populated from the query conditions when no match is found
 *
 * @method     ChildStudent findOneById(int $id) Return the first ChildStudent filtered by the id column
 * @method     ChildStudent findOneBySid(int $sid) Return the first ChildStudent filtered by the sid column
 * @method     ChildStudent findOneByStudentname(string $studentName) Return the first ChildStudent filtered by the studentName column
 * @method     ChildStudent findOneByEmail(string $emails) Return the first ChildStudent filtered by the emails column
 * @method     ChildStudent findOneByCreatedAt(string $created_at) Return the first ChildStudent filtered by the created_at column
 * @method     ChildStudent findOneByUpdatedAt(string $updated_at) Return the first ChildStudent filtered by the updated_at column *

 * @method     ChildStudent requirePk($key, ConnectionInterface $con = null) Return the ChildStudent by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOne(ConnectionInterface $con = null) Return the first ChildStudent matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStudent requireOneById(int $id) Return the first ChildStudent filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneBySid(int $sid) Return the first ChildStudent filtered by the sid column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByStudentname(string $studentName) Return the first ChildStudent filtered by the studentName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByEmail(string $emails) Return the first ChildStudent filtered by the emails column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByCreatedAt(string $created_at) Return the first ChildStudent filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildStudent requireOneByUpdatedAt(string $updated_at) Return the first ChildStudent filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildStudent[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildStudent objects based on current ModelCriteria
 * @method     ChildStudent[]|ObjectCollection findById(int $id) Return ChildStudent objects filtered by the id column
 * @method     ChildStudent[]|ObjectCollection findBySid(int $sid) Return ChildStudent objects filtered by the sid column
 * @method     ChildStudent[]|ObjectCollection findByStudentname(string $studentName) Return ChildStudent objects filtered by the studentName column
 * @method     ChildStudent[]|ObjectCollection findByEmail(string $emails) Return ChildStudent objects filtered by the emails column
 * @method     ChildStudent[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildStudent objects filtered by the created_at column
 * @method     ChildStudent[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildStudent objects filtered by the updated_at column
 * @method     ChildStudent[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class StudentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\StudentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\Student', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildStudentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildStudentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildStudentQuery) {
            return $criteria;
        }
        $query = new ChildStudentQuery();
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
     * @return ChildStudent|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(StudentTableMap::DATABASE_NAME);
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
     * @return ChildStudent A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, sid, studentName, emails, created_at, updated_at FROM students WHERE id = :p0';
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
            /** @var ChildStudent $obj */
            $obj = new ChildStudent();
            $obj->hydrate($row);
            StudentTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildStudent|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudentTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudentTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the sid column
     *
     * Example usage:
     * <code>
     * $query->filterBySid(1234); // WHERE sid = 1234
     * $query->filterBySid(array(12, 34)); // WHERE sid IN (12, 34)
     * $query->filterBySid(array('min' => 12)); // WHERE sid > 12
     * </code>
     *
     * @param     mixed $sid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterBySid($sid = null, $comparison = null)
    {
        if (is_array($sid)) {
            $useMinMax = false;
            if (isset($sid['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_SID, $sid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sid['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_SID, $sid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_SID, $sid, $comparison);
    }

    /**
     * Filter the query on the studentName column
     *
     * Example usage:
     * <code>
     * $query->filterByStudentname('fooValue');   // WHERE studentName = 'fooValue'
     * $query->filterByStudentname('%fooValue%'); // WHERE studentName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $studentname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByStudentname($studentname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($studentname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $studentname)) {
                $studentname = str_replace('*', '%', $studentname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_STUDENTNAME, $studentname, $comparison);
    }

    /**
     * Filter the query on the emails column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE emails = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE emails LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_EMAIL, $email, $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \QuestionScore object
     *
     * @param \QuestionScore|ObjectCollection $questionScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByQuestionScore($questionScore, $comparison = null)
    {
        if ($questionScore instanceof \QuestionScore) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $questionScore->getStudentid(), $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
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
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByElementScore($elementScore, $comparison = null)
    {
        if ($elementScore instanceof \ElementScore) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $elementScore->getStudentid(), $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
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
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByExamInfo($examInfo, $comparison = null)
    {
        if ($examInfo instanceof \ExamInfo) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $examInfo->getStudentid(), $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
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
     * Filter the query by a related \StudentClassAssignment object
     *
     * @param \StudentClassAssignment|ObjectCollection $studentClassAssignment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByStudentClassAssignment($studentClassAssignment, $comparison = null)
    {
        if ($studentClassAssignment instanceof \StudentClassAssignment) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $studentClassAssignment->getStudentid(), $comparison);
        } elseif ($studentClassAssignment instanceof ObjectCollection) {
            return $this
                ->useStudentClassAssignmentQuery()
                ->filterByPrimaryKeys($studentClassAssignment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudentClassAssignment() only accepts arguments of type \StudentClassAssignment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StudentClassAssignment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function joinStudentClassAssignment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StudentClassAssignment');

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
            $this->addJoinObject($join, 'StudentClassAssignment');
        }

        return $this;
    }

    /**
     * Use the StudentClassAssignment relation StudentClassAssignment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StudentClassAssignmentQuery A secondary query class using the current class as primary query
     */
    public function useStudentClassAssignmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudentClassAssignment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StudentClassAssignment', '\StudentClassAssignmentQuery');
    }

    /**
     * Filter the query by a related \GradingTime object
     *
     * @param \GradingTime|ObjectCollection $gradingTime the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByGradingTime($gradingTime, $comparison = null)
    {
        if ($gradingTime instanceof \GradingTime) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $gradingTime->getStudentid(), $comparison);
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
     * @return $this|ChildStudentQuery The current query, for fluid interface
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
     * Filter the query by a related \PseudoID object
     *
     * @param \PseudoID|ObjectCollection $pseudoID the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByPseudoID($pseudoID, $comparison = null)
    {
        if ($pseudoID instanceof \PseudoID) {
            return $this
                ->addUsingAlias(StudentTableMap::COL_ID, $pseudoID->getStudentid(), $comparison);
        } elseif ($pseudoID instanceof ObjectCollection) {
            return $this
                ->usePseudoIDQuery()
                ->filterByPrimaryKeys($pseudoID->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPseudoID() only accepts arguments of type \PseudoID or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PseudoID relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function joinPseudoID($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PseudoID');

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
            $this->addJoinObject($join, 'PseudoID');
        }

        return $this;
    }

    /**
     * Use the PseudoID relation PseudoID object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PseudoIDQuery A secondary query class using the current class as primary query
     */
    public function usePseudoIDQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPseudoID($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PseudoID', '\PseudoIDQuery');
    }

    /**
     * Filter the query by a related Kumi object
     * using the studentsXclasses table as cross reference
     *
     * @param Kumi $kumi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildStudentQuery The current query, for fluid interface
     */
    public function filterByKumi($kumi, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useStudentClassAssignmentQuery()
            ->filterByKumi($kumi, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildStudent $student Object to remove from the list of results
     *
     * @return $this|ChildStudentQuery The current query, for fluid interface
     */
    public function prune($student = null)
    {
        if ($student) {
            $this->addUsingAlias(StudentTableMap::COL_ID, $student->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the students table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            StudentTableMap::clearInstancePool();
            StudentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(StudentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(StudentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            StudentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            StudentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(StudentTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(StudentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(StudentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(StudentTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(StudentTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildStudentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(StudentTableMap::COL_CREATED_AT);
    }

} // StudentQuery
