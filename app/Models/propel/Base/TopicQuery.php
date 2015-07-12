<?php

namespace Base;

use \Topic as ChildTopic;
use \TopicQuery as ChildTopicQuery;
use \Exception;
use \PDO;
use Map\TopicTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'r_examTopics' table.
 *
 *
 *
 * @method     ChildTopicQuery orderByContent($order = Criteria::ASC) Order by the content column
 * @method     ChildTopicQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTopicQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildTopicQuery groupByContent() Group by the content column
 * @method     ChildTopicQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTopicQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildTopicQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTopicQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTopicQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTopicQuery leftJoinExam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exam relation
 * @method     ChildTopicQuery rightJoinExam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exam relation
 * @method     ChildTopicQuery innerJoinExam($relationAlias = null) Adds a INNER JOIN clause to the query using the Exam relation
 *
 * @method     \ExamQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTopic findOne(ConnectionInterface $con = null) Return the first ChildTopic matching the query
 * @method     ChildTopic findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTopic matching the query, or a new ChildTopic object populated from the query conditions when no match is found
 *
 * @method     ChildTopic findOneByContent(string $content) Return the first ChildTopic filtered by the content column
 * @method     ChildTopic findOneByCreatedAt(string $created_at) Return the first ChildTopic filtered by the created_at column
 * @method     ChildTopic findOneByUpdatedAt(string $updated_at) Return the first ChildTopic filtered by the updated_at column *

 * @method     ChildTopic requirePk($key, ConnectionInterface $con = null) Return the ChildTopic by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTopic requireOne(ConnectionInterface $con = null) Return the first ChildTopic matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTopic requireOneByContent(string $content) Return the first ChildTopic filtered by the content column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTopic requireOneByCreatedAt(string $created_at) Return the first ChildTopic filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTopic requireOneByUpdatedAt(string $updated_at) Return the first ChildTopic filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTopic[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTopic objects based on current ModelCriteria
 * @method     ChildTopic[]|ObjectCollection findByContent(string $content) Return ChildTopic objects filtered by the content column
 * @method     ChildTopic[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTopic objects filtered by the created_at column
 * @method     ChildTopic[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildTopic objects filtered by the updated_at column
 * @method     ChildTopic[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TopicQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\TopicQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\Topic', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTopicQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTopicQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTopicQuery) {
            return $criteria;
        }
        $query = new ChildTopicQuery();
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
     * @return ChildTopic|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TopicTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TopicTableMap::DATABASE_NAME);
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
     * @return ChildTopic A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT content, created_at, updated_at FROM r_examTopics WHERE content = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildTopic $obj */
            $obj = new ChildTopic();
            $obj->hydrate($row);
            TopicTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTopic|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTopicQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TopicTableMap::COL_CONTENT, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTopicQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TopicTableMap::COL_CONTENT, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the content column
     *
     * Example usage:
     * <code>
     * $query->filterByContent('fooValue');   // WHERE content = 'fooValue'
     * $query->filterByContent('%fooValue%'); // WHERE content LIKE '%fooValue%'
     * </code>
     *
     * @param     string $content The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTopicQuery The current query, for fluid interface
     */
    public function filterByContent($content = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($content)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $content)) {
                $content = str_replace('*', '%', $content);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TopicTableMap::COL_CONTENT, $content, $comparison);
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
     * @return $this|ChildTopicQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TopicTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TopicTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TopicTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTopicQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(TopicTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(TopicTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TopicTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Exam object
     *
     * @param \Exam|ObjectCollection $exam the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTopicQuery The current query, for fluid interface
     */
    public function filterByExam($exam, $comparison = null)
    {
        if ($exam instanceof \Exam) {
            return $this
                ->addUsingAlias(TopicTableMap::COL_CONTENT, $exam->getExamtopic(), $comparison);
        } elseif ($exam instanceof ObjectCollection) {
            return $this
                ->useExamQuery()
                ->filterByPrimaryKeys($exam->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildTopicQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildTopic $topic Object to remove from the list of results
     *
     * @return $this|ChildTopicQuery The current query, for fluid interface
     */
    public function prune($topic = null)
    {
        if ($topic) {
            $this->addUsingAlias(TopicTableMap::COL_CONTENT, $topic->getContent(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the r_examTopics table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TopicTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TopicTableMap::clearInstancePool();
            TopicTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TopicTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TopicTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TopicTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TopicTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildTopicQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(TopicTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildTopicQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(TopicTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildTopicQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(TopicTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildTopicQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(TopicTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildTopicQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(TopicTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildTopicQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(TopicTableMap::COL_CREATED_AT);
    }

} // TopicQuery
