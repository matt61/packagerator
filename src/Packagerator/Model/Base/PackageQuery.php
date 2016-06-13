<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\Package as ChildPackage;
use Packagerator\Model\PackageQuery as ChildPackageQuery;
use Packagerator\Model\Map\PackageTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'package' table.
 *
 *
 *
 * @method     ChildPackageQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPackageQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPackageQuery orderByVersion($order = Criteria::ASC) Order by the version column
 *
 * @method     ChildPackageQuery groupById() Group by the id column
 * @method     ChildPackageQuery groupByName() Group by the name column
 * @method     ChildPackageQuery groupByVersion() Group by the version column
 *
 * @method     ChildPackageQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPackageQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPackageQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPackageQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPackageQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPackageQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPackageQuery leftJoinPackageDependancyRelatedByPackageId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PackageDependancyRelatedByPackageId relation
 * @method     ChildPackageQuery rightJoinPackageDependancyRelatedByPackageId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PackageDependancyRelatedByPackageId relation
 * @method     ChildPackageQuery innerJoinPackageDependancyRelatedByPackageId($relationAlias = null) Adds a INNER JOIN clause to the query using the PackageDependancyRelatedByPackageId relation
 *
 * @method     ChildPackageQuery joinWithPackageDependancyRelatedByPackageId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PackageDependancyRelatedByPackageId relation
 *
 * @method     ChildPackageQuery leftJoinWithPackageDependancyRelatedByPackageId() Adds a LEFT JOIN clause and with to the query using the PackageDependancyRelatedByPackageId relation
 * @method     ChildPackageQuery rightJoinWithPackageDependancyRelatedByPackageId() Adds a RIGHT JOIN clause and with to the query using the PackageDependancyRelatedByPackageId relation
 * @method     ChildPackageQuery innerJoinWithPackageDependancyRelatedByPackageId() Adds a INNER JOIN clause and with to the query using the PackageDependancyRelatedByPackageId relation
 *
 * @method     ChildPackageQuery leftJoinPackageDependancyRelatedByRequiredPackageId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PackageDependancyRelatedByRequiredPackageId relation
 * @method     ChildPackageQuery rightJoinPackageDependancyRelatedByRequiredPackageId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PackageDependancyRelatedByRequiredPackageId relation
 * @method     ChildPackageQuery innerJoinPackageDependancyRelatedByRequiredPackageId($relationAlias = null) Adds a INNER JOIN clause to the query using the PackageDependancyRelatedByRequiredPackageId relation
 *
 * @method     ChildPackageQuery joinWithPackageDependancyRelatedByRequiredPackageId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PackageDependancyRelatedByRequiredPackageId relation
 *
 * @method     ChildPackageQuery leftJoinWithPackageDependancyRelatedByRequiredPackageId() Adds a LEFT JOIN clause and with to the query using the PackageDependancyRelatedByRequiredPackageId relation
 * @method     ChildPackageQuery rightJoinWithPackageDependancyRelatedByRequiredPackageId() Adds a RIGHT JOIN clause and with to the query using the PackageDependancyRelatedByRequiredPackageId relation
 * @method     ChildPackageQuery innerJoinWithPackageDependancyRelatedByRequiredPackageId() Adds a INNER JOIN clause and with to the query using the PackageDependancyRelatedByRequiredPackageId relation
 *
 * @method     ChildPackageQuery leftJoinPackageVersion($relationAlias = null) Adds a LEFT JOIN clause to the query using the PackageVersion relation
 * @method     ChildPackageQuery rightJoinPackageVersion($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PackageVersion relation
 * @method     ChildPackageQuery innerJoinPackageVersion($relationAlias = null) Adds a INNER JOIN clause to the query using the PackageVersion relation
 *
 * @method     ChildPackageQuery joinWithPackageVersion($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PackageVersion relation
 *
 * @method     ChildPackageQuery leftJoinWithPackageVersion() Adds a LEFT JOIN clause and with to the query using the PackageVersion relation
 * @method     ChildPackageQuery rightJoinWithPackageVersion() Adds a RIGHT JOIN clause and with to the query using the PackageVersion relation
 * @method     ChildPackageQuery innerJoinWithPackageVersion() Adds a INNER JOIN clause and with to the query using the PackageVersion relation
 *
 * @method     \Packagerator\Model\PackageDependancyQuery|\Packagerator\Model\PackageVersionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPackage findOne(ConnectionInterface $con = null) Return the first ChildPackage matching the query
 * @method     ChildPackage findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPackage matching the query, or a new ChildPackage object populated from the query conditions when no match is found
 *
 * @method     ChildPackage findOneById(int $id) Return the first ChildPackage filtered by the id column
 * @method     ChildPackage findOneByName(string $name) Return the first ChildPackage filtered by the name column
 * @method     ChildPackage findOneByVersion(int $version) Return the first ChildPackage filtered by the version column *

 * @method     ChildPackage requirePk($key, ConnectionInterface $con = null) Return the ChildPackage by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackage requireOne(ConnectionInterface $con = null) Return the first ChildPackage matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackage requireOneById(int $id) Return the first ChildPackage filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackage requireOneByName(string $name) Return the first ChildPackage filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPackage requireOneByVersion(int $version) Return the first ChildPackage filtered by the version column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPackage[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPackage objects based on current ModelCriteria
 * @method     ChildPackage[]|ObjectCollection findById(int $id) Return ChildPackage objects filtered by the id column
 * @method     ChildPackage[]|ObjectCollection findByName(string $name) Return ChildPackage objects filtered by the name column
 * @method     ChildPackage[]|ObjectCollection findByVersion(int $version) Return ChildPackage objects filtered by the version column
 * @method     ChildPackage[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PackageQuery extends ModelCriteria
{

    // versionable behavior

    /**
     * Whether the versioning is enabled
     */
    static $isVersioningEnabled = true;
protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\PackageQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\Package', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPackageQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPackageQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPackageQuery) {
            return $criteria;
        }
        $query = new ChildPackageQuery();
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
     * @return ChildPackage|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PackageTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPackage A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, name, version FROM package WHERE id = :p0';
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
            /** @var ChildPackage $obj */
            $obj = new ChildPackage();
            $obj->hydrate($row);
            PackageTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPackage|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PackageTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PackageTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PackageTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PackageTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (is_array($version)) {
            $useMinMax = false;
            if (isset($version['min'])) {
                $this->addUsingAlias(PackageTableMap::COL_VERSION, $version['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($version['max'])) {
                $this->addUsingAlias(PackageTableMap::COL_VERSION, $version['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PackageTableMap::COL_VERSION, $version, $comparison);
    }

    /**
     * Filter the query by a related \Packagerator\Model\PackageDependancy object
     *
     * @param \Packagerator\Model\PackageDependancy|ObjectCollection $packageDependancy the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPackageQuery The current query, for fluid interface
     */
    public function filterByPackageDependancyRelatedByPackageId($packageDependancy, $comparison = null)
    {
        if ($packageDependancy instanceof \Packagerator\Model\PackageDependancy) {
            return $this
                ->addUsingAlias(PackageTableMap::COL_ID, $packageDependancy->getPackageId(), $comparison);
        } elseif ($packageDependancy instanceof ObjectCollection) {
            return $this
                ->usePackageDependancyRelatedByPackageIdQuery()
                ->filterByPrimaryKeys($packageDependancy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPackageDependancyRelatedByPackageId() only accepts arguments of type \Packagerator\Model\PackageDependancy or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PackageDependancyRelatedByPackageId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function joinPackageDependancyRelatedByPackageId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PackageDependancyRelatedByPackageId');

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
            $this->addJoinObject($join, 'PackageDependancyRelatedByPackageId');
        }

        return $this;
    }

    /**
     * Use the PackageDependancyRelatedByPackageId relation PackageDependancy object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Packagerator\Model\PackageDependancyQuery A secondary query class using the current class as primary query
     */
    public function usePackageDependancyRelatedByPackageIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPackageDependancyRelatedByPackageId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PackageDependancyRelatedByPackageId', '\Packagerator\Model\PackageDependancyQuery');
    }

    /**
     * Filter the query by a related \Packagerator\Model\PackageDependancy object
     *
     * @param \Packagerator\Model\PackageDependancy|ObjectCollection $packageDependancy the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPackageQuery The current query, for fluid interface
     */
    public function filterByPackageDependancyRelatedByRequiredPackageId($packageDependancy, $comparison = null)
    {
        if ($packageDependancy instanceof \Packagerator\Model\PackageDependancy) {
            return $this
                ->addUsingAlias(PackageTableMap::COL_ID, $packageDependancy->getRequiredPackageId(), $comparison);
        } elseif ($packageDependancy instanceof ObjectCollection) {
            return $this
                ->usePackageDependancyRelatedByRequiredPackageIdQuery()
                ->filterByPrimaryKeys($packageDependancy->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPackageDependancyRelatedByRequiredPackageId() only accepts arguments of type \Packagerator\Model\PackageDependancy or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PackageDependancyRelatedByRequiredPackageId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function joinPackageDependancyRelatedByRequiredPackageId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PackageDependancyRelatedByRequiredPackageId');

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
            $this->addJoinObject($join, 'PackageDependancyRelatedByRequiredPackageId');
        }

        return $this;
    }

    /**
     * Use the PackageDependancyRelatedByRequiredPackageId relation PackageDependancy object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Packagerator\Model\PackageDependancyQuery A secondary query class using the current class as primary query
     */
    public function usePackageDependancyRelatedByRequiredPackageIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPackageDependancyRelatedByRequiredPackageId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PackageDependancyRelatedByRequiredPackageId', '\Packagerator\Model\PackageDependancyQuery');
    }

    /**
     * Filter the query by a related \Packagerator\Model\PackageVersion object
     *
     * @param \Packagerator\Model\PackageVersion|ObjectCollection $packageVersion the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPackageQuery The current query, for fluid interface
     */
    public function filterByPackageVersion($packageVersion, $comparison = null)
    {
        if ($packageVersion instanceof \Packagerator\Model\PackageVersion) {
            return $this
                ->addUsingAlias(PackageTableMap::COL_ID, $packageVersion->getId(), $comparison);
        } elseif ($packageVersion instanceof ObjectCollection) {
            return $this
                ->usePackageVersionQuery()
                ->filterByPrimaryKeys($packageVersion->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPackageVersion() only accepts arguments of type \Packagerator\Model\PackageVersion or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PackageVersion relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function joinPackageVersion($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PackageVersion');

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
            $this->addJoinObject($join, 'PackageVersion');
        }

        return $this;
    }

    /**
     * Use the PackageVersion relation PackageVersion object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Packagerator\Model\PackageVersionQuery A secondary query class using the current class as primary query
     */
    public function usePackageVersionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPackageVersion($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PackageVersion', '\Packagerator\Model\PackageVersionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPackage $package Object to remove from the list of results
     *
     * @return $this|ChildPackageQuery The current query, for fluid interface
     */
    public function prune($package = null)
    {
        if ($package) {
            $this->addUsingAlias(PackageTableMap::COL_ID, $package->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the package table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PackageTableMap::clearInstancePool();
            PackageTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PackageTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PackageTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PackageTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    // versionable behavior

    /**
     * Checks whether versioning is enabled
     *
     * @return boolean
     */
    static public function isVersioningEnabled()
    {
        return self::$isVersioningEnabled;
    }

    /**
     * Enables versioning
     */
    static public function enableVersioning()
    {
        self::$isVersioningEnabled = true;
    }

    /**
     * Disables versioning
     */
    static public function disableVersioning()
    {
        self::$isVersioningEnabled = false;
    }

} // PackageQuery
