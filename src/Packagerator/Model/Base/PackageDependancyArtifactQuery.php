<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\PackageDependancyArtifact as ChildPackageDependancyArtifact;
use Packagerator\Model\PackageDependancyArtifactQuery as ChildPackageDependancyArtifactQuery;
use Packagerator\Model\Map\PackageDependancyArtifactTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'package_dependancy_artifact' table.
 *
 *
 *
 * @method     ChildPackageDependancyArtifactQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPackageDependancyArtifactQuery orderByPackageId($order = Criteria::ASC) Order by the package_id column
 * @method     ChildPackageDependancyArtifactQuery orderByPackageVersionId($order = Criteria::ASC) Order by the package_version_id column
 * @method     ChildPackageDependancyArtifactQuery orderByChecksum($order = Criteria::ASC) Order by the checksum column
 * @method     ChildPackageDependancyArtifactQuery orderByArtifactTypeId($order = Criteria::ASC) Order by the artifact_type_id column
 * @method     ChildPackageDependancyArtifactQuery orderByArtifactPath($order = Criteria::ASC) Order by the artifact_path column
 *
 * @method     ChildPackageDependancyArtifactQuery groupById() Group by the id column
 * @method     ChildPackageDependancyArtifactQuery groupByPackageId() Group by the package_id column
 * @method     ChildPackageDependancyArtifactQuery groupByPackageVersionId() Group by the package_version_id column
 * @method     ChildPackageDependancyArtifactQuery groupByChecksum() Group by the checksum column
 * @method     ChildPackageDependancyArtifactQuery groupByArtifactTypeId() Group by the artifact_type_id column
 * @method     ChildPackageDependancyArtifactQuery groupByArtifactPath() Group by the artifact_path column
 *
 * @method     ChildPackageDependancyArtifactQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPackageDependancyArtifactQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPackageDependancyArtifactQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPackageDependancyArtifactQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPackageDependancyArtifactQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPackageDependancyArtifactQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPackageDependancyArtifact findOne(ConnectionInterface $con = null) Return the first ChildPackageDependancyArtifact matching the query
 * @method     ChildPackageDependancyArtifact findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPackageDependancyArtifact matching the query, or a new ChildPackageDependancyArtifact object populated from the query conditions when no match is found
 *
 * @method     ChildPackageDependancyArtifact findOneById(int $id) Return the first ChildPackageDependancyArtifact filtered by the id column
 * @method     ChildPackageDependancyArtifact findOneByPackageId(int $package_id) Return the first ChildPackageDependancyArtifact filtered by the package_id column
 * @method     ChildPackageDependancyArtifact findOneByPackageVersionId(int $package_version_id) Return the first ChildPackageDependancyArtifact filtered by the package_version_id column
 * @method     ChildPackageDependancyArtifact findOneByChecksum(string $checksum) Return the first ChildPackageDependancyArtifact filtered by the checksum column
 * @method     ChildPackageDependancyArtifact findOneByArtifactTypeId(int $artifact_type_id) Return the first ChildPackageDependancyArtifact filtered by the artifact_type_id column
 * @method     ChildPackageDependancyArtifact findOneByArtifactPath(string $artifact_path) Return the first ChildPackageDependancyArtifact filtered by the artifact_path column *

 * @method     ChildPackageDependancyArtifact requirePk($key, ConnectionInterface $con = null) Return the ChildPackageDependancyArtifact by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyArtifact requireOne(ConnectionInterface $con = null) Return the first ChildPackageDependancyArtifact matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageDependancyArtifact requireOneById(int $id) Return the first ChildPackageDependancyArtifact filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyArtifact requireOneByPackageId(int $package_id) Return the first ChildPackageDependancyArtifact filtered by the package_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyArtifact requireOneByPackageVersionId(int $package_version_id) Return the first ChildPackageDependancyArtifact filtered by the package_version_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyArtifact requireOneByChecksum(string $checksum) Return the first ChildPackageDependancyArtifact filtered by the checksum column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyArtifact requireOneByArtifactTypeId(int $artifact_type_id) Return the first ChildPackageDependancyArtifact filtered by the artifact_type_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyArtifact requireOneByArtifactPath(string $artifact_path) Return the first ChildPackageDependancyArtifact filtered by the artifact_path column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPackageDependancyArtifact objects based on current ModelCriteria
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection findById(int $id) Return ChildPackageDependancyArtifact objects filtered by the id column
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection findByPackageId(int $package_id) Return ChildPackageDependancyArtifact objects filtered by the package_id column
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection findByPackageVersionId(int $package_version_id) Return ChildPackageDependancyArtifact objects filtered by the package_version_id column
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection findByChecksum(string $checksum) Return ChildPackageDependancyArtifact objects filtered by the checksum column
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection findByArtifactTypeId(int $artifact_type_id) Return ChildPackageDependancyArtifact objects filtered by the artifact_type_id column
 * @method     ChildPackageDependancyArtifact[]|ObjectCollection findByArtifactPath(string $artifact_path) Return ChildPackageDependancyArtifact objects filtered by the artifact_path column
 * @method     ChildPackageDependancyArtifact[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PackageDependancyArtifactQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\PackageDependancyArtifactQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\PackageDependancyArtifact', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPackageDependancyArtifactQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPackageDependancyArtifactQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPackageDependancyArtifactQuery) {
            return $criteria;
        }
        $query = new ChildPackageDependancyArtifactQuery();
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
     * @return ChildPackageDependancyArtifact|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageDependancyArtifactTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PackageDependancyArtifactTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPackageDependancyArtifact A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, package_id, package_version_id, checksum, artifact_type_id, artifact_path FROM package_dependancy_artifact WHERE id = :p0';
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
            /** @var ChildPackageDependancyArtifact $obj */
            $obj = new ChildPackageDependancyArtifact();
            $obj->hydrate($row);
            PackageDependancyArtifactTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPackageDependancyArtifact|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the package_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPackageId(1234); // WHERE package_id = 1234
     * $query->filterByPackageId(array(12, 34)); // WHERE package_id IN (12, 34)
     * $query->filterByPackageId(array('min' => 12)); // WHERE package_id > 12
     * </code>
     *
     * @param     mixed $packageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByPackageId($packageId = null, $comparison = null)
    {
        if (is_array($packageId)) {
            $useMinMax = false;
            if (isset($packageId['min'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_PACKAGE_ID, $packageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageId['max'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_PACKAGE_ID, $packageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_PACKAGE_ID, $packageId, $comparison);
    }

    /**
     * Filter the query on the package_version_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPackageVersionId(1234); // WHERE package_version_id = 1234
     * $query->filterByPackageVersionId(array(12, 34)); // WHERE package_version_id IN (12, 34)
     * $query->filterByPackageVersionId(array('min' => 12)); // WHERE package_version_id > 12
     * </code>
     *
     * @param     mixed $packageVersionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByPackageVersionId($packageVersionId = null, $comparison = null)
    {
        if (is_array($packageVersionId)) {
            $useMinMax = false;
            if (isset($packageVersionId['min'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_PACKAGE_VERSION_ID, $packageVersionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageVersionId['max'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_PACKAGE_VERSION_ID, $packageVersionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_PACKAGE_VERSION_ID, $packageVersionId, $comparison);
    }

    /**
     * Filter the query on the checksum column
     *
     * Example usage:
     * <code>
     * $query->filterByChecksum('fooValue');   // WHERE checksum = 'fooValue'
     * $query->filterByChecksum('%fooValue%'); // WHERE checksum LIKE '%fooValue%'
     * </code>
     *
     * @param     string $checksum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByChecksum($checksum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($checksum)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_CHECKSUM, $checksum, $comparison);
    }

    /**
     * Filter the query on the artifact_type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArtifactTypeId(1234); // WHERE artifact_type_id = 1234
     * $query->filterByArtifactTypeId(array(12, 34)); // WHERE artifact_type_id IN (12, 34)
     * $query->filterByArtifactTypeId(array('min' => 12)); // WHERE artifact_type_id > 12
     * </code>
     *
     * @param     mixed $artifactTypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByArtifactTypeId($artifactTypeId = null, $comparison = null)
    {
        if (is_array($artifactTypeId)) {
            $useMinMax = false;
            if (isset($artifactTypeId['min'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ARTIFACT_TYPE_ID, $artifactTypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($artifactTypeId['max'])) {
                $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ARTIFACT_TYPE_ID, $artifactTypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ARTIFACT_TYPE_ID, $artifactTypeId, $comparison);
    }

    /**
     * Filter the query on the artifact_path column
     *
     * Example usage:
     * <code>
     * $query->filterByArtifactPath('fooValue');   // WHERE artifact_path = 'fooValue'
     * $query->filterByArtifactPath('%fooValue%'); // WHERE artifact_path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $artifactPath The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function filterByArtifactPath($artifactPath = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($artifactPath)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ARTIFACT_PATH, $artifactPath, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPackageDependancyArtifact $packageDependancyArtifact Object to remove from the list of results
     *
     * @return $this|ChildPackageDependancyArtifactQuery The current query, for fluid interface
     */
    public function prune($packageDependancyArtifact = null)
    {
        if ($packageDependancyArtifact) {
            $this->addUsingAlias(PackageDependancyArtifactTableMap::COL_ID, $packageDependancyArtifact->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the package_dependancy_artifact table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyArtifactTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PackageDependancyArtifactTableMap::clearInstancePool();
            PackageDependancyArtifactTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyArtifactTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PackageDependancyArtifactTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PackageDependancyArtifactTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PackageDependancyArtifactTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PackageDependancyArtifactQuery
