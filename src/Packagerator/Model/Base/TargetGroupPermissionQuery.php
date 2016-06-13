<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\TargetGroupPermission as ChildTargetGroupPermission;
use Packagerator\Model\TargetGroupPermissionQuery as ChildTargetGroupPermissionQuery;
use Packagerator\Model\Map\TargetGroupPermissionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'target_group_permission' table.
 *
 *
 *
 * @method     ChildTargetGroupPermissionQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildTargetGroupPermissionQuery orderByTargetGroupId($order = Criteria::ASC) Order by the target_group_id column
 * @method     ChildTargetGroupPermissionQuery orderByUserGroupId($order = Criteria::ASC) Order by the user_group_id column
 *
 * @method     ChildTargetGroupPermissionQuery groupById() Group by the id column
 * @method     ChildTargetGroupPermissionQuery groupByTargetGroupId() Group by the target_group_id column
 * @method     ChildTargetGroupPermissionQuery groupByUserGroupId() Group by the user_group_id column
 *
 * @method     ChildTargetGroupPermissionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTargetGroupPermissionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTargetGroupPermissionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTargetGroupPermissionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTargetGroupPermissionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTargetGroupPermissionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTargetGroupPermission findOne(ConnectionInterface $con = null) Return the first ChildTargetGroupPermission matching the query
 * @method     ChildTargetGroupPermission findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTargetGroupPermission matching the query, or a new ChildTargetGroupPermission object populated from the query conditions when no match is found
 *
 * @method     ChildTargetGroupPermission findOneById(int $id) Return the first ChildTargetGroupPermission filtered by the id column
 * @method     ChildTargetGroupPermission findOneByTargetGroupId(int $target_group_id) Return the first ChildTargetGroupPermission filtered by the target_group_id column
 * @method     ChildTargetGroupPermission findOneByUserGroupId(int $user_group_id) Return the first ChildTargetGroupPermission filtered by the user_group_id column *

 * @method     ChildTargetGroupPermission requirePk($key, ConnectionInterface $con = null) Return the ChildTargetGroupPermission by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTargetGroupPermission requireOne(ConnectionInterface $con = null) Return the first ChildTargetGroupPermission matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTargetGroupPermission requireOneById(int $id) Return the first ChildTargetGroupPermission filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTargetGroupPermission requireOneByTargetGroupId(int $target_group_id) Return the first ChildTargetGroupPermission filtered by the target_group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTargetGroupPermission requireOneByUserGroupId(int $user_group_id) Return the first ChildTargetGroupPermission filtered by the user_group_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTargetGroupPermission[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTargetGroupPermission objects based on current ModelCriteria
 * @method     ChildTargetGroupPermission[]|ObjectCollection findById(int $id) Return ChildTargetGroupPermission objects filtered by the id column
 * @method     ChildTargetGroupPermission[]|ObjectCollection findByTargetGroupId(int $target_group_id) Return ChildTargetGroupPermission objects filtered by the target_group_id column
 * @method     ChildTargetGroupPermission[]|ObjectCollection findByUserGroupId(int $user_group_id) Return ChildTargetGroupPermission objects filtered by the user_group_id column
 * @method     ChildTargetGroupPermission[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TargetGroupPermissionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Packagerator\Model\Base\TargetGroupPermissionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Packagerator\\Model\\TargetGroupPermission', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTargetGroupPermissionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTargetGroupPermissionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTargetGroupPermissionQuery) {
            return $criteria;
        }
        $query = new ChildTargetGroupPermissionQuery();
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
     * @return ChildTargetGroupPermission|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TargetGroupPermissionTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = TargetGroupPermissionTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildTargetGroupPermission A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, target_group_id, user_group_id FROM target_group_permission WHERE id = :p0';
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
            /** @var ChildTargetGroupPermission $obj */
            $obj = new ChildTargetGroupPermission();
            $obj->hydrate($row);
            TargetGroupPermissionTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildTargetGroupPermission|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTargetGroupPermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TargetGroupPermissionTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTargetGroupPermissionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TargetGroupPermissionTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildTargetGroupPermissionQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(TargetGroupPermissionTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(TargetGroupPermissionTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetGroupPermissionTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the target_group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTargetGroupId(1234); // WHERE target_group_id = 1234
     * $query->filterByTargetGroupId(array(12, 34)); // WHERE target_group_id IN (12, 34)
     * $query->filterByTargetGroupId(array('min' => 12)); // WHERE target_group_id > 12
     * </code>
     *
     * @param     mixed $targetGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTargetGroupPermissionQuery The current query, for fluid interface
     */
    public function filterByTargetGroupId($targetGroupId = null, $comparison = null)
    {
        if (is_array($targetGroupId)) {
            $useMinMax = false;
            if (isset($targetGroupId['min'])) {
                $this->addUsingAlias(TargetGroupPermissionTableMap::COL_TARGET_GROUP_ID, $targetGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($targetGroupId['max'])) {
                $this->addUsingAlias(TargetGroupPermissionTableMap::COL_TARGET_GROUP_ID, $targetGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetGroupPermissionTableMap::COL_TARGET_GROUP_ID, $targetGroupId, $comparison);
    }

    /**
     * Filter the query on the user_group_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUserGroupId(1234); // WHERE user_group_id = 1234
     * $query->filterByUserGroupId(array(12, 34)); // WHERE user_group_id IN (12, 34)
     * $query->filterByUserGroupId(array('min' => 12)); // WHERE user_group_id > 12
     * </code>
     *
     * @param     mixed $userGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTargetGroupPermissionQuery The current query, for fluid interface
     */
    public function filterByUserGroupId($userGroupId = null, $comparison = null)
    {
        if (is_array($userGroupId)) {
            $useMinMax = false;
            if (isset($userGroupId['min'])) {
                $this->addUsingAlias(TargetGroupPermissionTableMap::COL_USER_GROUP_ID, $userGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($userGroupId['max'])) {
                $this->addUsingAlias(TargetGroupPermissionTableMap::COL_USER_GROUP_ID, $userGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TargetGroupPermissionTableMap::COL_USER_GROUP_ID, $userGroupId, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTargetGroupPermission $targetGroupPermission Object to remove from the list of results
     *
     * @return $this|ChildTargetGroupPermissionQuery The current query, for fluid interface
     */
    public function prune($targetGroupPermission = null)
    {
        if ($targetGroupPermission) {
            $this->addUsingAlias(TargetGroupPermissionTableMap::COL_ID, $targetGroupPermission->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the target_group_permission table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TargetGroupPermissionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TargetGroupPermissionTableMap::clearInstancePool();
            TargetGroupPermissionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TargetGroupPermissionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TargetGroupPermissionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TargetGroupPermissionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TargetGroupPermissionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TargetGroupPermissionQuery
