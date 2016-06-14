<?php

namespace Packagerator\Model\Map;

use Packagerator\Model\PackageStepExecution;
use Packagerator\Model\PackageStepExecutionQuery;
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
 * This class defines the structure of the 'package_step_execution' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PackageStepExecutionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Packagerator.Model.Map.PackageStepExecutionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'package_step_execution';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Packagerator\\Model\\PackageStepExecution';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Packagerator.Model.PackageStepExecution';

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
    const COL_ID = 'package_step_execution.id';

    /**
     * the column name for the package_step_id field
     */
    const COL_PACKAGE_STEP_ID = 'package_step_execution.package_step_id';

    /**
     * the column name for the input field
     */
    const COL_INPUT = 'package_step_execution.input';

    /**
     * the column name for the output_code field
     */
    const COL_OUTPUT_CODE = 'package_step_execution.output_code';

    /**
     * the column name for the output_pattern field
     */
    const COL_OUTPUT_PATTERN = 'package_step_execution.output_pattern';

    /**
     * the column name for the sortable_rank field
     */
    const COL_SORTABLE_RANK = 'package_step_execution.sortable_rank';

    /**
     * the column name for the package_id field
     */
    const COL_PACKAGE_ID = 'package_step_execution.package_id';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'package_step_execution.version';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // sortable behavior
    /**
     * rank column
     */
    const RANK_COL = "package_step_execution.sortable_rank";



    /**
    * Scope column for the set
    */
    const SCOPE_COL = 'package_step_execution.package_id';


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'PackageStepId', 'Input', 'OutputCode', 'OutputPattern', 'SortableRank', 'PackageId', 'Version', ),
        self::TYPE_CAMELNAME     => array('id', 'packageStepId', 'input', 'outputCode', 'outputPattern', 'sortableRank', 'packageId', 'version', ),
        self::TYPE_COLNAME       => array(PackageStepExecutionTableMap::COL_ID, PackageStepExecutionTableMap::COL_PACKAGE_STEP_ID, PackageStepExecutionTableMap::COL_INPUT, PackageStepExecutionTableMap::COL_OUTPUT_CODE, PackageStepExecutionTableMap::COL_OUTPUT_PATTERN, PackageStepExecutionTableMap::COL_SORTABLE_RANK, PackageStepExecutionTableMap::COL_PACKAGE_ID, PackageStepExecutionTableMap::COL_VERSION, ),
        self::TYPE_FIELDNAME     => array('id', 'package_step_id', 'input', 'output_code', 'output_pattern', 'sortable_rank', 'package_id', 'version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PackageStepId' => 1, 'Input' => 2, 'OutputCode' => 3, 'OutputPattern' => 4, 'SortableRank' => 5, 'PackageId' => 6, 'Version' => 7, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'packageStepId' => 1, 'input' => 2, 'outputCode' => 3, 'outputPattern' => 4, 'sortableRank' => 5, 'packageId' => 6, 'version' => 7, ),
        self::TYPE_COLNAME       => array(PackageStepExecutionTableMap::COL_ID => 0, PackageStepExecutionTableMap::COL_PACKAGE_STEP_ID => 1, PackageStepExecutionTableMap::COL_INPUT => 2, PackageStepExecutionTableMap::COL_OUTPUT_CODE => 3, PackageStepExecutionTableMap::COL_OUTPUT_PATTERN => 4, PackageStepExecutionTableMap::COL_SORTABLE_RANK => 5, PackageStepExecutionTableMap::COL_PACKAGE_ID => 6, PackageStepExecutionTableMap::COL_VERSION => 7, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'package_step_id' => 1, 'input' => 2, 'output_code' => 3, 'output_pattern' => 4, 'sortable_rank' => 5, 'package_id' => 6, 'version' => 7, ),
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
        $this->setName('package_step_execution');
        $this->setPhpName('PackageStepExecution');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Packagerator\\Model\\PackageStepExecution');
        $this->setPackage('Packagerator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('package_step_id', 'PackageStepId', 'INTEGER', 'package_step', 'id', true, null, null);
        $this->addColumn('input', 'Input', 'VARCHAR', true, 250, null);
        $this->addColumn('output_code', 'OutputCode', 'INTEGER', false, null, null);
        $this->addColumn('output_pattern', 'OutputPattern', 'VARCHAR', false, 250, null);
        $this->addColumn('sortable_rank', 'SortableRank', 'INTEGER', false, null, null);
        $this->addColumn('package_id', 'PackageId', 'INTEGER', false, null, null);
        $this->addColumn('version', 'Version', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('PackageStep', '\\Packagerator\\Model\\PackageStep', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':package_step_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PackageStepExecutionVersion', '\\Packagerator\\Model\\PackageStepExecutionVersion', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'PackageStepExecutionVersions', false);
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
            'sortable' => array('rank_column' => 'sortable_rank', 'use_scope' => 'true', 'scope_column' => 'package_id', ),
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'false', 'log_created_by' => 'false', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', 'indices' => 'false', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to package_step_execution     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PackageStepExecutionVersionTableMap::clearInstancePool();
    }

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

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return $withPrefix ? PackageStepExecutionTableMap::CLASS_DEFAULT : PackageStepExecutionTableMap::OM_CLASS;
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
     * @return array           (PackageStepExecution object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PackageStepExecutionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PackageStepExecutionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PackageStepExecutionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PackageStepExecutionTableMap::OM_CLASS;
            /** @var PackageStepExecution $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PackageStepExecutionTableMap::addInstanceToPool($obj, $key);
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
            $key = PackageStepExecutionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PackageStepExecutionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PackageStepExecution $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PackageStepExecutionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_ID);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_PACKAGE_STEP_ID);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_INPUT);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_OUTPUT_CODE);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_OUTPUT_PATTERN);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_SORTABLE_RANK);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_PACKAGE_ID);
            $criteria->addSelectColumn(PackageStepExecutionTableMap::COL_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.package_step_id');
            $criteria->addSelectColumn($alias . '.input');
            $criteria->addSelectColumn($alias . '.output_code');
            $criteria->addSelectColumn($alias . '.output_pattern');
            $criteria->addSelectColumn($alias . '.sortable_rank');
            $criteria->addSelectColumn($alias . '.package_id');
            $criteria->addSelectColumn($alias . '.version');
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
        return Propel::getServiceContainer()->getDatabaseMap(PackageStepExecutionTableMap::DATABASE_NAME)->getTable(PackageStepExecutionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PackageStepExecutionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PackageStepExecutionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PackageStepExecutionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PackageStepExecution or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PackageStepExecution object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepExecutionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Packagerator\Model\PackageStepExecution) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PackageStepExecutionTableMap::DATABASE_NAME);
            $criteria->add(PackageStepExecutionTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PackageStepExecutionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PackageStepExecutionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PackageStepExecutionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the package_step_execution table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PackageStepExecutionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PackageStepExecution or Criteria object.
     *
     * @param mixed               $criteria Criteria or PackageStepExecution object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepExecutionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PackageStepExecution object
        }

        if ($criteria->containsKey(PackageStepExecutionTableMap::COL_ID) && $criteria->keyContainsValue(PackageStepExecutionTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PackageStepExecutionTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PackageStepExecutionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PackageStepExecutionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PackageStepExecutionTableMap::buildTableMap();
