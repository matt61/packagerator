<?php

namespace Packagerator\Model\Map;

use Packagerator\Model\PackageVersion;
use Packagerator\Model\PackageVersionQuery;
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
 * This class defines the structure of the 'package_version' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PackageVersionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Packagerator.Model.Map.PackageVersionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'package_version';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Packagerator\\Model\\PackageVersion';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Packagerator.Model.PackageVersion';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the id field
     */
    const COL_ID = 'package_version.id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'package_version.name';

    /**
     * the column name for the version field
     */
    const COL_VERSION = 'package_version.version';

    /**
     * the column name for the package_dependancy_ids field
     */
    const COL_PACKAGE_DEPENDANCY_IDS = 'package_version.package_dependancy_ids';

    /**
     * the column name for the package_dependancy_versions field
     */
    const COL_PACKAGE_DEPENDANCY_VERSIONS = 'package_version.package_dependancy_versions';

    /**
     * the column name for the package_dependancy_artifact_ids field
     */
    const COL_PACKAGE_DEPENDANCY_ARTIFACT_IDS = 'package_version.package_dependancy_artifact_ids';

    /**
     * the column name for the package_dependancy_artifact_versions field
     */
    const COL_PACKAGE_DEPENDANCY_ARTIFACT_VERSIONS = 'package_version.package_dependancy_artifact_versions';

    /**
     * the column name for the package_property_ids field
     */
    const COL_PACKAGE_PROPERTY_IDS = 'package_version.package_property_ids';

    /**
     * the column name for the package_property_versions field
     */
    const COL_PACKAGE_PROPERTY_VERSIONS = 'package_version.package_property_versions';

    /**
     * the column name for the package_role_ids field
     */
    const COL_PACKAGE_ROLE_IDS = 'package_version.package_role_ids';

    /**
     * the column name for the package_role_versions field
     */
    const COL_PACKAGE_ROLE_VERSIONS = 'package_version.package_role_versions';

    /**
     * the column name for the package_step_ids field
     */
    const COL_PACKAGE_STEP_IDS = 'package_version.package_step_ids';

    /**
     * the column name for the package_step_versions field
     */
    const COL_PACKAGE_STEP_VERSIONS = 'package_version.package_step_versions';

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
        self::TYPE_PHPNAME       => array('Id', 'Name', 'Version', 'PackageDependancyIds', 'PackageDependancyVersions', 'PackageDependancyArtifactIds', 'PackageDependancyArtifactVersions', 'PackagePropertyIds', 'PackagePropertyVersions', 'PackageRoleIds', 'PackageRoleVersions', 'PackageStepIds', 'PackageStepVersions', ),
        self::TYPE_CAMELNAME     => array('id', 'name', 'version', 'packageDependancyIds', 'packageDependancyVersions', 'packageDependancyArtifactIds', 'packageDependancyArtifactVersions', 'packagePropertyIds', 'packagePropertyVersions', 'packageRoleIds', 'packageRoleVersions', 'packageStepIds', 'packageStepVersions', ),
        self::TYPE_COLNAME       => array(PackageVersionTableMap::COL_ID, PackageVersionTableMap::COL_NAME, PackageVersionTableMap::COL_VERSION, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_IDS, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_VERSIONS, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_ARTIFACT_IDS, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_ARTIFACT_VERSIONS, PackageVersionTableMap::COL_PACKAGE_PROPERTY_IDS, PackageVersionTableMap::COL_PACKAGE_PROPERTY_VERSIONS, PackageVersionTableMap::COL_PACKAGE_ROLE_IDS, PackageVersionTableMap::COL_PACKAGE_ROLE_VERSIONS, PackageVersionTableMap::COL_PACKAGE_STEP_IDS, PackageVersionTableMap::COL_PACKAGE_STEP_VERSIONS, ),
        self::TYPE_FIELDNAME     => array('id', 'name', 'version', 'package_dependancy_ids', 'package_dependancy_versions', 'package_dependancy_artifact_ids', 'package_dependancy_artifact_versions', 'package_property_ids', 'package_property_versions', 'package_role_ids', 'package_role_versions', 'package_step_ids', 'package_step_versions', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Name' => 1, 'Version' => 2, 'PackageDependancyIds' => 3, 'PackageDependancyVersions' => 4, 'PackageDependancyArtifactIds' => 5, 'PackageDependancyArtifactVersions' => 6, 'PackagePropertyIds' => 7, 'PackagePropertyVersions' => 8, 'PackageRoleIds' => 9, 'PackageRoleVersions' => 10, 'PackageStepIds' => 11, 'PackageStepVersions' => 12, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'name' => 1, 'version' => 2, 'packageDependancyIds' => 3, 'packageDependancyVersions' => 4, 'packageDependancyArtifactIds' => 5, 'packageDependancyArtifactVersions' => 6, 'packagePropertyIds' => 7, 'packagePropertyVersions' => 8, 'packageRoleIds' => 9, 'packageRoleVersions' => 10, 'packageStepIds' => 11, 'packageStepVersions' => 12, ),
        self::TYPE_COLNAME       => array(PackageVersionTableMap::COL_ID => 0, PackageVersionTableMap::COL_NAME => 1, PackageVersionTableMap::COL_VERSION => 2, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_IDS => 3, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_VERSIONS => 4, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_ARTIFACT_IDS => 5, PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_ARTIFACT_VERSIONS => 6, PackageVersionTableMap::COL_PACKAGE_PROPERTY_IDS => 7, PackageVersionTableMap::COL_PACKAGE_PROPERTY_VERSIONS => 8, PackageVersionTableMap::COL_PACKAGE_ROLE_IDS => 9, PackageVersionTableMap::COL_PACKAGE_ROLE_VERSIONS => 10, PackageVersionTableMap::COL_PACKAGE_STEP_IDS => 11, PackageVersionTableMap::COL_PACKAGE_STEP_VERSIONS => 12, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'name' => 1, 'version' => 2, 'package_dependancy_ids' => 3, 'package_dependancy_versions' => 4, 'package_dependancy_artifact_ids' => 5, 'package_dependancy_artifact_versions' => 6, 'package_property_ids' => 7, 'package_property_versions' => 8, 'package_role_ids' => 9, 'package_role_versions' => 10, 'package_step_ids' => 11, 'package_step_versions' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
        $this->setName('package_version');
        $this->setPhpName('PackageVersion');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Packagerator\\Model\\PackageVersion');
        $this->setPackage('Packagerator.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id', 'Id', 'INTEGER' , 'package', 'id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 50, null);
        $this->addPrimaryKey('version', 'Version', 'INTEGER', true, null, 0);
        $this->addColumn('package_dependancy_ids', 'PackageDependancyIds', 'ARRAY', false, null, null);
        $this->addColumn('package_dependancy_versions', 'PackageDependancyVersions', 'ARRAY', false, null, null);
        $this->addColumn('package_dependancy_artifact_ids', 'PackageDependancyArtifactIds', 'ARRAY', false, null, null);
        $this->addColumn('package_dependancy_artifact_versions', 'PackageDependancyArtifactVersions', 'ARRAY', false, null, null);
        $this->addColumn('package_property_ids', 'PackagePropertyIds', 'ARRAY', false, null, null);
        $this->addColumn('package_property_versions', 'PackagePropertyVersions', 'ARRAY', false, null, null);
        $this->addColumn('package_role_ids', 'PackageRoleIds', 'ARRAY', false, null, null);
        $this->addColumn('package_role_versions', 'PackageRoleVersions', 'ARRAY', false, null, null);
        $this->addColumn('package_step_ids', 'PackageStepIds', 'ARRAY', false, null, null);
        $this->addColumn('package_step_versions', 'PackageStepVersions', 'ARRAY', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Package', '\\Packagerator\\Model\\Package', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id',
    1 => ':id',
  ),
), 'CASCADE', null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Packagerator\Model\PackageVersion $obj A \Packagerator\Model\PackageVersion object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getId() || is_scalar($obj->getId()) || is_callable([$obj->getId(), '__toString']) ? (string) $obj->getId() : $obj->getId()), (null === $obj->getVersion() || is_scalar($obj->getVersion()) || is_callable([$obj->getVersion(), '__toString']) ? (string) $obj->getVersion() : $obj->getVersion())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Packagerator\Model\PackageVersion object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Packagerator\Model\PackageVersion) {
                $key = serialize([(null === $value->getId() || is_scalar($value->getId()) || is_callable([$value->getId(), '__toString']) ? (string) $value->getId() : $value->getId()), (null === $value->getVersion() || is_scalar($value->getVersion()) || is_callable([$value->getVersion(), '__toString']) ? (string) $value->getVersion() : $value->getVersion())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Packagerator\Model\PackageVersion object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)])]);
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
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 2 + $offset
                : self::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
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
        return $withPrefix ? PackageVersionTableMap::CLASS_DEFAULT : PackageVersionTableMap::OM_CLASS;
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
     * @return array           (PackageVersion object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PackageVersionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PackageVersionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PackageVersionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PackageVersionTableMap::OM_CLASS;
            /** @var PackageVersion $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PackageVersionTableMap::addInstanceToPool($obj, $key);
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
            $key = PackageVersionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PackageVersionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var PackageVersion $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PackageVersionTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PackageVersionTableMap::COL_ID);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_NAME);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_VERSION);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_IDS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_VERSIONS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_ARTIFACT_IDS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_DEPENDANCY_ARTIFACT_VERSIONS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_PROPERTY_IDS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_PROPERTY_VERSIONS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_ROLE_IDS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_ROLE_VERSIONS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_STEP_IDS);
            $criteria->addSelectColumn(PackageVersionTableMap::COL_PACKAGE_STEP_VERSIONS);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.package_dependancy_ids');
            $criteria->addSelectColumn($alias . '.package_dependancy_versions');
            $criteria->addSelectColumn($alias . '.package_dependancy_artifact_ids');
            $criteria->addSelectColumn($alias . '.package_dependancy_artifact_versions');
            $criteria->addSelectColumn($alias . '.package_property_ids');
            $criteria->addSelectColumn($alias . '.package_property_versions');
            $criteria->addSelectColumn($alias . '.package_role_ids');
            $criteria->addSelectColumn($alias . '.package_role_versions');
            $criteria->addSelectColumn($alias . '.package_step_ids');
            $criteria->addSelectColumn($alias . '.package_step_versions');
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
        return Propel::getServiceContainer()->getDatabaseMap(PackageVersionTableMap::DATABASE_NAME)->getTable(PackageVersionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PackageVersionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PackageVersionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PackageVersionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a PackageVersion or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or PackageVersion object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageVersionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Packagerator\Model\PackageVersion) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PackageVersionTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(PackageVersionTableMap::COL_ID, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(PackageVersionTableMap::COL_VERSION, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = PackageVersionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PackageVersionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PackageVersionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the package_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PackageVersionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a PackageVersion or Criteria object.
     *
     * @param mixed               $criteria Criteria or PackageVersion object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageVersionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from PackageVersion object
        }


        // Set the correct dbName
        $query = PackageVersionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PackageVersionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PackageVersionTableMap::buildTableMap();
