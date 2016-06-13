<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\PackageStep as ChildPackageStep;
use Packagerator\Model\PackageStepQuery as ChildPackageStepQuery;
use Packagerator\Model\Map\PackageStepTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'package_step' table.
 *
 *
 *
 * @method     ChildPackageStepQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPackageStepQuery orderByPackageId($order = Criteria::ASC) Order by the package_id column
 * @method     ChildPackageStepQuery orderBySequenceId($order = Criteria::ASC) Order by the sequence_id column
 * @method     ChildPackageStepQuery orderByVersionId($order = Criteria::ASC) Order by the version_id column
 * @method     ChildPackageStepQuery orderByStepType($order = Criteria::ASC) Order by the step_type column
 * @method     ChildPackageStepQuery orderByRelatedPackageId($order = Criteria::ASC) Order by the related_package_id column
 *
 * @method     ChildPackageStepQuery groupById() Group by the id column
 * @method     ChildPackageStepQuery groupByPackageId() Group by the package_id column
 * @method     ChildPackageStepQuery groupBySequenceId() Group by the sequence_id column
 * @method     ChildPackageStepQuery groupByVersionId() Group by the version_id column
 * @method     ChildPackageStepQuery groupByStepType() Group by the step_type column
 * @method     ChildPackageStepQuery groupByRelatedPackageId() Group by the related_package_id column
 *
 * @method     ChildPackageStepQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPackageStepQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPackageStepQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPackageStepQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPackageStepQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPackageStepQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPackageStep findOne(ConnectionInterface $con = null) Return the first ChildPackageStep matching the query
 * @method     ChildPackageStep findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPackageStep matching the query, or a new ChildPackageStep object populated from the query conditions when no match is found
 *
 * @method     ChildPackageStep findOneById(int $id) Return the first ChildPackageStep filtered by the id column
 * @method     ChildPackageStep findOneByPackageId(int $package_id) Return the first ChildPackageStep filtered by the package_id column
 * @method     ChildPackageStep findOneBySequenceId(int $sequence_id) Return the first ChildPackageStep filtered by the sequence_id column
 * @method     ChildPackageStep findOneByVersionId(int $version_id) Return the first ChildPackageStep filtered by the version_id column
 * @method     ChildPackageStep findOneByStepType(string $step_type) Return the first ChildPackageStep filtered by the step_type column
 * @method     ChildPackageStep findOneByRelatedPackageId(int $related_package_id) Return the first ChildPackageStep filtered by the related_package_id column *

 * @method     ChildPackageStep requirePk($key, ConnectionInterface $con = null) Return the ChildPackageStep by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStep requireOne(ConnectionInterface $con = null) Return the first ChildPackageStep matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageStep requireOneById(int $id) Return the first ChildPackageStep filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStep requireOneByPackageId(int $package_id) Return the first ChildPackageStep filtered by the package_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStep requireOneBySequenceId(int $sequence_id) Return the first ChildPackageStep filtered by the sequence_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStep requireOneByVersionId(int $version_id) Return the first ChildPackageStep filtered by the version_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStep requireOneByStepType(string $step_type) Return the first ChildPackageStep filtered by the step_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStep requireOneByRelatedPackageId(int $related_package_id) Return the first ChildPackageStep filtered by the related_package_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageStep[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPackageStep objects based on current ModelCriteria
 * @method     ChildPackageStep[]|ObjectCollection findById(int $id) Return ChildPackageStep objects filtered by the id column
 * @method     ChildPackageStep[]|ObjectCollection findByPackageId(int $package_id) Return ChildPackageStep objects filtered by the package_id column
 * @method     ChildPackageStep[]|ObjectCollection findBySequenceId(int $sequence_id) Return ChildPackageStep objects filtered by the sequence_id column
 * @method     ChildPackageStep[]|ObjectCollection findByVersionId(int $version_id) Return ChildPackageStep objects filtered by the version_id column
 * @method     ChildPackageStep[]|ObjectCollection findByStepType(string $step_type) Return ChildPackageStep objects filtered by the step_type column
 * @method     ChildPackageStep[]|ObjectCollection findByRelatedPackageId(int $related_package_id) Return ChildPackageStep objects filtered by the related_package_id column
 * @method     ChildPackageStep[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PackageStepQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\PackageStepQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\PackageStep', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPackageStepQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPackageStepQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPackageStepQuery) {
            return $criteria;
        }
        $query = new ChildPackageStepQuery();
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
     * @return ChildPackageStep|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageStepTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PackageStepTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPackageStep A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, package_id, sequence_id, version_id, step_type, related_package_id FROM package_step WHERE id = :p0';
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
            /** @var ChildPackageStep $obj */
            $obj = new ChildPackageStep();
            $obj->hydrate($row);
            PackageStepTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPackageStep|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PackageStepTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PackageStepTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterByPackageId($packageId = null, $comparison = null)
    {
        if (is_array($packageId)) {
            $useMinMax = false;
            if (isset($packageId['min'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_PACKAGE_ID, $packageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageId['max'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_PACKAGE_ID, $packageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepTableMap::COL_PACKAGE_ID, $packageId, $comparison);
    }

    /**
     * Filter the query on the sequence_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySequenceId(1234); // WHERE sequence_id = 1234
     * $query->filterBySequenceId(array(12, 34)); // WHERE sequence_id IN (12, 34)
     * $query->filterBySequenceId(array('min' => 12)); // WHERE sequence_id > 12
     * </code>
     *
     * @param     mixed $sequenceId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterBySequenceId($sequenceId = null, $comparison = null)
    {
        if (is_array($sequenceId)) {
            $useMinMax = false;
            if (isset($sequenceId['min'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_SEQUENCE_ID, $sequenceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sequenceId['max'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_SEQUENCE_ID, $sequenceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepTableMap::COL_SEQUENCE_ID, $sequenceId, $comparison);
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
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterByVersionId($versionId = null, $comparison = null)
    {
        if (is_array($versionId)) {
            $useMinMax = false;
            if (isset($versionId['min'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_VERSION_ID, $versionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionId['max'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_VERSION_ID, $versionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepTableMap::COL_VERSION_ID, $versionId, $comparison);
    }

    /**
     * Filter the query on the step_type column
     *
     * Example usage:
     * <code>
     * $query->filterByStepType('fooValue');   // WHERE step_type = 'fooValue'
     * $query->filterByStepType('%fooValue%'); // WHERE step_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $stepType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterByStepType($stepType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($stepType)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepTableMap::COL_STEP_TYPE, $stepType, $comparison);
    }

    /**
     * Filter the query on the related_package_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRelatedPackageId(1234); // WHERE related_package_id = 1234
     * $query->filterByRelatedPackageId(array(12, 34)); // WHERE related_package_id IN (12, 34)
     * $query->filterByRelatedPackageId(array('min' => 12)); // WHERE related_package_id > 12
     * </code>
     *
     * @param     mixed $relatedPackageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function filterByRelatedPackageId($relatedPackageId = null, $comparison = null)
    {
        if (is_array($relatedPackageId)) {
            $useMinMax = false;
            if (isset($relatedPackageId['min'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_RELATED_PACKAGE_ID, $relatedPackageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($relatedPackageId['max'])) {
                $this->addUsingAlias(PackageStepTableMap::COL_RELATED_PACKAGE_ID, $relatedPackageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepTableMap::COL_RELATED_PACKAGE_ID, $relatedPackageId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPackageStep $packageStep Object to remove from the list of results
     *
     * @return $this|ChildPackageStepQuery The current query, for fluid interface
     */
    public function prune($packageStep = null)
    {
        if ($packageStep) {
            $this->addUsingAlias(PackageStepTableMap::COL_ID, $packageStep->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the package_step table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PackageStepTableMap::clearInstancePool();
            PackageStepTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PackageStepTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PackageStepTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PackageStepTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PackageStepQuery
