<?php

namespace Base;

use \User as ChildUser;
use \UserQuery as ChildUserQuery;
use \Exception;
use \PDO;
use Map\UserTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method     ChildUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUserQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildUserQuery orderByDisplayname($order = Criteria::ASC) Order by the displayname column
 * @method     ChildUserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUserQuery orderByActivationToken($order = Criteria::ASC) Order by the activation_token column
 * @method     ChildUserQuery orderByLastActivationRequest($order = Criteria::ASC) Order by the last_activation_request column
 * @method     ChildUserQuery orderByLostPasswordRequest($order = Criteria::ASC) Order by the lost_password_request column
 * @method     ChildUserQuery orderByActive($order = Criteria::ASC) Order by the active column
 * @method     ChildUserQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildUserQuery orderBySignUpStamp($order = Criteria::ASC) Order by the sign_up_stamp column
 * @method     ChildUserQuery orderByLastSignInStamp($order = Criteria::ASC) Order by the last_sign_in_stamp column
 * @method     ChildUserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method     ChildUserQuery groupById() Group by the id column
 * @method     ChildUserQuery groupByUsername() Group by the username column
 * @method     ChildUserQuery groupByDisplayname() Group by the displayname column
 * @method     ChildUserQuery groupByPassword() Group by the password column
 * @method     ChildUserQuery groupByEmail() Group by the email column
 * @method     ChildUserQuery groupByActivationToken() Group by the activation_token column
 * @method     ChildUserQuery groupByLastActivationRequest() Group by the last_activation_request column
 * @method     ChildUserQuery groupByLostPasswordRequest() Group by the lost_password_request column
 * @method     ChildUserQuery groupByActive() Group by the active column
 * @method     ChildUserQuery groupByTitle() Group by the title column
 * @method     ChildUserQuery groupBySignUpStamp() Group by the sign_up_stamp column
 * @method     ChildUserQuery groupByLastSignInStamp() Group by the last_sign_in_stamp column
 * @method     ChildUserQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUserQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method     ChildUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserQuery leftJoinTerm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Term relation
 * @method     ChildUserQuery rightJoinTerm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Term relation
 * @method     ChildUserQuery innerJoinTerm($relationAlias = null) Adds a INNER JOIN clause to the query using the Term relation
 *
 * @method     ChildUserQuery leftJoinTopic($relationAlias = null) Adds a LEFT JOIN clause to the query using the Topic relation
 * @method     ChildUserQuery rightJoinTopic($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Topic relation
 * @method     ChildUserQuery innerJoinTopic($relationAlias = null) Adds a INNER JOIN clause to the query using the Topic relation
 *
 * @method     ChildUserQuery leftJoinYear($relationAlias = null) Adds a LEFT JOIN clause to the query using the Year relation
 * @method     ChildUserQuery rightJoinYear($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Year relation
 * @method     ChildUserQuery innerJoinYear($relationAlias = null) Adds a INNER JOIN clause to the query using the Year relation
 *
 * @method     ChildUserQuery leftJoinExam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Exam relation
 * @method     ChildUserQuery rightJoinExam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Exam relation
 * @method     ChildUserQuery innerJoinExam($relationAlias = null) Adds a INNER JOIN clause to the query using the Exam relation
 *
 * @method     ChildUserQuery leftJoinQuestion($relationAlias = null) Adds a LEFT JOIN clause to the query using the Question relation
 * @method     ChildUserQuery rightJoinQuestion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Question relation
 * @method     ChildUserQuery innerJoinQuestion($relationAlias = null) Adds a INNER JOIN clause to the query using the Question relation
 *
 * @method     ChildUserQuery leftJoinElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Element relation
 * @method     ChildUserQuery rightJoinElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Element relation
 * @method     ChildUserQuery innerJoinElement($relationAlias = null) Adds a INNER JOIN clause to the query using the Element relation
 *
 * @method     ChildUserQuery leftJoinStudent($relationAlias = null) Adds a LEFT JOIN clause to the query using the Student relation
 * @method     ChildUserQuery rightJoinStudent($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Student relation
 * @method     ChildUserQuery innerJoinStudent($relationAlias = null) Adds a INNER JOIN clause to the query using the Student relation
 *
 * @method     ChildUserQuery leftJoinKumi($relationAlias = null) Adds a LEFT JOIN clause to the query using the Kumi relation
 * @method     ChildUserQuery rightJoinKumi($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Kumi relation
 * @method     ChildUserQuery innerJoinKumi($relationAlias = null) Adds a INNER JOIN clause to the query using the Kumi relation
 *
 * @method     ChildUserQuery leftJoinStockText($relationAlias = null) Adds a LEFT JOIN clause to the query using the StockText relation
 * @method     ChildUserQuery rightJoinStockText($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StockText relation
 * @method     ChildUserQuery innerJoinStockText($relationAlias = null) Adds a INNER JOIN clause to the query using the StockText relation
 *
 * @method     ChildUserQuery leftJoinQuestionScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuestionScore relation
 * @method     ChildUserQuery rightJoinQuestionScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuestionScore relation
 * @method     ChildUserQuery innerJoinQuestionScore($relationAlias = null) Adds a INNER JOIN clause to the query using the QuestionScore relation
 *
 * @method     ChildUserQuery leftJoinElementScore($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementScore relation
 * @method     ChildUserQuery rightJoinElementScore($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementScore relation
 * @method     ChildUserQuery innerJoinElementScore($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementScore relation
 *
 * @method     ChildUserQuery leftJoinExamInfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExamInfo relation
 * @method     ChildUserQuery rightJoinExamInfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExamInfo relation
 * @method     ChildUserQuery innerJoinExamInfo($relationAlias = null) Adds a INNER JOIN clause to the query using the ExamInfo relation
 *
 * @method     ChildUserQuery leftJoinQuestionAssigner($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuestionAssigner relation
 * @method     ChildUserQuery rightJoinQuestionAssigner($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuestionAssigner relation
 * @method     ChildUserQuery innerJoinQuestionAssigner($relationAlias = null) Adds a INNER JOIN clause to the query using the QuestionAssigner relation
 *
 * @method     ChildUserQuery leftJoinElementAssignment($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementAssignment relation
 * @method     ChildUserQuery rightJoinElementAssignment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementAssignment relation
 * @method     ChildUserQuery innerJoinElementAssignment($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementAssignment relation
 *
 * @method     ChildUserQuery leftJoinStudentClassAssignment($relationAlias = null) Adds a LEFT JOIN clause to the query using the StudentClassAssignment relation
 * @method     ChildUserQuery rightJoinStudentClassAssignment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StudentClassAssignment relation
 * @method     ChildUserQuery innerJoinStudentClassAssignment($relationAlias = null) Adds a INNER JOIN clause to the query using the StudentClassAssignment relation
 *
 * @method     ChildUserQuery leftJoinExamClassAssignment($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExamClassAssignment relation
 * @method     ChildUserQuery rightJoinExamClassAssignment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExamClassAssignment relation
 * @method     ChildUserQuery innerJoinExamClassAssignment($relationAlias = null) Adds a INNER JOIN clause to the query using the ExamClassAssignment relation
 *
 * @method     ChildUserQuery leftJoinGradingTime($relationAlias = null) Adds a LEFT JOIN clause to the query using the GradingTime relation
 * @method     ChildUserQuery rightJoinGradingTime($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GradingTime relation
 * @method     ChildUserQuery innerJoinGradingTime($relationAlias = null) Adds a INNER JOIN clause to the query using the GradingTime relation
 *
 * @method     ChildUserQuery leftJoinGroupTime($relationAlias = null) Adds a LEFT JOIN clause to the query using the GroupTime relation
 * @method     ChildUserQuery rightJoinGroupTime($relationAlias = null) Adds a RIGHT JOIN clause to the query using the GroupTime relation
 * @method     ChildUserQuery innerJoinGroupTime($relationAlias = null) Adds a INNER JOIN clause to the query using the GroupTime relation
 *
 * @method     ChildUserQuery leftJoinPreferences($relationAlias = null) Adds a LEFT JOIN clause to the query using the Preferences relation
 * @method     ChildUserQuery rightJoinPreferences($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Preferences relation
 * @method     ChildUserQuery innerJoinPreferences($relationAlias = null) Adds a INNER JOIN clause to the query using the Preferences relation
 *
 * @method     ChildUserQuery leftJoinPseudoID($relationAlias = null) Adds a LEFT JOIN clause to the query using the PseudoID relation
 * @method     ChildUserQuery rightJoinPseudoID($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PseudoID relation
 * @method     ChildUserQuery innerJoinPseudoID($relationAlias = null) Adds a INNER JOIN clause to the query using the PseudoID relation
 *
 * @method     \TermQuery|\TopicQuery|\YearQuery|\ExamQuery|\QuestionQuery|\ElementQuery|\StudentQuery|\KumiQuery|\StockTextQuery|\QuestionScoreQuery|\ElementScoreQuery|\ExamInfoQuery|\QuestionAssignerQuery|\ElementAssignmentQuery|\StudentClassAssignmentQuery|\ExamClassAssignmentQuery|\GradingTimeQuery|\GroupTimeQuery|\PreferencesQuery|\PseudoIDQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUser findOne(ConnectionInterface $con = null) Return the first ChildUser matching the query
 * @method     ChildUser findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUser matching the query, or a new ChildUser object populated from the query conditions when no match is found
 *
 * @method     ChildUser findOneById(int $id) Return the first ChildUser filtered by the id column
 * @method     ChildUser findOneByUsername(string $username) Return the first ChildUser filtered by the username column
 * @method     ChildUser findOneByDisplayname(string $displayname) Return the first ChildUser filtered by the displayname column
 * @method     ChildUser findOneByPassword(string $password) Return the first ChildUser filtered by the password column
 * @method     ChildUser findOneByEmail(string $email) Return the first ChildUser filtered by the email column
 * @method     ChildUser findOneByActivationToken(string $activation_token) Return the first ChildUser filtered by the activation_token column
 * @method     ChildUser findOneByLastActivationRequest(int $last_activation_request) Return the first ChildUser filtered by the last_activation_request column
 * @method     ChildUser findOneByLostPasswordRequest(int $lost_password_request) Return the first ChildUser filtered by the lost_password_request column
 * @method     ChildUser findOneByActive(int $active) Return the first ChildUser filtered by the active column
 * @method     ChildUser findOneByTitle(string $title) Return the first ChildUser filtered by the title column
 * @method     ChildUser findOneBySignUpStamp(int $sign_up_stamp) Return the first ChildUser filtered by the sign_up_stamp column
 * @method     ChildUser findOneByLastSignInStamp(int $last_sign_in_stamp) Return the first ChildUser filtered by the last_sign_in_stamp column
 * @method     ChildUser findOneByCreatedAt(string $created_at) Return the first ChildUser filtered by the created_at column
 * @method     ChildUser findOneByUpdatedAt(string $updated_at) Return the first ChildUser filtered by the updated_at column *

 * @method     ChildUser requirePk($key, ConnectionInterface $con = null) Return the ChildUser by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOne(ConnectionInterface $con = null) Return the first ChildUser matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser requireOneById(int $id) Return the first ChildUser filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUsername(string $username) Return the first ChildUser filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByDisplayname(string $displayname) Return the first ChildUser filtered by the displayname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByPassword(string $password) Return the first ChildUser filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByEmail(string $email) Return the first ChildUser filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByActivationToken(string $activation_token) Return the first ChildUser filtered by the activation_token column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLastActivationRequest(int $last_activation_request) Return the first ChildUser filtered by the last_activation_request column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLostPasswordRequest(int $lost_password_request) Return the first ChildUser filtered by the lost_password_request column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByActive(int $active) Return the first ChildUser filtered by the active column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByTitle(string $title) Return the first ChildUser filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneBySignUpStamp(int $sign_up_stamp) Return the first ChildUser filtered by the sign_up_stamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByLastSignInStamp(int $last_sign_in_stamp) Return the first ChildUser filtered by the last_sign_in_stamp column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByCreatedAt(string $created_at) Return the first ChildUser filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUser requireOneByUpdatedAt(string $updated_at) Return the first ChildUser filtered by the updated_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUser[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUser objects based on current ModelCriteria
 * @method     ChildUser[]|ObjectCollection findById(int $id) Return ChildUser objects filtered by the id column
 * @method     ChildUser[]|ObjectCollection findByUsername(string $username) Return ChildUser objects filtered by the username column
 * @method     ChildUser[]|ObjectCollection findByDisplayname(string $displayname) Return ChildUser objects filtered by the displayname column
 * @method     ChildUser[]|ObjectCollection findByPassword(string $password) Return ChildUser objects filtered by the password column
 * @method     ChildUser[]|ObjectCollection findByEmail(string $email) Return ChildUser objects filtered by the email column
 * @method     ChildUser[]|ObjectCollection findByActivationToken(string $activation_token) Return ChildUser objects filtered by the activation_token column
 * @method     ChildUser[]|ObjectCollection findByLastActivationRequest(int $last_activation_request) Return ChildUser objects filtered by the last_activation_request column
 * @method     ChildUser[]|ObjectCollection findByLostPasswordRequest(int $lost_password_request) Return ChildUser objects filtered by the lost_password_request column
 * @method     ChildUser[]|ObjectCollection findByActive(int $active) Return ChildUser objects filtered by the active column
 * @method     ChildUser[]|ObjectCollection findByTitle(string $title) Return ChildUser objects filtered by the title column
 * @method     ChildUser[]|ObjectCollection findBySignUpStamp(int $sign_up_stamp) Return ChildUser objects filtered by the sign_up_stamp column
 * @method     ChildUser[]|ObjectCollection findByLastSignInStamp(int $last_sign_in_stamp) Return ChildUser objects filtered by the last_sign_in_stamp column
 * @method     ChildUser[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUser objects filtered by the created_at column
 * @method     ChildUser[]|ObjectCollection findByUpdatedAt(string $updated_at) Return ChildUser objects filtered by the updated_at column
 * @method     ChildUser[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\UserQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'gom', $modelName = '\\User', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserQuery) {
            return $criteria;
        }
        $query = new ChildUserQuery();
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UserTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserTableMap::DATABASE_NAME);
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
     * @return ChildUser A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, username, displayname, password, email, activation_token, last_activation_request, lost_password_request, active, title, sign_up_stamp, last_sign_in_stamp, created_at, updated_at FROM users WHERE id = :p0';
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
            /** @var ChildUser $obj */
            $obj = new ChildUser();
            $obj->hydrate($row);
            UserTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUser|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%'); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $username)) {
                $username = str_replace('*', '%', $username);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the displayname column
     *
     * Example usage:
     * <code>
     * $query->filterByDisplayname('fooValue');   // WHERE displayname = 'fooValue'
     * $query->filterByDisplayname('%fooValue%'); // WHERE displayname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $displayname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByDisplayname($displayname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($displayname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $displayname)) {
                $displayname = str_replace('*', '%', $displayname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_DISPLAYNAME, $displayname, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UserTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the activation_token column
     *
     * Example usage:
     * <code>
     * $query->filterByActivationToken('fooValue');   // WHERE activation_token = 'fooValue'
     * $query->filterByActivationToken('%fooValue%'); // WHERE activation_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $activationToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByActivationToken($activationToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($activationToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $activationToken)) {
                $activationToken = str_replace('*', '%', $activationToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ACTIVATION_TOKEN, $activationToken, $comparison);
    }

    /**
     * Filter the query on the last_activation_request column
     *
     * Example usage:
     * <code>
     * $query->filterByLastActivationRequest(1234); // WHERE last_activation_request = 1234
     * $query->filterByLastActivationRequest(array(12, 34)); // WHERE last_activation_request IN (12, 34)
     * $query->filterByLastActivationRequest(array('min' => 12)); // WHERE last_activation_request > 12
     * </code>
     *
     * @param     mixed $lastActivationRequest The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLastActivationRequest($lastActivationRequest = null, $comparison = null)
    {
        if (is_array($lastActivationRequest)) {
            $useMinMax = false;
            if (isset($lastActivationRequest['min'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_ACTIVATION_REQUEST, $lastActivationRequest['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastActivationRequest['max'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_ACTIVATION_REQUEST, $lastActivationRequest['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LAST_ACTIVATION_REQUEST, $lastActivationRequest, $comparison);
    }

    /**
     * Filter the query on the lost_password_request column
     *
     * Example usage:
     * <code>
     * $query->filterByLostPasswordRequest(1234); // WHERE lost_password_request = 1234
     * $query->filterByLostPasswordRequest(array(12, 34)); // WHERE lost_password_request IN (12, 34)
     * $query->filterByLostPasswordRequest(array('min' => 12)); // WHERE lost_password_request > 12
     * </code>
     *
     * @param     mixed $lostPasswordRequest The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLostPasswordRequest($lostPasswordRequest = null, $comparison = null)
    {
        if (is_array($lostPasswordRequest)) {
            $useMinMax = false;
            if (isset($lostPasswordRequest['min'])) {
                $this->addUsingAlias(UserTableMap::COL_LOST_PASSWORD_REQUEST, $lostPasswordRequest['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lostPasswordRequest['max'])) {
                $this->addUsingAlias(UserTableMap::COL_LOST_PASSWORD_REQUEST, $lostPasswordRequest['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LOST_PASSWORD_REQUEST, $lostPasswordRequest, $comparison);
    }

    /**
     * Filter the query on the active column
     *
     * Example usage:
     * <code>
     * $query->filterByActive(1234); // WHERE active = 1234
     * $query->filterByActive(array(12, 34)); // WHERE active IN (12, 34)
     * $query->filterByActive(array('min' => 12)); // WHERE active > 12
     * </code>
     *
     * @param     mixed $active The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByActive($active = null, $comparison = null)
    {
        if (is_array($active)) {
            $useMinMax = false;
            if (isset($active['min'])) {
                $this->addUsingAlias(UserTableMap::COL_ACTIVE, $active['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($active['max'])) {
                $this->addUsingAlias(UserTableMap::COL_ACTIVE, $active['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_ACTIVE, $active, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the sign_up_stamp column
     *
     * Example usage:
     * <code>
     * $query->filterBySignUpStamp(1234); // WHERE sign_up_stamp = 1234
     * $query->filterBySignUpStamp(array(12, 34)); // WHERE sign_up_stamp IN (12, 34)
     * $query->filterBySignUpStamp(array('min' => 12)); // WHERE sign_up_stamp > 12
     * </code>
     *
     * @param     mixed $signUpStamp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterBySignUpStamp($signUpStamp = null, $comparison = null)
    {
        if (is_array($signUpStamp)) {
            $useMinMax = false;
            if (isset($signUpStamp['min'])) {
                $this->addUsingAlias(UserTableMap::COL_SIGN_UP_STAMP, $signUpStamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($signUpStamp['max'])) {
                $this->addUsingAlias(UserTableMap::COL_SIGN_UP_STAMP, $signUpStamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_SIGN_UP_STAMP, $signUpStamp, $comparison);
    }

    /**
     * Filter the query on the last_sign_in_stamp column
     *
     * Example usage:
     * <code>
     * $query->filterByLastSignInStamp(1234); // WHERE last_sign_in_stamp = 1234
     * $query->filterByLastSignInStamp(array(12, 34)); // WHERE last_sign_in_stamp IN (12, 34)
     * $query->filterByLastSignInStamp(array('min' => 12)); // WHERE last_sign_in_stamp > 12
     * </code>
     *
     * @param     mixed $lastSignInStamp The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByLastSignInStamp($lastSignInStamp = null, $comparison = null)
    {
        if (is_array($lastSignInStamp)) {
            $useMinMax = false;
            if (isset($lastSignInStamp['min'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_SIGN_IN_STAMP, $lastSignInStamp['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastSignInStamp['max'])) {
                $this->addUsingAlias(UserTableMap::COL_LAST_SIGN_IN_STAMP, $lastSignInStamp['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_LAST_SIGN_IN_STAMP, $lastSignInStamp, $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related \Term object
     *
     * @param \Term|ObjectCollection $term the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTerm($term, $comparison = null)
    {
        if ($term instanceof \Term) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $term->getUserId(), $comparison);
        } elseif ($term instanceof ObjectCollection) {
            return $this
                ->useTermQuery()
                ->filterByPrimaryKeys($term->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @param \Topic|ObjectCollection $topic the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByTopic($topic, $comparison = null)
    {
        if ($topic instanceof \Topic) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $topic->getUserId(), $comparison);
        } elseif ($topic instanceof ObjectCollection) {
            return $this
                ->useTopicQuery()
                ->filterByPrimaryKeys($topic->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @param \Year|ObjectCollection $year the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByYear($year, $comparison = null)
    {
        if ($year instanceof \Year) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $year->getUserId(), $comparison);
        } elseif ($year instanceof ObjectCollection) {
            return $this
                ->useYearQuery()
                ->filterByPrimaryKeys($year->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \Exam object
     *
     * @param \Exam|ObjectCollection $exam the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByExam($exam, $comparison = null)
    {
        if ($exam instanceof \Exam) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $exam->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @param \Question|ObjectCollection $question the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByQuestion($question, $comparison = null)
    {
        if ($question instanceof \Question) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $question->getUserId(), $comparison);
        } elseif ($question instanceof ObjectCollection) {
            return $this
                ->useQuestionQuery()
                ->filterByPrimaryKeys($question->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @param \Element|ObjectCollection $element the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByElement($element, $comparison = null)
    {
        if ($element instanceof \Element) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $element->getUserId(), $comparison);
        } elseif ($element instanceof ObjectCollection) {
            return $this
                ->useElementQuery()
                ->filterByPrimaryKeys($element->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \Student object
     *
     * @param \Student|ObjectCollection $student the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByStudent($student, $comparison = null)
    {
        if ($student instanceof \Student) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $student->getUserId(), $comparison);
        } elseif ($student instanceof ObjectCollection) {
            return $this
                ->useStudentQuery()
                ->filterByPrimaryKeys($student->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \Kumi object
     *
     * @param \Kumi|ObjectCollection $kumi the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByKumi($kumi, $comparison = null)
    {
        if ($kumi instanceof \Kumi) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $kumi->getUserId(), $comparison);
        } elseif ($kumi instanceof ObjectCollection) {
            return $this
                ->useKumiQuery()
                ->filterByPrimaryKeys($kumi->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \StockText object
     *
     * @param \StockText|ObjectCollection $stockText the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByStockText($stockText, $comparison = null)
    {
        if ($stockText instanceof \StockText) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $stockText->getUserId(), $comparison);
        } elseif ($stockText instanceof ObjectCollection) {
            return $this
                ->useStockTextQuery()
                ->filterByPrimaryKeys($stockText->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStockText() only accepts arguments of type \StockText or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StockText relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinStockText($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StockText');

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
            $this->addJoinObject($join, 'StockText');
        }

        return $this;
    }

    /**
     * Use the StockText relation StockText object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \StockTextQuery A secondary query class using the current class as primary query
     */
    public function useStockTextQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStockText($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StockText', '\StockTextQuery');
    }

    /**
     * Filter the query by a related \QuestionScore object
     *
     * @param \QuestionScore|ObjectCollection $questionScore the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByQuestionScore($questionScore, $comparison = null)
    {
        if ($questionScore instanceof \QuestionScore) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $questionScore->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByElementScore($elementScore, $comparison = null)
    {
        if ($elementScore instanceof \ElementScore) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $elementScore->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByExamInfo($examInfo, $comparison = null)
    {
        if ($examInfo instanceof \ExamInfo) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $examInfo->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \QuestionAssigner object
     *
     * @param \QuestionAssigner|ObjectCollection $questionAssigner the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByQuestionAssigner($questionAssigner, $comparison = null)
    {
        if ($questionAssigner instanceof \QuestionAssigner) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $questionAssigner->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByElementAssignment($elementAssignment, $comparison = null)
    {
        if ($elementAssignment instanceof \ElementAssignment) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $elementAssignment->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \StudentClassAssignment object
     *
     * @param \StudentClassAssignment|ObjectCollection $studentClassAssignment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByStudentClassAssignment($studentClassAssignment, $comparison = null)
    {
        if ($studentClassAssignment instanceof \StudentClassAssignment) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $studentClassAssignment->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \ExamClassAssignment object
     *
     * @param \ExamClassAssignment|ObjectCollection $examClassAssignment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByExamClassAssignment($examClassAssignment, $comparison = null)
    {
        if ($examClassAssignment instanceof \ExamClassAssignment) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $examClassAssignment->getUserId(), $comparison);
        } elseif ($examClassAssignment instanceof ObjectCollection) {
            return $this
                ->useExamClassAssignmentQuery()
                ->filterByPrimaryKeys($examClassAssignment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExamClassAssignment() only accepts arguments of type \ExamClassAssignment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ExamClassAssignment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinExamClassAssignment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ExamClassAssignment');

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
            $this->addJoinObject($join, 'ExamClassAssignment');
        }

        return $this;
    }

    /**
     * Use the ExamClassAssignment relation ExamClassAssignment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ExamClassAssignmentQuery A secondary query class using the current class as primary query
     */
    public function useExamClassAssignmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinExamClassAssignment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ExamClassAssignment', '\ExamClassAssignmentQuery');
    }

    /**
     * Filter the query by a related \GradingTime object
     *
     * @param \GradingTime|ObjectCollection $gradingTime the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByGradingTime($gradingTime, $comparison = null)
    {
        if ($gradingTime instanceof \GradingTime) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $gradingTime->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByGroupTime($groupTime, $comparison = null)
    {
        if ($groupTime instanceof \GroupTime) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $groupTime->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Filter the query by a related \Preferences object
     *
     * @param \Preferences|ObjectCollection $preferences the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPreferences($preferences, $comparison = null)
    {
        if ($preferences instanceof \Preferences) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $preferences->getUserId(), $comparison);
        } elseif ($preferences instanceof ObjectCollection) {
            return $this
                ->usePreferencesQuery()
                ->filterByPrimaryKeys($preferences->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPreferences() only accepts arguments of type \Preferences or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Preferences relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function joinPreferences($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Preferences');

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
            $this->addJoinObject($join, 'Preferences');
        }

        return $this;
    }

    /**
     * Use the Preferences relation Preferences object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PreferencesQuery A secondary query class using the current class as primary query
     */
    public function usePreferencesQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPreferences($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Preferences', '\PreferencesQuery');
    }

    /**
     * Filter the query by a related \PseudoID object
     *
     * @param \PseudoID|ObjectCollection $pseudoID the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUserQuery The current query, for fluid interface
     */
    public function filterByPseudoID($pseudoID, $comparison = null)
    {
        if ($pseudoID instanceof \PseudoID) {
            return $this
                ->addUsingAlias(UserTableMap::COL_ID, $pseudoID->getUserId(), $comparison);
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
     * @return $this|ChildUserQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildUser $user Object to remove from the list of results
     *
     * @return $this|ChildUserQuery The current query, for fluid interface
     */
    public function prune($user = null)
    {
        if ($user) {
            $this->addUsingAlias(UserTableMap::COL_ID, $user->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserTableMap::clearInstancePool();
            UserTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTableMap::COL_UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTableMap::COL_UPDATED_AT);
    }

    /**
     * Order by create date desc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(UserTableMap::COL_CREATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(UserTableMap::COL_CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date asc
     *
     * @return     $this|ChildUserQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(UserTableMap::COL_CREATED_AT);
    }

} // UserQuery
