<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\PackageDependancyVersion as ChildPackageDependancyVersion;
use Packagerator\Model\PackageDependancyVersionQuery as ChildPackageDependancyVersionQuery;
use Packagerator\Model\Map\PackageDependancyVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'package_dependancy_version' table.
 *
 *
 *
 * @method     ChildPackageDependancyVersionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPackageDependancyVersionQuery orderByPackageId($order = Criteria::ASC) Order by the package_id column
 * @method     ChildPackageDependancyVersionQuery orderByRequiredPackageId($order = Criteria::ASC) Order by the required_package_id column
 * @method     ChildPackageDependancyVersionQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method     ChildPackageDependancyVersionQuery orderByPackageIdVersion($order = Criteria::ASC) Order by the package_id_version column
 * @method     ChildPackageDependancyVersionQuery orderByRequiredPackageIdVersion($order = Criteria::ASC) Order by the required_package_id_version column
 *
 * @method     ChildPackageDependancyVersionQuery groupById() Group by the id column
 * @method     ChildPackageDependancyVersionQuery groupByPackageId() Group by the package_id column
 * @method     ChildPackageDependancyVersionQuery groupByRequiredPackageId() Group by the required_package_id column
 * @method     ChildPackageDependancyVersionQuery groupByVersion() Group by the version column
 * @method     ChildPackageDependancyVersionQuery groupByPackageIdVersion() Group by the package_id_version column
 * @method     ChildPackageDependancyVersionQuery groupByRequiredPackageIdVersion() Group by the required_package_id_version column
 *
 * @method     ChildPackageDependancyVersionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPackageDependancyVersionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPackageDependancyVersionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPackageDependancyVersionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPackageDependancyVersionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPackageDependancyVersionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPackageDependancyVersionQuery leftJoinPackageDependancy($relationAlias = null) Adds a LEFT JOIN clause to the query using the PackageDependancy relation
 * @method     ChildPackageDependancyVersionQuery rightJoinPackageDependancy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PackageDependancy relation
 * @method     ChildPackageDependancyVersionQuery innerJoinPackageDependancy($relationAlias = null) Adds a INNER JOIN clause to the query using the PackageDependancy relation
 *
 * @method     ChildPackageDependancyVersionQuery joinWithPackageDependancy($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PackageDependancy relation
 *
 * @method     ChildPackageDependancyVersionQuery leftJoinWithPackageDependancy() Adds a LEFT JOIN clause and with to the query using the PackageDependancy relation
 * @method     ChildPackageDependancyVersionQuery rightJoinWithPackageDependancy() Adds a RIGHT JOIN clause and with to the query using the PackageDependancy relation
 * @method     ChildPackageDependancyVersionQuery innerJoinWithPackageDependancy() Adds a INNER JOIN clause and with to the query using the PackageDependancy relation
 *
 * @method     \Packagerator\Model\PackageDependancyQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPackageDependancyVersion findOne(ConnectionInterface $con = null) Return the first ChildPackageDependancyVersion matching the query
 * @method     ChildPackageDependancyVersion findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPackageDependancyVersion matching the query, or a new ChildPackageDependancyVersion object populated from the query conditions when no match is found
 *
 * @method     ChildPackageDependancyVersion findOneById(int $id) Return the first ChildPackageDependancyVersion filtered by the id column
 * @method     ChildPackageDependancyVersion findOneByPackageId(int $package_id) Return the first ChildPackageDependancyVersion filtered by the package_id column
 * @method     ChildPackageDependancyVersion findOneByRequiredPackageId(int $required_package_id) Return the first ChildPackageDependancyVersion filtered by the required_package_id column
 * @method     ChildPackageDependancyVersion findOneByVersion(int $version) Return the first ChildPackageDependancyVersion filtered by the version column
 * @method     ChildPackageDependancyVersion findOneByPackageIdVersion(int $package_id_version) Return the first ChildPackageDependancyVersion filtered by the package_id_version column
 * @method     ChildPackageDependancyVersion findOneByRequiredPackageIdVersion(int $required_package_id_version) Return the first ChildPackageDependancyVersion filtered by the required_package_id_version column *

 * @method     ChildPackageDependancyVersion requirePk($key, ConnectionInterface $con = null) Return the ChildPackageDependancyVersion by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyVersion requireOne(ConnectionInterface $con = null) Return the first ChildPackageDependancyVersion matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageDependancyVersion requireOneById(int $id) Return the first ChildPackageDependancyVersion filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyVersion requireOneByPackageId(int $package_id) Return the first ChildPackageDependancyVersion filtered by the package_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyVersion requireOneByRequiredPackageId(int $required_package_id) Return the first ChildPackageDependancyVersion filtered by the required_package_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyVersion requireOneByVersion(int $version) Return the first ChildPackageDependancyVersion filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyVersion requireOneByPackageIdVersion(int $package_id_version) Return the first ChildPackageDependancyVersion filtered by the package_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackageDependancyVersion requireOneByRequiredPackageIdVersion(int $required_package_id_version) Return the first ChildPackageDependancyVersion filtered by the required_package_id_version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackageDependancyVersion[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPackageDependancyVersion objects based on current ModelCriteria
 * @method     ChildPackageDependancyVersion[]|ObjectCollection findById(int $id) Return ChildPackageDependancyVersion objects filtered by the id column
 * @method     ChildPackageDependancyVersion[]|ObjectCollection findByPackageId(int $package_id) Return ChildPackageDependancyVersion objects filtered by the package_id column
 * @method     ChildPackageDependancyVersion[]|ObjectCollection findByRequiredPackageId(int $required_package_id) Return ChildPackageDependancyVersion objects filtered by the required_package_id column
 * @method     ChildPackageDependancyVersion[]|ObjectCollection findByVersion(int $version) Return ChildPackageDependancyVersion objects filtered by the version column
 * @method     ChildPackageDependancyVersion[]|ObjectCollection findByPackageIdVersion(int $package_id_version) Return ChildPackageDependancyVersion objects filtered by the package_id_version column
 * @method     ChildPackageDependancyVersion[]|ObjectCollection findByRequiredPackageIdVersion(int $required_package_id_version) Return ChildPackageDependancyVersion objects filtered by the required_package_id_version column
 * @method     ChildPackageDependancyVersion[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PackageDependancyVersionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\PackageDependancyVersionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\PackageDependancyVersion', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPackageDependancyVersionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPackageDependancyVersionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPackageDependancyVersionQuery) {
            return $criteria;
        }
        $query = new ChildPackageDependancyVersionQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$id, $version] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPackageDependancyVersion|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageDependancyVersionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PackageDependancyVersionTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildPackageDependancyVersion A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, package_id, required_package_id, version, package_id_version, required_package_id_version FROM package_dependancy_version WHERE id = :p0 AND version = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPackageDependancyVersion $obj */
            $obj = new ChildPackageDependancyVersion();
            $obj->hydrate($row);
            PackageDependancyVersionTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildPackageDependancyVersion|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PackageDependancyVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PackageDependancyVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PackageDependancyVersionTableMap::COL_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PackageDependancyVersionTableMap::COL_VERSION, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterByPackageDependancy()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyVersionTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByPackageId($packageId = null, $comparison = null)
    {
        if (is_array($packageId)) {
            $useMinMax = false;
            if (isset($packageId['min'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_PACKAGE_ID, $packageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageId['max'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_PACKAGE_ID, $packageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyVersionTableMap::COL_PACKAGE_ID, $packageId, $comparison);
    }

    /**
     * Filter the query on the required_package_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredPackageId(1234); // WHERE required_package_id = 1234
     * $query->filterByRequiredPackageId(array(12, 34)); // WHERE required_package_id IN (12, 34)
     * $query->filterByRequiredPackageId(array('min' => 12)); // WHERE required_package_id > 12
     * </code>
     *
     * @param     mixed $requiredPackageId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByRequiredPackageId($requiredPackageId = null, $comparison = null)
    {
        if (is_array($requiredPackageId)) {
            $useMinMax = false;
            if (isset($requiredPackageId['min'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_REQUIRED_PACKAGE_ID, $requiredPackageId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredPackageId['max'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_REQUIRED_PACKAGE_ID, $requiredPackageId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyVersionTableMap::COL_REQUIRED_PACKAGE_ID, $requiredPackageId, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion(1234); // WHERE version = 1234
     * $query->filterByVersion(array(12, 34)); // WHERE version IN (12, 34)
     * $query->filterByVersion(array('min' => 12)); // WHERE version > 12
     * </code>
     *
     * @param     mixed $version The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyVersionTableMap::COL_VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the package_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByPackageIdVersion(1234); // WHERE package_id_version = 1234
     * $query->filterByPackageIdVersion(array(12, 34)); // WHERE package_id_version IN (12, 34)
     * $query->filterByPackageIdVersion(array('min' => 12)); // WHERE package_id_version > 12
     * </code>
     *
     * @param     mixed $packageIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByPackageIdVersion($packageIdVersion = null, $comparison = null)
    {
        if (is_array($packageIdVersion)) {
            $useMinMax = false;
            if (isset($packageIdVersion['min'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_PACKAGE_ID_VERSION, $packageIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($packageIdVersion['max'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_PACKAGE_ID_VERSION, $packageIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyVersionTableMap::COL_PACKAGE_ID_VERSION, $packageIdVersion, $comparison);
    }

    /**
     * Filter the query on the required_package_id_version column
     *
     * Example usage:
     * <code>
     * $query->filterByRequiredPackageIdVersion(1234); // WHERE required_package_id_version = 1234
     * $query->filterByRequiredPackageIdVersion(array(12, 34)); // WHERE required_package_id_version IN (12, 34)
     * $query->filterByRequiredPackageIdVersion(array('min' => 12)); // WHERE required_package_id_version > 12
     * </code>
     *
     * @param     mixed $requiredPackageIdVersion The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByRequiredPackageIdVersion($requiredPackageIdVersion = null, $comparison = null)
    {
        if (is_array($requiredPackageIdVersion)) {
            $useMinMax = false;
            if (isset($requiredPackageIdVersion['min'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_REQUIRED_PACKAGE_ID_VERSION, $requiredPackageIdVersion['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($requiredPackageIdVersion['max'])) {
                $this->addUsingAlias(PackageDependancyVersionTableMap::COL_REQUIRED_PACKAGE_ID_VERSION, $requiredPackageIdVersion['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageDependancyVersionTableMap::COL_REQUIRED_PACKAGE_ID_VERSION, $requiredPackageIdVersion, $comparison);
    }

    /**
     * Filter the query by a related \Packagerator\Model\PackageDependancy object
     *
     * @param \Packagerator\Model\PackageDependancy|ObjectCollection $packageDependancy The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function filterByPackageDependancy($packageDependancy, $comparison = null)
    {
        if ($packageDependancy instanceof \Packagerator\Model\PackageDependancy) {
            return $this
                ->addUsingAlias(PackageDependancyVersionTableMap::COL_ID, $packageDependancy->getId(), $comparison);
        } elseif ($packageDependancy instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PackageDependancyVersionTableMap::COL_ID, $packageDependancy->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPackageDependancy() only accepts arguments of type \Packagerator\Model\PackageDependancy or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PackageDependancy relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function joinPackageDependancy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PackageDependancy');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PackageDependancy');
        }

        return $this;
    }

    /**
     * Use the PackageDependancy relation PackageDependancy object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Packagerator\Model\PackageDependancyQuery A secondary query class using the current class as primary query
     */
    public function usePackageDependancyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPackageDependancy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PackageDependancy', '\Packagerator\Model\PackageDependancyQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPackageDependancyVersion $packageDependancyVersion Object to remove from the list of results
     *
     * @return $this|ChildPackageDependancyVersionQuery The current query, for fluid interface
     */
    public function prune($packageDependancyVersion = null)
    {
        if ($packageDependancyVersion) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PackageDependancyVersionTableMap::COL_ID), $packageDependancyVersion->getId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PackageDependancyVersionTableMap::COL_VERSION), $packageDependancyVersion->getVersion(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the package_dependancy_version table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyVersionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PackageDependancyVersionTableMap::clearInstancePool();
            PackageDependancyVersionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyVersionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PackageDependancyVersionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PackageDependancyVersionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PackageDependancyVersionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PackageDependancyVersionQuery
