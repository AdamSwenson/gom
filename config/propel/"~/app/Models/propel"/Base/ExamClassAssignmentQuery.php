<?php

namespace Base;

use \ExamClassAssignment as ChildExamClassAssignment;
use \ExamClassAssignmentQuery as ChildExamClassAssignmentQuery;
use \Exception;
use \PDO;
use Map\ExamClassAssignmentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'examsXclasses' table.
 *
 *
 *
 * @method     ChildExamClassAssignmentQuery orderByClassid($order = Criteria::ASC) Order by the classID column
 * @method     ChildExamClassAssignmentQuery orderByExamid($order = Criteria::ASC) Order by the examID column
 * @method     ChildExamClassAssignmentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildExamClassAssignmentQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildExamClassAssignmentQuery groupByClassid() Group by the classID column
 * @method     ChildExamClassAssignmentQuery groupByExamid() Group by the examID column
 * @method     ChildExamClassAssignmentQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildExamClassAssignmentQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildExamClassAssignmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildExamClassAssignmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildExamClassAssignmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildExamClassAssignmentQuery leftJoinExam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exam relation
 * @method     ChildExamClassAssignmentQuery rightJoinExam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exam relation
 * @method     ChildExamClassAssignmentQuery innerJoinExam($relationAlias = null) Adds a INNER JOIN clause to the query using the Exam relation
 *
 * @method     ChildExamClassAssignmentQuery leftJoinKumi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Kumi relation
 * @method     ChildExamClassAssignmentQuery rightJoinKumi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Kumi relation
 * @method     ChildExamClassAssignmentQuery innerJoinKumi($relationAlias = null) Adds a INNER JOIN clause to the query using the Kumi relation
 *
 * @method     \ExamQuery|\KumiQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildExamClassAssignment findOne(ConnectionInterface $con = null) Return the first ChildExamClassAssignment matching the query
 * @method     ChildExamClassAssignment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildExamClassAssignment matching the query, or a new ChildExamClassAssignment object populated from the query conditions when no match is found
 *
 * @method     ChildExamClassAssignment findOneByClassid(int $classID) Return the first ChildExamClassAssignment filtered by the classID column
 * @method     ChildExamClassAssignment findOneByExamid(int $examID) Return the first ChildExamClassAssignment filtered by the examID column
 * @method     ChildExamClassAssignment findOneByCreatedAt(string $created_at) Return the first ChildExamClassAssignment filtered by the created_at column
 * @method     ChildExamClassAssignment findOneByUpdatedAt(string $updated_at) Return the first ChildExamClassAssignment filtered by the updated_at column *

 * @method     ChildExamClassAssignment requirePk($key, ConnectionInterface $con = null) Return the ChildExamClassAssignment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamClassAssignment requireOne(ConnectionInterface $con = null) Return the first ChildExamClassAssignment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExamClassAssignment requireOneByClassid(int $classID) Return the first ChildExamClassAssignment filtered by the classID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamClassAssignment requireOneByExamid(int $examID) Return the first ChildExamClassAssignment filtered by the examID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamClassAssignment requireOneByCreatedAt(string $created_at) Return the first ChildExamClassAssignment filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildExamClassAssignment requireOneByUpdatedAt(string $updated_at) Return the first ChildExamClassAssignment filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildExamClassAssignment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildExamClassAssignment objects based on current ModelCriteria
 * @method     ChildExamClassAssignment[]|ObjectCollection findByClassid(int $classID) Return ChildExamClassAssignment objects filtered by the classID column
 * @method     ChildExamClassAssignment[]|ObjectCollection findByExamid(int $examID) Return ChildExamClassAssignment objects filtered by the examID column
 * @method     ChildExamClassAssignment[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildExamClassAssignment objects filtered by the created_at column
 * @method     ChildExamClassAssignment[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildExamClassAssignment objects filtered by the updated_at column
 * @method     ChildExamClassAssignment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ExamClassAssignmentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ExamClassAssignmentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\ExamClassAssignment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildExamClassAssignmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildExamClassAssignmentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildExamClassAssignmentQuery) {
            return $criteria;
        }
        $query = new ChildExamClassAssignmentQuery();
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
     * @param array[$classID, $examID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildExamClassAssignment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExamClassAssignmentTableMap::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ExamClassAssignmentTableMap::DATABASE_NAME);
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
     * @return ChildExamClassAssignment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT classID, examID, created_at, updated_at FROM examsXclasses WHERE classID = :p0 AND examID = :p1';
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
            /** @var ChildExamClassAssignment $obj */
            $obj = new ChildExamClassAssignment();
            $obj->hydrate($row);
            ExamClassAssignmentTableMap::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return ChildExamClassAssignment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CLASSID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(ExamClassAssignmentTableMap::COL_EXAMID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(ExamClassAssignmentTableMap::COL_CLASSID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(ExamClassAssignmentTableMap::COL_EXAMID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the classID column
     *
     * Example usage:
     * <code>
     * $query->filterByClassid(1234); // WHERE classID = 1234
     * $query->filterByClassid(array(12, 34)); // WHERE classID IN (12, 34)
     * $query->filterByClassid(array('min' => 12)); // WHERE classID > 12
     * </code>
     *
     * @see       filterByKumi()
     *
     * @param     mixed $classid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByClassid($classid = null, $comparison = null)
    {
        if (is_array($classid)) {
            $useMinMax = false;
            if (isset($classid['min'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CLASSID, $classid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($classid['max'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CLASSID, $classid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CLASSID, $classid, $comparison);
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
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByExamid($examid = null, $comparison = null)
    {
        if (is_array($examid)) {
            $useMinMax = false;
            if (isset($examid['min'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_EXAMID, $examid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($examid['max'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_EXAMID, $examid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamClassAssignmentTableMap::COL_EXAMID, $examid, $comparison);
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
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(ExamClassAssignmentTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExamClassAssignmentTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Exam object
     *
     * @param \Exam|ObjectCollection $exam The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByExam($exam, $comparison = null)
    {
        if ($exam instanceof \Exam) {
            return $this
                ->addUsingAlias(ExamClassAssignmentTableMap::COL_EXAMID, $exam->getId(), $comparison);
        } elseif ($exam instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamClassAssignmentTableMap::COL_EXAMID, $exam->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
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
     * Filter the query by a related \Kumi object
     *
     * @param \Kumi|ObjectCollection $kumi The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function filterByKumi($kumi, $comparison = null)
    {
        if ($kumi instanceof \Kumi) {
            return $this
                ->addUsingAlias(ExamClassAssignmentTableMap::COL_CLASSID, $kumi->getId(), $comparison);
        } elseif ($kumi instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExamClassAssignmentTableMap::COL_CLASSID, $kumi->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByKumi() only accepts arguments of type \Kumi or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Kumi relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function joinKumi($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Kumi');

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
            $this->addJoinObject($join, 'Kumi');
        }

        return $this;
    }

    /**
     * Use the Kumi relation Kumi object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \KumiQuery A secondary query class using the current class as primary query
     */
    public function useKumiQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinKumi($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Kumi', '\KumiQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildExamClassAssignment $examClassAssignment Object to remove from the list of results
     *
     * @return $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function prune($examClassAssignment = null)
    {
        if ($examClassAssignment) {
            $this->addCond('pruneCond0', $this->getAliasedColName(ExamClassAssignmentTableMap::COL_CLASSID), $examClassAssignment->getClassid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(ExamClassAssignmentTableMap::COL_EXAMID), $examClassAssignment->getExamid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the examsXclasses table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamClassAssignmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExamClassAssignmentTableMap::clearInstancePool();
            ExamClassAssignmentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ExamClassAssignmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ExamClassAssignmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ExamClassAssignmentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ExamClassAssignmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(ExamClassAssignmentTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(ExamClassAssignmentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(ExamClassAssignmentTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(ExamClassAssignmentTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(ExamClassAssignmentTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildExamClassAssignmentQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(ExamClassAssignmentTableMap::COL_CREATED_AT);
    }

} // ExamClassAssignmentQuery
