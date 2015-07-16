<?php

namespace Map;

use \Exam;
use \ExamQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'exams' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ExamTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ExamTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gom';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'exams';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Exam';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Exam';

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
     * the column name for the id field
     */
    const COL_ID = 'exams.id';

    /**
     * the column name for the examTerm field
     */
    const COL_EXAMTERM = 'exams.examTerm';

    /**
     * the column name for the examTopic field
     */
    const COL_EXAMTOPIC = 'exams.examTopic';

    /**
     * the column name for the examYear field
     */
    const COL_EXAMYEAR = 'exams.examYear';

    /**
     * the column name for the locked field
     */
    const COL_LOCKED = 'exams.locked';

    /**
     * the column name for the released field
     */
    const COL_RELEASED = 'exams.released';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'exams.user_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'exams.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'exams.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Examterm', 'Examtopic', 'Examyear', 'Locked', 'Released', 'UserId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'examterm', 'examtopic', 'examyear', 'locked', 'released', 'userId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ExamTableMap::COL_ID, ExamTableMap::COL_EXAMTERM, ExamTableMap::COL_EXAMTOPIC, ExamTableMap::COL_EXAMYEAR, ExamTableMap::COL_LOCKED, ExamTableMap::COL_RELEASED, ExamTableMap::COL_USER_ID, ExamTableMap::COL_CREATED_AT, ExamTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'examTerm', 'examTopic', 'examYear', 'locked', 'released', 'user_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Examterm' => 1, 'Examtopic' => 2, 'Examyear' => 3, 'Locked' => 4, 'Released' => 5, 'UserId' => 6, 'CreatedAt' => 7, 'UpdatedAt' => 8, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'examterm' => 1, 'examtopic' => 2, 'examyear' => 3, 'locked' => 4, 'released' => 5, 'userId' => 6, 'createdAt' => 7, 'updatedAt' => 8, ),
        self::TYPE_COLNAME       => array(ExamTableMap::COL_ID => 0, ExamTableMap::COL_EXAMTERM => 1, ExamTableMap::COL_EXAMTOPIC => 2, ExamTableMap::COL_EXAMYEAR => 3, ExamTableMap::COL_LOCKED => 4, ExamTableMap::COL_RELEASED => 5, ExamTableMap::COL_USER_ID => 6, ExamTableMap::COL_CREATED_AT => 7, ExamTableMap::COL_UPDATED_AT => 8, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'examTerm' => 1, 'examTopic' => 2, 'examYear' => 3, 'locked' => 4, 'released' => 5, 'user_id' => 6, 'created_at' => 7, 'updated_at' => 8, ),
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
        $this->setName('exams');
        $this->setPhpName('Exam');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Exam');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('examTerm', 'Examterm', 'VARCHAR', 'r_terms', 'content', true, 100, null);
        $this->addForeignKey('examTopic', 'Examtopic', 'VARCHAR', 'r_examTopics', 'content', true, 100, null);
        $this->addForeignKey('examYear', 'Examyear', 'INTEGER', 'r_years', 'content', true, 4, null);
        $this->addColumn('locked', 'Locked', 'INTEGER', true, 1, null);
        $this->addColumn('released', 'Released', 'INTEGER', true, 1, null);
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
        $this->addRelation('Term', '\\Term', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':examTerm',
    1 => ':content',
  ),
), null, null, null, false);
        $this->addRelation('Topic', '\\Topic', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':examTopic',
    1 => ':content',
  ),
), null, null, null, false);
        $this->addRelation('Year', '\\Year', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':examYear',
    1 => ':content',
  ),
), null, null, null, false);
        $this->addRelation('QuestionScore', '\\QuestionScore', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':examID',
    1 => ':id',
  ),
), null, null, 'QuestionScores', false);
        $this->addRelation('ElementScore', '\\ElementScore', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':examID',
    1 => ':id',
  ),
), null, null, 'ElementScores', false);
        $this->addRelation('ExamInfo', '\\ExamInfo', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':examID',
    1 => ':id',
  ),
), null, null, 'ExamInfos', false);
        $this->addRelation('GradingTime', '\\GradingTime', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':examID',
    1 => ':id',
  ),
), null, null, 'GradingTimes', false);
        $this->addRelation('GroupTime', '\\GroupTime', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':examID',
    1 => ':id',
  ),
), null, null, 'GroupTimes', false);
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
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? ExamTableMap::CLASS_DEFAULT : ExamTableMap::OM_CLASS;
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
     * @return array           (Exam object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ExamTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ExamTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ExamTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ExamTableMap::OM_CLASS;
            /** @var Exam $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ExamTableMap::addInstanceToPool($obj, $key);
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
            $key = ExamTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ExamTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Exam $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ExamTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ExamTableMap::COL_ID);
            $criteria->addSelectColumn(ExamTableMap::COL_EXAMTERM);
            $criteria->addSelectColumn(ExamTableMap::COL_EXAMTOPIC);
            $criteria->addSelectColumn(ExamTableMap::COL_EXAMYEAR);
            $criteria->addSelectColumn(ExamTableMap::COL_LOCKED);
            $criteria->addSelectColumn(ExamTableMap::COL_RELEASED);
            $criteria->addSelectColumn(ExamTableMap::COL_USER_ID);
            $criteria->addSelectColumn(ExamTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ExamTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.examTerm');
            $criteria->addSelectColumn($alias . '.examTopic');
            $criteria->addSelectColumn($alias . '.examYear');
            $criteria->addSelectColumn($alias . '.locked');
            $criteria->addSelectColumn($alias . '.released');
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
        return Propel::getServiceContainer()->getDatabaseMap(ExamTableMap::DATABASE_NAME)->getTable(ExamTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ExamTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ExamTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ExamTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Exam or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Exam object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ExamTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Exam) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ExamTableMap::DATABASE_NAME);
            $criteria->add(ExamTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ExamQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ExamTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ExamTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the exams table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ExamQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Exam or Criteria object.
     *
     * @param mixed               $criteria Criteria or Exam object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ExamTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Exam object
        }

        if ($criteria->containsKey(ExamTableMap::COL_ID) && $criteria->keyContainsValue(ExamTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ExamTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ExamQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ExamTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ExamTableMap::buildTableMap();
