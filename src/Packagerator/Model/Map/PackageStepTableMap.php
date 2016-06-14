<?php

namespace Packagerator\Model\Map;

use Packagerator\Model\PackageStep;
use Packagerator\Model\PackageStepQuery;
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
 * This class defines the structure of the 'package_step' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PackageStepTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Packagerator.Model.Map.PackageStepTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'package_step';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Packagerator\\Model\\PackageStep';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Packagerator.Model.PackageStep';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the id field
     */
    const COL_ID = 'package_step.id';

    /**
     * the column name for the package_id field
     */
    const COL_PACKAGE_ID = 'package_step.package_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'package_step.name';

    /**
     * the column name for the package_step_type_id field
     */
    const COL_PACKAGE_STEP_TYPE_ID = 'package_step.package_step_type_id';

    /**
     * the column name for the related_package_id field
     */
    const COL_RELATED_PACKAGE_ID = 'package_step.related_package_id';

    /**
     * the column name for the sortable_rank field
     */
    const COL_SORTABLE_RANK = 'package_step.sortable_rank';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'package_step.version';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    // sortable behavior
    /**
     * rank column
     */
    const RANK_COL = "package_step.sortable_rank";



    /**
    * Scope column for the set
    */
    const SCOPE_COL = 'package_step.package_id';


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'PackageId', 'Name', 'PackageStepTypeId', 'RelatedPackageId', 'SortableRank', 'Version', ),
        self::TYPE_CAMELNAME     => array('id', 'packageId', 'name', 'packageStepTypeId', 'relatedPackageId', 'sortableRank', 'version', ),
        self::TYPE_COLNAME       => array(PackageStepTableMap::COL_ID, PackageStepTableMap::COL_PACKAGE_ID, PackageStepTableMap::COL_NAME, PackageStepTableMap::COL_PACKAGE_STEP_TYPE_ID, PackageStepTableMap::COL_RELATED_PACKAGE_ID, PackageStepTableMap::COL_SORTABLE_RANK, PackageStepTableMap::COL_VERSION, ),
        self::TYPE_FIELDNAME     => array('id', 'package_id', 'name', 'package_step_type_id', 'related_package_id', 'sortable_rank', 'version', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'PackageId' => 1, 'Name' => 2, 'PackageStepTypeId' => 3, 'RelatedPackageId' => 4, 'SortableRank' => 5, 'Version' => 6, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'packageId' => 1, 'name' => 2, 'packageStepTypeId' => 3, 'relatedPackageId' => 4, 'sortableRank' => 5, 'version' => 6, ),
        self::TYPE_COLNAME       => array(PackageStepTableMap::COL_ID => 0, PackageStepTableMap::COL_PACKAGE_ID => 1, PackageStepTableMap::COL_NAME => 2, PackageStepTableMap::COL_PACKAGE_STEP_TYPE_ID => 3, PackageStepTableMap::COL_RELATED_PACKAGE_ID => 4, PackageStepTableMap::COL_SORTABLE_RANK => 5, PackageStepTableMap::COL_VERSION => 6, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'package_id' => 1, 'name' => 2, 'package_step_type_id' => 3, 'related_package_id' => 4, 'sortable_rank' => 5, 'version' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('package_step');
        $this->setPhpName('PackageStep');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Packagerator\\Model\\PackageStep');
        $this->setPackage('Packagerator.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('package_id', 'PackageId', 'INTEGER', 'package', 'id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        $this->addForeignKey('package_step_type_id', 'PackageStepTypeId', 'INTEGER', 'package_step_type', 'id', true, null, null);
        $this->addForeignKey('related_package_id', 'RelatedPackageId', 'INTEGER', 'package', 'id', false, null, null);
        $this->addColumn('sortable_rank', 'SortableRank', 'INTEGER', false, null, null);
        $this->addColumn('version', 'Version', 'INTEGER', false, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Package', '\\Packagerator\\Model\\Package', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':package_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PackageStepType', '\\Packagerator\\Model\\PackageStepType', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':package_step_type_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('RelatedPackage', '\\Packagerator\\Model\\Package', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':related_package_id',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('PackageStepProperty', '\\Packagerator\\Model\\PackageStepProperty', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':package_step_id',
    1 => ':id',
  ),
), null, null, 'PackageStepProperties', false);
        $this->addRelation('PackageStepExecution', '\\Packagerator\\Model\\PackageStepExecution', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':package_step_id',
    1 => ':id',
  ),
), null, null, 'PackageStepExecutions', false);
        $this->addRelation('PackageStepVersion', '\\Packagerator\\Model\\PackageStepVersion', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, 'PackageStepVersions', false);
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
            'versionable' => array('version_column' => 'version', 'version_table' => '', 'log_created_at' => 'false', 'log_created_by' => 'false', 'log_comment' => 'false', 'version_created_at_column' => 'version_created_at', 'version_created_by_column' => 'version_created_by', 'version_comment_column' => 'version_comment', 'indices' => 'false', ),
            'sortable' => array('rank_column' => 'sortable_rank', 'use_scope' => 'true', 'scope_column' => 'package_id', ),
        );
    } // getBehaviors()
    /**
     * Method to invalidate the instance pool of all tables related to package_step     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PackageStepVersionTableMap::clearInstancePool();
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
        return $withPrefix ? PackageStepTableMap::CLASS_DEFAULT : PackageStepTableMap::OM_CLASS;
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
     * @return array           (PackageStep object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PackageStepTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PackageStepTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PackageStepTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PackageStepTableMap::OM_CLASS;
            /** @var PackageStep $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PackageStepTableMap::addInstanceToPool($obj, $key);
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
            $key = PackageStepTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PackageStepTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PackageStep $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PackageStepTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PackageStepTableMap::COL_ID);
            $criteria->addSelectColumn(PackageStepTableMap::COL_PACKAGE_ID);
            $criteria->addSelectColumn(PackageStepTableMap::COL_NAME);
            $criteria->addSelectColumn(PackageStepTableMap::COL_PACKAGE_STEP_TYPE_ID);
            $criteria->addSelectColumn(PackageStepTableMap::COL_RELATED_PACKAGE_ID);
            $criteria->addSelectColumn(PackageStepTableMap::COL_SORTABLE_RANK);
            $criteria->addSelectColumn(PackageStepTableMap::COL_VERSION);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.package_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.package_step_type_id');
            $criteria->addSelectColumn($alias . '.related_package_id');
            $criteria->addSelectColumn($alias . '.sortable_rank');
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
        return Propel::getServiceContainer()->getDatabaseMap(PackageStepTableMap::DATABASE_NAME)->getTable(PackageStepTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PackageStepTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PackageStepTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PackageStepTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PackageStep or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PackageStep object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Packagerator\Model\PackageStep) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PackageStepTableMap::DATABASE_NAME);
            $criteria->add(PackageStepTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PackageStepQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PackageStepTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PackageStepTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the package_step table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PackageStepQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PackageStep or Criteria object.
     *
     * @param mixed               $criteria Criteria or PackageStep object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PackageStep object
        }

        if ($criteria->containsKey(PackageStepTableMap::COL_ID) && $criteria->keyContainsValue(PackageStepTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PackageStepTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PackageStepQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PackageStepTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PackageStepTableMap::buildTableMap();