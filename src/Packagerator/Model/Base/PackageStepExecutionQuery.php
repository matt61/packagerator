<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\PackageStepExecution as ChildPackageStepExecution;
use Packagerator\Model\PackageStepExecutionQuery as ChildPackageStepExecutionQuery;
use Packagerator\Model\Map\PackageStepExecutionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'package_step_execution' table.
 *
 *
 *
 * @method     ChildPackageStepExecutionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPackageStepExecutionQuery orderByPackageStepId($order = Criteria::ASC) Order by the package_step_id column
 * @method     ChildPackageStepExecutionQuery orderByVersionId($order = Criteria::ASC) Order by the version_id column
 * @method     ChildPackageStepExecutionQuery orderBySequenceId($order = Criteria::ASC) Order by the sequence_id column
 * @method     ChildPackageStepExecutionQuery orderByInput($order = Criteria::ASC) Order by the input column
 * @method     ChildPackageStepExecutionQuery orderByOutputCode($order = Criteria::ASC) Order by the output_code column
 * @method     ChildPackageStepExecutionQuery orderByOutputPattern($order = Criteria::ASC) Order by the output_pattern column
 *
 * @method     ChildPackageStepExecutionQuery groupById() Group by the id column
 * @method     ChildPackageStepExecutionQuery groupByPackageStepId() Group by the package_step_id column
 * @method     ChildPackageStepExecutionQuery groupByVersionId() Group by the version_id column
 * @method     ChildPackageStepExecutionQuery groupBySequenceId() Group by the sequence_id column
 * @method     ChildPackageStepExecutionQuery groupByInput() Group by the input column
 * @method     ChildPackageStepExecutionQuery groupByOutputCode() Group by the output_code column
 * @method     ChildPackageStepExecutionQuery groupByOutputPattern() Group by the output_pattern column
 *
 * @method     ChildPackageStepExecutionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPackageStepExecutionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPackageStepExecutionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPackageStepExecutionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPackageStepExecutionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPackageStepExecutionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPackageStepExecution findOne(ConnectionInterface $con = null) Return the first ChildPackageStepExecution matching the query
 * @method     ChildPackageStepExecution findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPackageStepExecution matching the query, or a new ChildPackageStepExecution object populated from the query conditions when no match is found
 *
 * @method     ChildPackageStepExecution findOneById(int $id) Return the first ChildPackageStepExecution filtered by the id column
 * @method     ChildPackageStepExecution findOneByPackageStepId(int $package_step_id) Return the first ChildPackageStepExecution filtered by the package_step_id column
 * @method     ChildPackageStepExecution findOneByVersionId(int $version_id) Return the first ChildPackageStepExecution filtered by the version_id column
 * @method     ChildPackageStepExecution findOneBySequenceId(int $sequence_id) Return the first ChildPackageStepExecution filtered by the sequence_id column
 * @method     ChildPackageStepExecution findOneByInput(string $input) Return the first ChildPackageStepExecution filtered by the input column
 * @method     ChildPackageStepExecution findOneByOutputCode(int $output_code) Return the first ChildPackageStepExecution filtered by the output_code column
 * @method     ChildPackageStepExecution findOneByOutputPattern(string $output_pattern) Return the first ChildPackageStepExecution filtered by the output_pattern column *

 * @method     ChildPackageStepExecution requirePk($key, ConnectionInterface $con = null) Return the ChildPackageStepExecution by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOne(ConnectionInterface $con = null) Return the first ChildPackageStepExecution matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageStepExecution requireOneById(int $id) Return the first ChildPackageStepExecution filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOneByPackageStepId(int $package_step_id) Return the first ChildPackageStepExecution filtered by the package_step_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOneByVersionId(int $version_id) Return the first ChildPackageStepExecution filtered by the version_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOneBySequenceId(int $sequence_id) Return the first ChildPackageStepExecution filtered by the sequence_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOneByInput(string $input) Return the first ChildPackageStepExecution filtered by the input column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOneByOutputCode(int $output_code) Return the first ChildPackageStepExecution filtered by the output_code column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageStepExecution requireOneByOutputPattern(string $output_pattern) Return the first ChildPackageStepExecution filtered by the output_pattern column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageStepExecution[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPackageStepExecution objects based on current ModelCriteria
 * @method     ChildPackageStepExecution[]|ObjectCollection findById(int $id) Return ChildPackageStepExecution objects filtered by the id column
 * @method     ChildPackageStepExecution[]|ObjectCollection findByPackageStepId(int $package_step_id) Return ChildPackageStepExecution objects filtered by the package_step_id column
 * @method     ChildPackageStepExecution[]|ObjectCollection findByVersionId(int $version_id) Return ChildPackageStepExecution objects filtered by the version_id column
 * @method     ChildPackageStepExecution[]|ObjectCollection findBySequenceId(int $sequence_id) Return ChildPackageStepExecution objects filtered by the sequence_id column
 * @method     ChildPackageStepExecution[]|ObjectCollection findByInput(string $input) Return ChildPackageStepExecution objects filtered by the input column
 * @method     ChildPackageStepExecution[]|ObjectCollection findByOutputCode(int $output_code) Return ChildPackageStepExecution objects filtered by the output_code column
 * @method     ChildPackageStepExecution[]|ObjectCollection findByOutputPattern(string $output_pattern) Return ChildPackageStepExecution objects filtered by the output_pattern column
 * @method     ChildPackageStepExecution[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PackageStepExecutionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\PackageStepExecutionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\PackageStepExecution', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPackageStepExecutionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPackageStepExecutionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPackageStepExecutionQuery) {
            return $criteria;
        }
        $query = new ChildPackageStepExecutionQuery();
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
     * @return ChildPackageStepExecution|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageStepExecutionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PackageStepExecutionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPackageStepExecution A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, package_step_id, version_id, sequence_id, input, output_code, output_pattern FROM package_step_execution WHERE id = :p0';
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
            /** @var ChildPackageStepExecution $obj */
            $obj = new ChildPackageStepExecution();
            $obj->hydrate($row);
            PackageStepExecutionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPackageStepExecution|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the package_step_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPackageStepId(1234); // WHERE package_step_id = 1234
     * $query->filterByPackageStepId(array(12, 34)); // WHERE package_step_id IN (12, 34)
     * $query->filterByPackageStepId(array('min' => 12)); // WHERE package_step_id > 12
     * </code>
     *
     * @param     mixed $packageStepId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByPackageStepId($packageStepId = null, $comparison = null)
    {
        if (is_array($packageStepId)) {
            $useMinMax = false;
            if (isset($packageStepId['min'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_PACKAGE_STEP_ID, $packageStepId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageStepId['max'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_PACKAGE_STEP_ID, $packageStepId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_PACKAGE_STEP_ID, $packageStepId, $comparison);
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
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByVersionId($versionId = null, $comparison = null)
    {
        if (is_array($versionId)) {
            $useMinMax = false;
            if (isset($versionId['min'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_VERSION_ID, $versionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($versionId['max'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_VERSION_ID, $versionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_VERSION_ID, $versionId, $comparison);
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
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterBySequenceId($sequenceId = null, $comparison = null)
    {
        if (is_array($sequenceId)) {
            $useMinMax = false;
            if (isset($sequenceId['min'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_SEQUENCE_ID, $sequenceId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sequenceId['max'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_SEQUENCE_ID, $sequenceId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_SEQUENCE_ID, $sequenceId, $comparison);
    }

    /**
     * Filter the query on the input column
     *
     * Example usage:
     * <code>
     * $query->filterByInput('fooValue');   // WHERE input = 'fooValue'
     * $query->filterByInput('%fooValue%'); // WHERE input LIKE '%fooValue%'
     * </code>
     *
     * @param     string $input The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByInput($input = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($input)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_INPUT, $input, $comparison);
    }

    /**
     * Filter the query on the output_code column
     *
     * Example usage:
     * <code>
     * $query->filterByOutputCode(1234); // WHERE output_code = 1234
     * $query->filterByOutputCode(array(12, 34)); // WHERE output_code IN (12, 34)
     * $query->filterByOutputCode(array('min' => 12)); // WHERE output_code > 12
     * </code>
     *
     * @param     mixed $outputCode The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByOutputCode($outputCode = null, $comparison = null)
    {
        if (is_array($outputCode)) {
            $useMinMax = false;
            if (isset($outputCode['min'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_OUTPUT_CODE, $outputCode['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($outputCode['max'])) {
                $this->addUsingAlias(PackageStepExecutionTableMap::COL_OUTPUT_CODE, $outputCode['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_OUTPUT_CODE, $outputCode, $comparison);
    }

    /**
     * Filter the query on the output_pattern column
     *
     * Example usage:
     * <code>
     * $query->filterByOutputPattern('fooValue');   // WHERE output_pattern = 'fooValue'
     * $query->filterByOutputPattern('%fooValue%'); // WHERE output_pattern LIKE '%fooValue%'
     * </code>
     *
     * @param     string $outputPattern The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function filterByOutputPattern($outputPattern = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($outputPattern)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageStepExecutionTableMap::COL_OUTPUT_PATTERN, $outputPattern, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPackageStepExecution $packageStepExecution Object to remove from the list of results
     *
     * @return $this|ChildPackageStepExecutionQuery The current query, for fluid interface
     */
    public function prune($packageStepExecution = null)
    {
        if ($packageStepExecution) {
            $this->addUsingAlias(PackageStepExecutionTableMap::COL_ID, $packageStepExecution->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the package_step_execution table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepExecutionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PackageStepExecutionTableMap::clearInstancePool();
            PackageStepExecutionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageStepExecutionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PackageStepExecutionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PackageStepExecutionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PackageStepExecutionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PackageStepExecutionQuery
