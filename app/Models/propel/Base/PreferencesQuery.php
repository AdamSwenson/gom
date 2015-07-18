<?php

namespace Base;

use \Preferences as ChildPreferences;
use \PreferencesQuery as ChildPreferencesQuery;
use \Exception;
use \PDO;
use Map\PreferencesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'preferences' table.
 *
 *
 *
 * @method     ChildPreferencesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPreferencesQuery orderByJquerytheme($order = Criteria::ASC) Order by the jqueryTheme column
 * @method     ChildPreferencesQuery orderByAutostartexam($order = Criteria::ASC) Order by the autostartExam column
 * @method     ChildPreferencesQuery orderByAutostartgroup($order = Criteria::ASC) Order by the autostartGroup column
 * @method     ChildPreferencesQuery orderByDashboardNumExams($order = Criteria::ASC) Order by the dashboard_num_exams column
 * @method     ChildPreferencesQuery orderByNumberQuestions($order = Criteria::ASC) Order by the number_questions column
 * @method     ChildPreferencesQuery orderByNumberSubtasks($order = Criteria::ASC) Order by the number_subtasks column
 * @method     ChildPreferencesQuery orderByUserId($order = Criteria::ASC) Order by the user_id column
 * @method     ChildPreferencesQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPreferencesQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildPreferencesQuery groupById() Group by the id column
 * @method     ChildPreferencesQuery groupByJquerytheme() Group by the jqueryTheme column
 * @method     ChildPreferencesQuery groupByAutostartexam() Group by the autostartExam column
 * @method     ChildPreferencesQuery groupByAutostartgroup() Group by the autostartGroup column
 * @method     ChildPreferencesQuery groupByDashboardNumExams() Group by the dashboard_num_exams column
 * @method     ChildPreferencesQuery groupByNumberQuestions() Group by the number_questions column
 * @method     ChildPreferencesQuery groupByNumberSubtasks() Group by the number_subtasks column
 * @method     ChildPreferencesQuery groupByUserId() Group by the user_id column
 * @method     ChildPreferencesQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPreferencesQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildPreferencesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPreferencesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPreferencesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPreferencesQuery leftJoinUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the User relation
 * @method     ChildPreferencesQuery rightJoinUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the User relation
 * @method     ChildPreferencesQuery innerJoinUser($relationAlias = null) Adds a INNER JOIN clause to the query using the User relation
 *
 * @method     \UserQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPreferences findOne(ConnectionInterface $con = null) Return the first ChildPreferences matching the query
 * @method     ChildPreferences findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPreferences matching the query, or a new ChildPreferences object populated from the query conditions when no match is found
 *
 * @method     ChildPreferences findOneById(int $id) Return the first ChildPreferences filtered by the id column
 * @method     ChildPreferences findOneByJquerytheme(string $jqueryTheme) Return the first ChildPreferences filtered by the jqueryTheme column
 * @method     ChildPreferences findOneByAutostartexam(boolean $autostartExam) Return the first ChildPreferences filtered by the autostartExam column
 * @method     ChildPreferences findOneByAutostartgroup(boolean $autostartGroup) Return the first ChildPreferences filtered by the autostartGroup column
 * @method     ChildPreferences findOneByDashboardNumExams(int $dashboard_num_exams) Return the first ChildPreferences filtered by the dashboard_num_exams column
 * @method     ChildPreferences findOneByNumberQuestions(int $number_questions) Return the first ChildPreferences filtered by the number_questions column
 * @method     ChildPreferences findOneByNumberSubtasks(int $number_subtasks) Return the first ChildPreferences filtered by the number_subtasks column
 * @method     ChildPreferences findOneByUserId(int $user_id) Return the first ChildPreferences filtered by the user_id column
 * @method     ChildPreferences findOneByCreatedAt(string $created_at) Return the first ChildPreferences filtered by the created_at column
 * @method     ChildPreferences findOneByUpdatedAt(string $updated_at) Return the first ChildPreferences filtered by the updated_at column *

 * @method     ChildPreferences requirePk($key, ConnectionInterface $con = null) Return the ChildPreferences by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOne(ConnectionInterface $con = null) Return the first ChildPreferences matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPreferences requireOneById(int $id) Return the first ChildPreferences filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByJquerytheme(string $jqueryTheme) Return the first ChildPreferences filtered by the jqueryTheme column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByAutostartexam(boolean $autostartExam) Return the first ChildPreferences filtered by the autostartExam column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByAutostartgroup(boolean $autostartGroup) Return the first ChildPreferences filtered by the autostartGroup column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByDashboardNumExams(int $dashboard_num_exams) Return the first ChildPreferences filtered by the dashboard_num_exams column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByNumberQuestions(int $number_questions) Return the first ChildPreferences filtered by the number_questions column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByNumberSubtasks(int $number_subtasks) Return the first ChildPreferences filtered by the number_subtasks column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByUserId(int $user_id) Return the first ChildPreferences filtered by the user_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByCreatedAt(string $created_at) Return the first ChildPreferences filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPreferences requireOneByUpdatedAt(string $updated_at) Return the first ChildPreferences filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPreferences[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPreferences objects based on current ModelCriteria
 * @method     ChildPreferences[]|ObjectCollection findById(int $id) Return ChildPreferences objects filtered by the id column
 * @method     ChildPreferences[]|ObjectCollection findByJquerytheme(string $jqueryTheme) Return ChildPreferences objects filtered by the jqueryTheme column
 * @method     ChildPreferences[]|ObjectCollection findByAutostartexam(boolean $autostartExam) Return ChildPreferences objects filtered by the autostartExam column
 * @method     ChildPreferences[]|ObjectCollection findByAutostartgroup(boolean $autostartGroup) Return ChildPreferences objects filtered by the autostartGroup column
 * @method     ChildPreferences[]|ObjectCollection findByDashboardNumExams(int $dashboard_num_exams) Return ChildPreferences objects filtered by the dashboard_num_exams column
 * @method     ChildPreferences[]|ObjectCollection findByNumberQuestions(int $number_questions) Return ChildPreferences objects filtered by the number_questions column
 * @method     ChildPreferences[]|ObjectCollection findByNumberSubtasks(int $number_subtasks) Return ChildPreferences objects filtered by the number_subtasks column
 * @method     ChildPreferences[]|ObjectCollection findByUserId(int $user_id) Return ChildPreferences objects filtered by the user_id column
 * @method     ChildPreferences[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPreferences objects filtered by the created_at column
 * @method     ChildPreferences[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildPreferences objects filtered by the updated_at column
 * @method     ChildPreferences[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PreferencesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PreferencesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\Preferences', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPreferencesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPreferencesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPreferencesQuery) {
            return $criteria;
        }
        $query = new ChildPreferencesQuery();
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
     * @return ChildPreferences|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PreferencesTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PreferencesTableMap::DATABASE_NAME);
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
     * @return ChildPreferences A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, jqueryTheme, autostartExam, autostartGroup, dashboard_num_exams, number_questions, number_subtasks, user_id, created_at, updated_at FROM preferences WHERE id = :p0';
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
            /** @var ChildPreferences $obj */
            $obj = new ChildPreferences();
            $obj->hydrate($row);
            PreferencesTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPreferences|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PreferencesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PreferencesTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the jqueryTheme column
     *
     * Example usage:
     * <code>
     * $query->filterByJquerytheme('fooValue');   // WHERE jqueryTheme = 'fooValue'
     * $query->filterByJquerytheme('%fooValue%'); // WHERE jqueryTheme LIKE '%fooValue%'
     * </code>
     *
     * @param     string $jquerytheme The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByJquerytheme($jquerytheme = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($jquerytheme)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $jquerytheme)) {
                $jquerytheme = str_replace('*', '%', $jquerytheme);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_JQUERYTHEME, $jquerytheme, $comparison);
    }

    /**
     * Filter the query on the autostartExam column
     *
     * Example usage:
     * <code>
     * $query->filterByAutostartexam(true); // WHERE autostartExam = true
     * $query->filterByAutostartexam('yes'); // WHERE autostartExam = true
     * </code>
     *
     * @param     boolean|string $autostartexam The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByAutostartexam($autostartexam = null, $comparison = null)
    {
        if (is_string($autostartexam)) {
            $autostartexam = in_array(strtolower($autostartexam), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_AUTOSTARTEXAM, $autostartexam, $comparison);
    }

    /**
     * Filter the query on the autostartGroup column
     *
     * Example usage:
     * <code>
     * $query->filterByAutostartgroup(true); // WHERE autostartGroup = true
     * $query->filterByAutostartgroup('yes'); // WHERE autostartGroup = true
     * </code>
     *
     * @param     boolean|string $autostartgroup The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByAutostartgroup($autostartgroup = null, $comparison = null)
    {
        if (is_string($autostartgroup)) {
            $autostartgroup = in_array(strtolower($autostartgroup), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_AUTOSTARTGROUP, $autostartgroup, $comparison);
    }

    /**
     * Filter the query on the dashboard_num_exams column
     *
     * Example usage:
     * <code>
     * $query->filterByDashboardNumExams(1234); // WHERE dashboard_num_exams = 1234
     * $query->filterByDashboardNumExams(array(12, 34)); // WHERE dashboard_num_exams IN (12, 34)
     * $query->filterByDashboardNumExams(array('min' => 12)); // WHERE dashboard_num_exams > 12
     * </code>
     *
     * @param     mixed $dashboardNumExams The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByDashboardNumExams($dashboardNumExams = null, $comparison = null)
    {
        if (is_array($dashboardNumExams)) {
            $useMinMax = false;
            if (isset($dashboardNumExams['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_DASHBOARD_NUM_EXAMS, $dashboardNumExams['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dashboardNumExams['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_DASHBOARD_NUM_EXAMS, $dashboardNumExams['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_DASHBOARD_NUM_EXAMS, $dashboardNumExams, $comparison);
    }

    /**
     * Filter the query on the number_questions column
     *
     * Example usage:
     * <code>
     * $query->filterByNumberQuestions(1234); // WHERE number_questions = 1234
     * $query->filterByNumberQuestions(array(12, 34)); // WHERE number_questions IN (12, 34)
     * $query->filterByNumberQuestions(array('min' => 12)); // WHERE number_questions > 12
     * </code>
     *
     * @param     mixed $numberQuestions The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByNumberQuestions($numberQuestions = null, $comparison = null)
    {
        if (is_array($numberQuestions)) {
            $useMinMax = false;
            if (isset($numberQuestions['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_NUMBER_QUESTIONS, $numberQuestions['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberQuestions['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_NUMBER_QUESTIONS, $numberQuestions['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_NUMBER_QUESTIONS, $numberQuestions, $comparison);
    }

    /**
     * Filter the query on the number_subtasks column
     *
     * Example usage:
     * <code>
     * $query->filterByNumberSubtasks(1234); // WHERE number_subtasks = 1234
     * $query->filterByNumberSubtasks(array(12, 34)); // WHERE number_subtasks IN (12, 34)
     * $query->filterByNumberSubtasks(array('min' => 12)); // WHERE number_subtasks > 12
     * </code>
     *
     * @param     mixed $numberSubtasks The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByNumberSubtasks($numberSubtasks = null, $comparison = null)
    {
        if (is_array($numberSubtasks)) {
            $useMinMax = false;
            if (isset($numberSubtasks['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_NUMBER_SUBTASKS, $numberSubtasks['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numberSubtasks['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_NUMBER_SUBTASKS, $numberSubtasks['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_NUMBER_SUBTASKS, $numberSubtasks, $comparison);
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
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByUserId($userId = null, $comparison = null)
    {
        if (is_array($userId)) {
            $useMinMax = false;
            if (isset($userId['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_USER_ID, $userId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userId['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_USER_ID, $userId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_USER_ID, $userId, $comparison);
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
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(PreferencesTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PreferencesTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \User object
     *
     * @param \User|ObjectCollection $user The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPreferencesQuery The current query, for fluid interface
     */
    public function filterByUser($user, $comparison = null)
    {
        if ($user instanceof \User) {
            return $this
                ->addUsingAlias(PreferencesTableMap::COL_USER_ID, $user->getId(), $comparison);
        } elseif ($user instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PreferencesTableMap::COL_USER_ID, $user->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
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
     * @param   ChildPreferences $preferences Object to remove from the list of results
     *
     * @return $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function prune($preferences = null)
    {
        if ($preferences) {
            $this->addUsingAlias(PreferencesTableMap::COL_ID, $preferences->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the preferences table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreferencesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PreferencesTableMap::clearInstancePool();
            PreferencesTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PreferencesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PreferencesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PreferencesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PreferencesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(PreferencesTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(PreferencesTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(PreferencesTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(PreferencesTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(PreferencesTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildPreferencesQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(PreferencesTableMap::COL_CREATED_AT);
    }

} // PreferencesQuery
