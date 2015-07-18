<?php

namespace Map;

use \ElementAssignment;
use \ElementAssignmentQuery;
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
 * This class defines the structure of the 'elementXquestions' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ElementAssignmentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.ElementAssignmentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'gom';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'elementXquestions';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\ElementAssignment';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'ElementAssignment';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the id field
     */
    const COL_ID = 'elementXquestions.id';

    /**
     * the column name for the examID field
     */
    const COL_EXAMID = 'elementXquestions.examID';

    /**
     * the column name for the questionID field
     */
    const COL_QUESTIONID = 'elementXquestions.questionID';

    /**
     * the column name for the subtask field
     */
    const COL_SUBTASK = 'elementXquestions.subtask';

    /**
     * the column name for the elementID field
     */
    const COL_ELEMENTID = 'elementXquestions.elementID';

    /**
     * the column name for the user_id field
     */
    const COL_USER_ID = 'elementXquestions.user_id';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'elementXquestions.created_at';

    /**
     * the column name for the updated_at field
     */
    const COL_UPDATED_AT = 'elementXquestions.updated_at';

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
        self::TYPE_PHPNAME       => array('Id', 'Examid', 'Questionid', 'Subtask', 'Elementid', 'UserId', 'CreatedAt', 'UpdatedAt', ),
        self::TYPE_CAMELNAME     => array('id', 'examid', 'questionid', 'subtask', 'elementid', 'userId', 'createdAt', 'updatedAt', ),
        self::TYPE_COLNAME       => array(ElementAssignmentTableMap::COL_ID, ElementAssignmentTableMap::COL_EXAMID, ElementAssignmentTableMap::COL_QUESTIONID, ElementAssignmentTableMap::COL_SUBTASK, ElementAssignmentTableMap::COL_ELEMENTID, ElementAssignmentTableMap::COL_USER_ID, ElementAssignmentTableMap::COL_CREATED_AT, ElementAssignmentTableMap::COL_UPDATED_AT, ),
        self::TYPE_FIELDNAME     => array('id', 'examID', 'questionID', 'subtask', 'elementID', 'user_id', 'created_at', 'updated_at', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Examid' => 1, 'Questionid' => 2, 'Subtask' => 3, 'Elementid' => 4, 'UserId' => 5, 'CreatedAt' => 6, 'UpdatedAt' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'examid' => 1, 'questionid' => 2, 'subtask' => 3, 'elementid' => 4, 'userId' => 5, 'createdAt' => 6, 'updatedAt' => 7, ),
        self::TYPE_COLNAME       => array(ElementAssignmentTableMap::COL_ID => 0, ElementAssignmentTableMap::COL_EXAMID => 1, ElementAssignmentTableMap::COL_QUESTIONID => 2, ElementAssignmentTableMap::COL_SUBTASK => 3, ElementAssignmentTableMap::COL_ELEMENTID => 4, ElementAssignmentTableMap::COL_USER_ID => 5, ElementAssignmentTableMap::COL_CREATED_AT => 6, ElementAssignmentTableMap::COL_UPDATED_AT => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'examID' => 1, 'questionID' => 2, 'subtask' => 3, 'elementID' => 4, 'user_id' => 5, 'created_at' => 6, 'updated_at' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('elementXquestions');
        $this->setPhpName('ElementAssignment');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\ElementAssignment');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        $this->setIsCrossRef(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('examID', 'Examid', 'INTEGER', 'exams', 'id', true, null, null);
        $this->addForeignKey('questionID', 'Questionid', 'INTEGER', 'questions', 'id', true, null, null);
        $this->addColumn('subtask', 'Subtask', 'INTEGER', true, 2, null);
        $this->addForeignKey('elementID', 'Elementid', 'INTEGER', 'elements', 'id', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'users', 'id', true, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Question', '\\Question', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':questionID',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Element', '\\Element', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':elementID',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Exam', '\\Exam', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':examID',
    1 => ':id',
  ),
), null, null, null, false);
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
        return $withPrefix ? ElementAssignmentTableMap::CLASS_DEFAULT : ElementAssignmentTableMap::OM_CLASS;
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
     * @return array           (ElementAssignment object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ElementAssignmentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ElementAssignmentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ElementAssignmentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ElementAssignmentTableMap::OM_CLASS;
            /** @var ElementAssignment $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ElementAssignmentTableMap::addInstanceToPool($obj, $key);
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
            $key = ElementAssignmentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ElementAssignmentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var ElementAssignment $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ElementAssignmentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_ID);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_EXAMID);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_QUESTIONID);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_SUBTASK);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_ELEMENTID);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_USER_ID);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ElementAssignmentTableMap::COL_UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.examID');
            $criteria->addSelectColumn($alias . '.questionID');
            $criteria->addSelectColumn($alias . '.subtask');
            $criteria->addSelectColumn($alias . '.elementID');
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
        return Propel::getServiceContainer()->getDatabaseMap(ElementAssignmentTableMap::DATABASE_NAME)->getTable(ElementAssignmentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ElementAssignmentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ElementAssignmentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ElementAssignmentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a ElementAssignment or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or ElementAssignment object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ElementAssignmentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \ElementAssignment) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ElementAssignmentTableMap::DATABASE_NAME);
            $criteria->add(ElementAssignmentTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = ElementAssignmentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ElementAssignmentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ElementAssignmentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the elementXquestions table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ElementAssignmentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a ElementAssignment or Criteria object.
     *
     * @param mixed               $criteria Criteria or ElementAssignment object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ElementAssignmentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from ElementAssignment object
        }

        if ($criteria->containsKey(ElementAssignmentTableMap::COL_ID) && $criteria->keyContainsValue(ElementAssignmentTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ElementAssignmentTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = ElementAssignmentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ElementAssignmentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ElementAssignmentTableMap::buildTableMap();
