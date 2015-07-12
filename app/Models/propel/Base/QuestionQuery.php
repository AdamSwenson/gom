<?php

namespace Base;

use \Question as ChildQuestion;
use \QuestionQuery as ChildQuestionQuery;
use \Exception;
use \PDO;
use Map\QuestionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'questions' table.
 *
 *
 *
 * @method     ChildQuestionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildQuestionQuery orderByQuestiontext($order = Criteria::ASC) Order by the questionText column
 * @method     ChildQuestionQuery orderByQuestionname($order = Criteria::ASC) Order by the questionName column
 * @method     ChildQuestionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildQuestionQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildQuestionQuery groupById() Group by the id column
 * @method     ChildQuestionQuery groupByQuestiontext() Group by the questionText column
 * @method     ChildQuestionQuery groupByQuestionname() Group by the questionName column
 * @method     ChildQuestionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildQuestionQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildQuestionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildQuestionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildQuestionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildQuestionQuery leftJoinQuestionScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuestionScore relation
 * @method     ChildQuestionQuery rightJoinQuestionScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuestionScore relation
 * @method     ChildQuestionQuery innerJoinQuestionScore($relationAlias = null) Adds a INNER JOIN clause to the query using the QuestionScore relation
 *
 * @method     ChildQuestionQuery leftJoinQuestionAssigner($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuestionAssigner relation
 * @method     ChildQuestionQuery rightJoinQuestionAssigner($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuestionAssigner relation
 * @method     ChildQuestionQuery innerJoinQuestionAssigner($relationAlias = null) Adds a INNER JOIN clause to the query using the QuestionAssigner relation
 *
 * @method     ChildQuestionQuery leftJoinElementAssignment($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementAssignment relation
 * @method     ChildQuestionQuery rightJoinElementAssignment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementAssignment relation
 * @method     ChildQuestionQuery innerJoinElementAssignment($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementAssignment relation
 *
 * @method     ChildQuestionQuery leftJoinTaggedQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the TaggedQuestion relation
 * @method     ChildQuestionQuery rightJoinTaggedQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TaggedQuestion relation
 * @method     ChildQuestionQuery innerJoinTaggedQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the TaggedQuestion relation
 *
 * @method     \QuestionScoreQuery|\QuestionAssignerQuery|\ElementAssignmentQuery|\TaggedQuestionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildQuestion findOne(ConnectionInterface $con = null) Return the first ChildQuestion matching the query
 * @method     ChildQuestion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildQuestion matching the query, or a new ChildQuestion object populated from the query conditions when no match is found
 *
 * @method     ChildQuestion findOneById(int $id) Return the first ChildQuestion filtered by the id column
 * @method     ChildQuestion findOneByQuestiontext(string $questionText) Return the first ChildQuestion filtered by the questionText column
 * @method     ChildQuestion findOneByQuestionname(string $questionName) Return the first ChildQuestion filtered by the questionName column
 * @method     ChildQuestion findOneByCreatedAt(string $created_at) Return the first ChildQuestion filtered by the created_at column
 * @method     ChildQuestion findOneByUpdatedAt(string $updated_at) Return the first ChildQuestion filtered by the updated_at column *

 * @method     ChildQuestion requirePk($key, ConnectionInterface $con = null) Return the ChildQuestion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestion requireOne(ConnectionInterface $con = null) Return the first ChildQuestion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildQuestion requireOneById(int $id) Return the first ChildQuestion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestion requireOneByQuestiontext(string $questionText) Return the first ChildQuestion filtered by the questionText column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestion requireOneByQuestionname(string $questionName) Return the first ChildQuestion filtered by the questionName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestion requireOneByCreatedAt(string $created_at) Return the first ChildQuestion filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildQuestion requireOneByUpdatedAt(string $updated_at) Return the first ChildQuestion filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildQuestion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildQuestion objects based on current ModelCriteria
 * @method     ChildQuestion[]|ObjectCollection findById(int $id) Return ChildQuestion objects filtered by the id column
 * @method     ChildQuestion[]|ObjectCollection findByQuestiontext(string $questionText) Return ChildQuestion objects filtered by the questionText column
 * @method     ChildQuestion[]|ObjectCollection findByQuestionname(string $questionName) Return ChildQuestion objects filtered by the questionName column
 * @method     ChildQuestion[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildQuestion objects filtered by the created_at column
 * @method     ChildQuestion[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildQuestion objects filtered by the updated_at column
 * @method     ChildQuestion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class QuestionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\QuestionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\Question', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildQuestionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildQuestionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildQuestionQuery) {
            return $criteria;
        }
        $query = new ChildQuestionQuery();
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
     * @return ChildQuestion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = QuestionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(QuestionTableMap::DATABASE_NAME);
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
     * @return ChildQuestion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, questionText, questionName, created_at, updated_at FROM questions WHERE id = :p0';
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
            /** @var ChildQuestion $obj */
            $obj = new ChildQuestion();
            $obj->hydrate($row);
            QuestionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildQuestion|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(QuestionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(QuestionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(QuestionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(QuestionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the questionText column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestiontext('fooValue');   // WHERE questionText = 'fooValue'
     * $query->filterByQuestiontext('%fooValue%'); // WHERE questionText LIKE '%fooValue%'
     * </code>
     *
     * @param     string $questiontext The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByQuestiontext($questiontext = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($questiontext)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $questiontext)) {
                $questiontext = str_replace('*', '%', $questiontext);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(QuestionTableMap::COL_QUESTIONTEXT, $questiontext, $comparison);
    }

    /**
     * Filter the query on the questionName column
     *
     * Example usage:
     * <code>
     * $query->filterByQuestionname('fooValue');   // WHERE questionName = 'fooValue'
     * $query->filterByQuestionname('%fooValue%'); // WHERE questionName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $questionname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByQuestionname($questionname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($questionname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $questionname)) {
                $questionname = str_replace('*', '%', $questionname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(QuestionTableMap::COL_QUESTIONNAME, $questionname, $comparison);
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
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(QuestionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(QuestionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(QuestionTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(QuestionTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuestionTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \QuestionScore object
     *
     * @param \QuestionScore|ObjectCollection $questionScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByQuestionScore($questionScore, $comparison = null)
    {
        if ($questionScore instanceof \QuestionScore) {
            return $this
                ->addUsingAlias(QuestionTableMap::COL_ID, $questionScore->getQuestionid(), $comparison);
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
     * @return $this|ChildQuestionQuery The current query, for fluid interface
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
     * Filter the query by a related \QuestionAssigner object
     *
     * @param \QuestionAssigner|ObjectCollection $questionAssigner the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByQuestionAssigner($questionAssigner, $comparison = null)
    {
        if ($questionAssigner instanceof \QuestionAssigner) {
            return $this
                ->addUsingAlias(QuestionTableMap::COL_ID, $questionAssigner->getQuestionid(), $comparison);
        } elseif ($questionAssigner instanceof ObjectCollection) {
            return $this
                ->useQuestionAssignerQuery()
                ->filterByPrimaryKeys($questionAssigner->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuestionAssigner() only accepts arguments of type \QuestionAssigner or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the QuestionAssigner relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function joinQuestionAssigner($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('QuestionAssigner');

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
            $this->addJoinObject($join, 'QuestionAssigner');
        }

        return $this;
    }

    /**
     * Use the QuestionAssigner relation QuestionAssigner object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \QuestionAssignerQuery A secondary query class using the current class as primary query
     */
    public function useQuestionAssignerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuestionAssigner($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'QuestionAssigner', '\QuestionAssignerQuery');
    }

    /**
     * Filter the query by a related \ElementAssignment object
     *
     * @param \ElementAssignment|ObjectCollection $elementAssignment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByElementAssignment($elementAssignment, $comparison = null)
    {
        if ($elementAssignment instanceof \ElementAssignment) {
            return $this
                ->addUsingAlias(QuestionTableMap::COL_ID, $elementAssignment->getQuestionid(), $comparison);
        } elseif ($elementAssignment instanceof ObjectCollection) {
            return $this
                ->useElementAssignmentQuery()
                ->filterByPrimaryKeys($elementAssignment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementAssignment() only accepts arguments of type \ElementAssignment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementAssignment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function joinElementAssignment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementAssignment');

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
            $this->addJoinObject($join, 'ElementAssignment');
        }

        return $this;
    }

    /**
     * Use the ElementAssignment relation ElementAssignment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ElementAssignmentQuery A secondary query class using the current class as primary query
     */
    public function useElementAssignmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementAssignment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementAssignment', '\ElementAssignmentQuery');
    }

    /**
     * Filter the query by a related \TaggedQuestion object
     *
     * @param \TaggedQuestion|ObjectCollection $taggedQuestion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByTaggedQuestion($taggedQuestion, $comparison = null)
    {
        if ($taggedQuestion instanceof \TaggedQuestion) {
            return $this
                ->addUsingAlias(QuestionTableMap::COL_ID, $taggedQuestion->getQuestionId(), $comparison);
        } elseif ($taggedQuestion instanceof ObjectCollection) {
            return $this
                ->useTaggedQuestionQuery()
                ->filterByPrimaryKeys($taggedQuestion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTaggedQuestion() only accepts arguments of type \TaggedQuestion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TaggedQuestion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function joinTaggedQuestion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TaggedQuestion');

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
            $this->addJoinObject($join, 'TaggedQuestion');
        }

        return $this;
    }

    /**
     * Use the TaggedQuestion relation TaggedQuestion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \TaggedQuestionQuery A secondary query class using the current class as primary query
     */
    public function useTaggedQuestionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTaggedQuestion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TaggedQuestion', '\TaggedQuestionQuery');
    }

    /**
     * Filter the query by a related Exam object
     * using the questionAssigner table as cross reference
     *
     * @param Exam $exam the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByExam($exam, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useQuestionAssignerQuery()
            ->filterByExam($exam, $comparison)
            ->endUse();
    }

    /**
     * Filter the query by a related Tag object
     * using the tagsXquestions table as cross reference
     *
     * @param Tag $tag the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildQuestionQuery The current query, for fluid interface
     */
    public function filterByTag($tag, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useTaggedQuestionQuery()
            ->filterByTag($tag, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   ChildQuestion $question Object to remove from the list of results
     *
     * @return $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function prune($question = null)
    {
        if ($question) {
            $this->addUsingAlias(QuestionTableMap::COL_ID, $question->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the questions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            QuestionTableMap::clearInstancePool();
            QuestionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(QuestionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(QuestionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            QuestionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            QuestionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(QuestionTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(QuestionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(QuestionTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(QuestionTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(QuestionTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildQuestionQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(QuestionTableMap::COL_CREATED_AT);
    }

} // QuestionQuery
