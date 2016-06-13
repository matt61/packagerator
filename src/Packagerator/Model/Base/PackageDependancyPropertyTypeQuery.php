<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\PackageDependancyPropertyType as ChildPackageDependancyPropertyType;
use Packagerator\Model\PackageDependancyPropertyTypeQuery as ChildPackageDependancyPropertyTypeQuery;
use Packagerator\Model\Map\PackageDependancyPropertyTypeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'package_dependancy_property_type' table.
 *
 *
 *
 * @method     ChildPackageDependancyPropertyTypeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPackageDependancyPropertyTypeQuery orderByConfigurationId($order = Criteria::ASC) Order by the configuration_id column
 * @method     ChildPackageDependancyPropertyTypeQuery orderByPropertyTypeId($order = Criteria::ASC) Order by the property_type_id column
 * @method     ChildPackageDependancyPropertyTypeQuery orderByVersionId($order = Criteria::ASC) Order by the version_id column
 *
 * @method     ChildPackageDependancyPropertyTypeQuery groupById() Group by the id column
 * @method     ChildPackageDependancyPropertyTypeQuery groupByConfigurationId() Group by the configuration_id column
 * @method     ChildPackageDependancyPropertyTypeQuery groupByPropertyTypeId() Group by the property_type_id column
 * @method     ChildPackageDependancyPropertyTypeQuery groupByVersionId() Group by the version_id column
 *
 * @method     ChildPackageDependancyPropertyTypeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPackageDependancyPropertyTypeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPackageDependancyPropertyTypeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPackageDependancyPropertyTypeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPackageDependancyPropertyTypeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPackageDependancyPropertyTypeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPackageDependancyPropertyType findOne(ConnectionInterface $con = null) Return the first ChildPackageDependancyPropertyType matching the query
 * @method     ChildPackageDependancyPropertyType findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPackageDependancyPropertyType matching the query, or a new ChildPackageDependancyPropertyType object populated from the query conditions when no match is found
 *
 * @method     ChildPackageDependancyPropertyType findOneById(int $id) Return the first ChildPackageDependancyPropertyType filtered by the id column
 * @method     ChildPackageDependancyPropertyType findOneByConfigurationId(int $configuration_id) Return the first ChildPackageDependancyPropertyType filtered by the configuration_id column
 * @method     ChildPackageDependancyPropertyType findOneByPropertyTypeId(int $property_type_id) Return the first ChildPackageDependancyPropertyType filtered by the property_type_id column
 * @method     ChildPackageDependancyPropertyType findOneByVersionId(int $version_id) Return the first ChildPackageDependancyPropertyType filtered by the version_id column *

 * @method     ChildPackageDependancyPropertyType requirePk($key, ConnectionInterface $con = null) Return the ChildPackageDependancyPropertyType by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyPropertyType requireOne(ConnectionInterface $con = null) Return the first ChildPackageDependancyPropertyType matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageDependancyPropertyType requireOneById(int $id) Return the first ChildPackageDependancyPropertyType filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyPropertyType requireOneByConfigurationId(int $configuration_id) Return the first ChildPackageDependancyPropertyType filtered by the configuration_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyPropertyType requireOneByPropertyTypeId(int $property_type_id) Return the first ChildPackageDependancyPropertyType filtered by the property_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyPropertyType requireOneByVersionId(int $version_id) Return the first ChildPackageDependancyPropertyType filtered by the version_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageDependancyPropertyType[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPackageDependancyPropertyType objects based on current ModelCriteria
 * @method     ChildPackageDependancyPropertyType[]|ObjectCollection findById(int $id) Return ChildPackageDependancyPropertyType objects filtered by the id column
 * @method     ChildPackageDependancyPropertyType[]|ObjectCollection findByConfigurationId(int $configuration_id) Return ChildPackageDependancyPropertyType objects filtered by the configuration_id column
 * @method     ChildPackageDependancyPropertyType[]|ObjectCollection findByPropertyTypeId(int $property_type_id) Return ChildPackageDependancyPropertyType objects filtered by the property_type_id column
 * @method     ChildPackageDependancyPropertyType[]|ObjectCollection findByVersionId(int $version_id) Return ChildPackageDependancyPropertyType objects filtered by the version_id column
 * @method     ChildPackageDependancyPropertyType[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PackageDependancyPropertyTypeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\PackageDependancyPropertyTypeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\PackageDependancyPropertyType', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPackageDependancyPropertyTypeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPackageDependancyPropertyTypeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPackageDependancyPropertyTypeQuery) {
            return $criteria;
        }
        $query = new ChildPackageDependancyPropertyTypeQuery();
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
     * @return ChildPackageDependancyPropertyType|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageDependancyPropertyTypeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PackageDependancyPropertyTypeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
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
     * @return ChildPackageDependancyPropertyType A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, configuration_id, property_type_id, version_id FROM package_dependancy_property_type WHERE id = :p0';
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
            /** @var ChildPackageDependancyPropertyType $obj */
            $obj = new ChildPackageDependancyPropertyType();
            $obj->hydrate($row);
            PackageDependancyPropertyTypeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPackageDependancyPropertyType|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the configuration_id column
     *
     * Example usage:
     * <code>
     * $query->filterByConfigurationId(1234); // WHERE configuration_id = 1234
     * $query->filterByConfigurationId(array(12, 34)); // WHERE configuration_id IN (12, 34)
     * $query->filterByConfigurationId(array('min' => 12)); // WHERE configuration_id > 12
     * </code>
     *
     * @param     mixed $configurationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function filterByConfigurationId($configurationId = null, $comparison = null)
    {
        if (is_array($configurationId)) {
            $useMinMax = false;
            if (isset($configurationId['min'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_CONFIGURATION_ID, $configurationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($configurationId['max'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_CONFIGURATION_ID, $configurationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_CONFIGURATION_ID, $configurationId, $comparison);
    }

    /**
     * Filter the query on the property_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPropertyTypeId(1234); // WHERE property_type_id = 1234
     * $query->filterByPropertyTypeId(array(12, 34)); // WHERE property_type_id IN (12, 34)
     * $query->filterByPropertyTypeId(array('min' => 12)); // WHERE property_type_id > 12
     * </code>
     *
     * @param     mixed $propertyTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function filterByPropertyTypeId($propertyTypeId = null, $comparison = null)
    {
        if (is_array($propertyTypeId)) {
            $useMinMax = false;
            if (isset($propertyTypeId['min'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_PROPERTY_TYPE_ID, $propertyTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($propertyTypeId['max'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_PROPERTY_TYPE_ID, $propertyTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_PROPERTY_TYPE_ID, $propertyTypeId, $comparison);
    }

    /**
     * Filter the query on the version_id column
     *
     * Example usage:
     * <code>
     * $query->filterByVersionId(1234); // WHERE version_id = 1234
     * $query->filterByVersionId(array(12, 34)); // WHERE version_id IN (12, 34)
     * $query->filterByVersionId(array('min' => 12)); // WHERE version_id > 12
     * </code>
     *
     * @param     mixed $versionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function filterByVersionId($versionId = null, $comparison = null)
    {
        if (is_array($versionId)) {
            $useMinMax = false;
            if (isset($versionId['min'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_VERSION_ID, $versionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionId['max'])) {
                $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_VERSION_ID, $versionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_VERSION_ID, $versionId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPackageDependancyPropertyType $packageDependancyPropertyType Object to remove from the list of results
     *
     * @return $this|ChildPackageDependancyPropertyTypeQuery The current query, for fluid interface
     */
    public function prune($packageDependancyPropertyType = null)
    {
        if ($packageDependancyPropertyType) {
            $this->addUsingAlias(PackageDependancyPropertyTypeTableMap::COL_ID, $packageDependancyPropertyType->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the package_dependancy_property_type table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyPropertyTypeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PackageDependancyPropertyTypeTableMap::clearInstancePool();
            PackageDependancyPropertyTypeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyPropertyTypeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PackageDependancyPropertyTypeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PackageDependancyPropertyTypeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PackageDependancyPropertyTypeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PackageDependancyPropertyTypeQuery
