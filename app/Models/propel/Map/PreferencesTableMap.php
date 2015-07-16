<?php

namespace Map;

use \Preferences;
use \PreferencesQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'preferences' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PreferencesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PreferencesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gom';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'preferences';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Preferences';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Preferences';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the jqueryTheme field
     */
    const COL_JQUERYTHEME = 'preferences.jqueryTheme';

    /**
     * the column name for the autostartExam field
     */
    const COL_AUTOSTARTEXAM = 'preferences.autostartExam';

    /**
     * the column name for the autostartGroup field
     */
    const COL_AUTOSTARTGROUP = 'preferences.autostartGroup';

    /**
     * the column name for the dashboard_num_exams field
     */
    const COL_DASHBOARD_NUM_EXAMS = 'preferences.dashboard_num_exams';

    /**
     * the column name for the number_questions field
     */
    const COL_NUMBER_QUESTIONS = 'preferences.number_questions';

    /**
     * the column name for the number_subtasks field
     */
    const COL_NUMBER_SUBTASKS = 'preferences.number_subtasks';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'preferences.user_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'preferences.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'preferences.updated_at';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Jquerytheme', 'Autostartexam', 'Autostartgroup', 'DashboardNumExams', 'NumberQuestions', 'NumberSubtasks', 'UserId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('jquerytheme', 'autostartexam', 'autostartgroup', 'dashboardNumExams', 'numberQuestions', 'numberSubtasks', 'userId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(PreferencesTableMap::COL_JQUERYTHEME, PreferencesTableMap::COL_AUTOSTARTEXAM, PreferencesTableMap::COL_AUTOSTARTGROUP, PreferencesTableMap::COL_DASHBOARD_NUM_EXAMS, PreferencesTableMap::COL_NUMBER_QUESTIONS, PreferencesTableMap::COL_NUMBER_SUBTASKS, PreferencesTableMap::COL_USER_ID, PreferencesTableMap::COL_CREATED_AT, PreferencesTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('jqueryTheme', 'autostartExam', 'autostartGroup', 'dashboard_num_exams', 'number_questions', 'number_subtasks', 'user_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Jquerytheme' => 0, 'Autostartexam' => 1, 'Autostartgroup' => 2, 'DashboardNumExams' => 3, 'NumberQuestions' => 4, 'NumberSubtasks' => 5, 'UserId' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, ),
        self::TYPE_CAMELNAME     => array('jquerytheme' => 0, 'autostartexam' => 1, 'autostartgroup' => 2, 'dashboardNumExams' => 3, 'numberQuestions' => 4, 'numberSubtasks' => 5, 'userId' => 6, 'createdAt' => 7, 'updatedAt' => 8, ),
        self::TYPE_COLNAME       => array(PreferencesTableMap::COL_JQUERYTHEME => 0, PreferencesTableMap::COL_AUTOSTARTEXAM => 1, PreferencesTableMap::COL_AUTOSTARTGROUP => 2, PreferencesTableMap::COL_DASHBOARD_NUM_EXAMS => 3, PreferencesTableMap::COL_NUMBER_QUESTIONS => 4, PreferencesTableMap::COL_NUMBER_SUBTASKS => 5, PreferencesTableMap::COL_USER_ID => 6, PreferencesTableMap::COL_CREATED_AT => 7, PreferencesTableMap::COL_UPDATED_AT => 8, ),
        self::TYPE_FIELDNAME     => array('jqueryTheme' => 0, 'autostartExam' => 1, 'autostartGroup' => 2, 'dashboard_num_exams' => 3, 'number_questions' => 4, 'number_subtasks' => 5, 'user_id' => 6, 'created_at' => 7, 'updated_at' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('preferences');
        $this->setPhpName('Preferences');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Preferences');
        $this->setPackage('');
        $this->setUseIdGenerator(false);
        // columns
        $this->addColumn('jqueryTheme', 'Jquerytheme', 'VARCHAR', false, 100, null);
        $this->addColumn('autostartExam', 'Autostartexam', 'BOOLEAN', false, 1, null);
        $this->addColumn('autostartGroup', 'Autostartgroup', 'BOOLEAN', false, 1, null);
        $this->addColumn('dashboard_num_exams', 'DashboardNumExams', 'INTEGER', false, null, null);
        $this->addColumn('number_questions', 'NumberQuestions', 'INTEGER', false, null, null);
        $this->addColumn('number_subtasks', 'NumberSubtasks', 'INTEGER', false, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'users', 'id', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\User', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':user_id',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'updated_at', 'disable_created_at' => 'false', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return null;
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return '';
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PreferencesTableMap::CLASS_DEFAULT : PreferencesTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Preferences object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PreferencesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PreferencesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PreferencesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PreferencesTableMap::OM_CLASS;
            /** @var Preferences $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PreferencesTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PreferencesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PreferencesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Preferences $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PreferencesTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PreferencesTableMap::COL_JQUERYTHEME);
            $criteria->addSelectColumn(PreferencesTableMap::COL_AUTOSTARTEXAM);
            $criteria->addSelectColumn(PreferencesTableMap::COL_AUTOSTARTGROUP);
            $criteria->addSelectColumn(PreferencesTableMap::COL_DASHBOARD_NUM_EXAMS);
            $criteria->addSelectColumn(PreferencesTableMap::COL_NUMBER_QUESTIONS);
            $criteria->addSelectColumn(PreferencesTableMap::COL_NUMBER_SUBTASKS);
            $criteria->addSelectColumn(PreferencesTableMap::COL_USER_ID);
            $criteria->addSelectColumn(PreferencesTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PreferencesTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.jqueryTheme');
            $criteria->addSelectColumn($alias . '.autostartExam');
            $criteria->addSelectColumn($alias . '.autostartGroup');
            $criteria->addSelectColumn($alias . '.dashboard_num_exams');
            $criteria->addSelectColumn($alias . '.number_questions');
            $criteria->addSelectColumn($alias . '.number_subtasks');
            $criteria->addSelectColumn($alias . '.user_id');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PreferencesTableMap::DATABASE_NAME)->getTable(PreferencesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PreferencesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PreferencesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PreferencesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Preferences or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Preferences object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreferencesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Preferences) { // it's a model object
            // create criteria based on pk value
            $criteria = $values->buildCriteria();
        } else { // it's a primary key, or an array of pks
            throw new LogicException('The Preferences object has no primary key');
        }

        $query = PreferencesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PreferencesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PreferencesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the preferences table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PreferencesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Preferences or Criteria object.
     *
     * @param mixed               $criteria Criteria or Preferences object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PreferencesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Preferences object
        }


        // Set the correct dbName
        $query = PreferencesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PreferencesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PreferencesTableMap::buildTableMap();
