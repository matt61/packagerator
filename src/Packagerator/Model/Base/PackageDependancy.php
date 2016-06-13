<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\Package as ChildPackage;
use Packagerator\Model\PackageDependancy as ChildPackageDependancy;
use Packagerator\Model\PackageDependancyQuery as ChildPackageDependancyQuery;
use Packagerator\Model\PackageDependancyVersion as ChildPackageDependancyVersion;
use Packagerator\Model\PackageDependancyVersionQuery as ChildPackageDependancyVersionQuery;
use Packagerator\Model\PackageQuery as ChildPackageQuery;
use Packagerator\Model\PackageVersionQuery as ChildPackageVersionQuery;
use Packagerator\Model\Map\PackageDependancyTableMap;
use Packagerator\Model\Map\PackageDependancyVersionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;

/**
 * Base class that represents a row from the 'package_dependancy' table.
 *
 *
 *
 * @package    propel.generator.Packagerator.Model.Base
 */
abstract class PackageDependancy implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Packagerator\\Model\\Map\\PackageDependancyTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the package_id field.
     *
     * @var        int
     */
    protected $package_id;

    /**
     * The value for the required_package_id field.
     *
     * @var        int
     */
    protected $required_package_id;

    /**
     * The value for the version field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * @var        ChildPackage
     */
    protected $aPackageRelatedByPackageId;

    /**
     * @var        ChildPackage
     */
    protected $aRequiredPackage;

    /**
     * @var        ObjectCollection|ChildPackageDependancyVersion[] Collection to store aggregation of ChildPackageDependancyVersion objects.
     */
    protected $collPackageDependancyVersions;
    protected $collPackageDependancyVersionsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    // versionable behavior


    /**
     * @var bool
     */
    protected $enforceVersion = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPackageDependancyVersion[]
     */
    protected $packageDependancyVersionsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = 0;
    }

    /**
     * Initializes internal state of Packagerator\Model\Base\PackageDependancy object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>PackageDependancy</code> instance.  If
     * <code>obj</code> is an instance of <code>PackageDependancy</code>, delegates to
     * <code>equals(PackageDependancy)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|PackageDependancy The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [package_id] column value.
     *
     * @return int
     */
    public function getPackageId()
    {
        return $this->package_id;
    }

    /**
     * Get the [required_package_id] column value.
     *
     * @return int
     */
    public function getRequiredPackageId()
    {
        return $this->required_package_id;
    }

    /**
     * Get the [version] column value.
     *
     * @return int
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PackageDependancyTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [package_id] column.
     *
     * @param int $v new value
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     */
    public function setPackageId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->package_id !== $v) {
            $this->package_id = $v;
            $this->modifiedColumns[PackageDependancyTableMap::COL_PACKAGE_ID] = true;
        }

        if ($this->aPackageRelatedByPackageId !== null && $this->aPackageRelatedByPackageId->getId() !== $v) {
            $this->aPackageRelatedByPackageId = null;
        }

        return $this;
    } // setPackageId()

    /**
     * Set the value of [required_package_id] column.
     *
     * @param int $v new value
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     */
    public function setRequiredPackageId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->required_package_id !== $v) {
            $this->required_package_id = $v;
            $this->modifiedColumns[PackageDependancyTableMap::COL_REQUIRED_PACKAGE_ID] = true;
        }

        if ($this->aRequiredPackage !== null && $this->aRequiredPackage->getId() !== $v) {
            $this->aRequiredPackage = null;
        }

        return $this;
    } // setRequiredPackageId()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[PackageDependancyTableMap::COL_VERSION] = true;
        }

        return $this;
    } // setVersion()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->version !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PackageDependancyTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PackageDependancyTableMap::translateFieldName('PackageId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->package_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PackageDependancyTableMap::translateFieldName('RequiredPackageId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->required_package_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PackageDependancyTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = PackageDependancyTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Packagerator\\Model\\PackageDependancy'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aPackageRelatedByPackageId !== null && $this->package_id !== $this->aPackageRelatedByPackageId->getId()) {
            $this->aPackageRelatedByPackageId = null;
        }
        if ($this->aRequiredPackage !== null && $this->required_package_id !== $this->aRequiredPackage->getId()) {
            $this->aRequiredPackage = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PackageDependancyTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPackageDependancyQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aPackageRelatedByPackageId = null;
            $this->aRequiredPackage = null;
            $this->collPackageDependancyVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see PackageDependancy::setDeleted()
     * @see PackageDependancy::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPackageDependancyQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageDependancyTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            // versionable behavior
            if ($this->isVersioningNecessary()) {
                $this->setVersion($this->isNew() ? 1 : $this->getLastVersionNumber($con) + 1);
                $createVersion = true; // for postSave hook
            }
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                // versionable behavior
                if (isset($createVersion)) {
                    $this->addVersion($con);
                }
                PackageDependancyTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aPackageRelatedByPackageId !== null) {
                if ($this->aPackageRelatedByPackageId->isModified() || $this->aPackageRelatedByPackageId->isNew()) {
                    $affectedRows += $this->aPackageRelatedByPackageId->save($con);
                }
                $this->setPackageRelatedByPackageId($this->aPackageRelatedByPackageId);
            }

            if ($this->aRequiredPackage !== null) {
                if ($this->aRequiredPackage->isModified() || $this->aRequiredPackage->isNew()) {
                    $affectedRows += $this->aRequiredPackage->save($con);
                }
                $this->setRequiredPackage($this->aRequiredPackage);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->packageDependancyVersionsScheduledForDeletion !== null) {
                if (!$this->packageDependancyVersionsScheduledForDeletion->isEmpty()) {
                    \Packagerator\Model\PackageDependancyVersionQuery::create()
                        ->filterByPrimaryKeys($this->packageDependancyVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->packageDependancyVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collPackageDependancyVersions !== null) {
                foreach ($this->collPackageDependancyVersions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PackageDependancyTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PackageDependancyTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PackageDependancyTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PackageDependancyTableMap::COL_PACKAGE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'package_id';
        }
        if ($this->isColumnModified(PackageDependancyTableMap::COL_REQUIRED_PACKAGE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'required_package_id';
        }
        if ($this->isColumnModified(PackageDependancyTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }

        $sql = sprintf(
            'INSERT INTO package_dependancy (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'package_id':
                        $stmt->bindValue($identifier, $this->package_id, PDO::PARAM_INT);
                        break;
                    case 'required_package_id':
                        $stmt->bindValue($identifier, $this->required_package_id, PDO::PARAM_INT);
                        break;
                    case 'version':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PackageDependancyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getPackageId();
                break;
            case 2:
                return $this->getRequiredPackageId();
                break;
            case 3:
                return $this->getVersion();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['PackageDependancy'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['PackageDependancy'][$this->hashCode()] = true;
        $keys = PackageDependancyTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getPackageId(),
            $keys[2] => $this->getRequiredPackageId(),
            $keys[3] => $this->getVersion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aPackageRelatedByPackageId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'package';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'package';
                        break;
                    default:
                        $key = 'Package';
                }

                $result[$key] = $this->aPackageRelatedByPackageId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aRequiredPackage) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'package';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'package';
                        break;
                    default:
                        $key = 'RequiredPackage';
                }

                $result[$key] = $this->aRequiredPackage->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collPackageDependancyVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'packageDependancyVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'package_dependancy_versions';
                        break;
                    default:
                        $key = 'PackageDependancyVersions';
                }

                $result[$key] = $this->collPackageDependancyVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Packagerator\Model\PackageDependancy
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PackageDependancyTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Packagerator\Model\PackageDependancy
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setPackageId($value);
                break;
            case 2:
                $this->setRequiredPackageId($value);
                break;
            case 3:
                $this->setVersion($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PackageDependancyTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setPackageId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRequiredPackageId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setVersion($arr[$keys[3]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Packagerator\Model\PackageDependancy The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PackageDependancyTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PackageDependancyTableMap::COL_ID)) {
            $criteria->add(PackageDependancyTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PackageDependancyTableMap::COL_PACKAGE_ID)) {
            $criteria->add(PackageDependancyTableMap::COL_PACKAGE_ID, $this->package_id);
        }
        if ($this->isColumnModified(PackageDependancyTableMap::COL_REQUIRED_PACKAGE_ID)) {
            $criteria->add(PackageDependancyTableMap::COL_REQUIRED_PACKAGE_ID, $this->required_package_id);
        }
        if ($this->isColumnModified(PackageDependancyTableMap::COL_VERSION)) {
            $criteria->add(PackageDependancyTableMap::COL_VERSION, $this->version);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPackageDependancyQuery::create();
        $criteria->add(PackageDependancyTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Packagerator\Model\PackageDependancy (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setPackageId($this->getPackageId());
        $copyObj->setRequiredPackageId($this->getRequiredPackageId());
        $copyObj->setVersion($this->getVersion());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPackageDependancyVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPackageDependancyVersion($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Packagerator\Model\PackageDependancy Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildPackage object.
     *
     * @param  ChildPackage $v
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPackageRelatedByPackageId(ChildPackage $v = null)
    {
        if ($v === null) {
            $this->setPackageId(NULL);
        } else {
            $this->setPackageId($v->getId());
        }

        $this->aPackageRelatedByPackageId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPackage object, it will not be re-added.
        if ($v !== null) {
            $v->addPackageDependancyRelatedByPackageId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPackage object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPackage The associated ChildPackage object.
     * @throws PropelException
     */
    public function getPackageRelatedByPackageId(ConnectionInterface $con = null)
    {
        if ($this->aPackageRelatedByPackageId === null && ($this->package_id !== null)) {
            $this->aPackageRelatedByPackageId = ChildPackageQuery::create()->findPk($this->package_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPackageRelatedByPackageId->addPackageDependanciesRelatedByPackageId($this);
             */
        }

        return $this->aPackageRelatedByPackageId;
    }

    /**
     * Declares an association between this object and a ChildPackage object.
     *
     * @param  ChildPackage $v
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     * @throws PropelException
     */
    public function setRequiredPackage(ChildPackage $v = null)
    {
        if ($v === null) {
            $this->setRequiredPackageId(NULL);
        } else {
            $this->setRequiredPackageId($v->getId());
        }

        $this->aRequiredPackage = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPackage object, it will not be re-added.
        if ($v !== null) {
            $v->addPackageDependancyRelatedByRequiredPackageId($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPackage object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPackage The associated ChildPackage object.
     * @throws PropelException
     */
    public function getRequiredPackage(ConnectionInterface $con = null)
    {
        if ($this->aRequiredPackage === null && ($this->required_package_id !== null)) {
            $this->aRequiredPackage = ChildPackageQuery::create()->findPk($this->required_package_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aRequiredPackage->addPackageDependanciesRelatedByRequiredPackageId($this);
             */
        }

        return $this->aRequiredPackage;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PackageDependancyVersion' == $relationName) {
            return $this->initPackageDependancyVersions();
        }
    }

    /**
     * Clears out the collPackageDependancyVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPackageDependancyVersions()
     */
    public function clearPackageDependancyVersions()
    {
        $this->collPackageDependancyVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPackageDependancyVersions collection loaded partially.
     */
    public function resetPartialPackageDependancyVersions($v = true)
    {
        $this->collPackageDependancyVersionsPartial = $v;
    }

    /**
     * Initializes the collPackageDependancyVersions collection.
     *
     * By default this just sets the collPackageDependancyVersions collection to an empty array (like clearcollPackageDependancyVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPackageDependancyVersions($overrideExisting = true)
    {
        if (null !== $this->collPackageDependancyVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = PackageDependancyVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collPackageDependancyVersions = new $collectionClassName;
        $this->collPackageDependancyVersions->setModel('\Packagerator\Model\PackageDependancyVersion');
    }

    /**
     * Gets an array of ChildPackageDependancyVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPackageDependancy is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPackageDependancyVersion[] List of ChildPackageDependancyVersion objects
     * @throws PropelException
     */
    public function getPackageDependancyVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageDependancyVersionsPartial && !$this->isNew();
        if (null === $this->collPackageDependancyVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPackageDependancyVersions) {
                // return empty collection
                $this->initPackageDependancyVersions();
            } else {
                $collPackageDependancyVersions = ChildPackageDependancyVersionQuery::create(null, $criteria)
                    ->filterByPackageDependancy($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPackageDependancyVersionsPartial && count($collPackageDependancyVersions)) {
                        $this->initPackageDependancyVersions(false);

                        foreach ($collPackageDependancyVersions as $obj) {
                            if (false == $this->collPackageDependancyVersions->contains($obj)) {
                                $this->collPackageDependancyVersions->append($obj);
                            }
                        }

                        $this->collPackageDependancyVersionsPartial = true;
                    }

                    return $collPackageDependancyVersions;
                }

                if ($partial && $this->collPackageDependancyVersions) {
                    foreach ($this->collPackageDependancyVersions as $obj) {
                        if ($obj->isNew()) {
                            $collPackageDependancyVersions[] = $obj;
                        }
                    }
                }

                $this->collPackageDependancyVersions = $collPackageDependancyVersions;
                $this->collPackageDependancyVersionsPartial = false;
            }
        }

        return $this->collPackageDependancyVersions;
    }

    /**
     * Sets a collection of ChildPackageDependancyVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $packageDependancyVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPackageDependancy The current object (for fluent API support)
     */
    public function setPackageDependancyVersions(Collection $packageDependancyVersions, ConnectionInterface $con = null)
    {
        /** @var ChildPackageDependancyVersion[] $packageDependancyVersionsToDelete */
        $packageDependancyVersionsToDelete = $this->getPackageDependancyVersions(new Criteria(), $con)->diff($packageDependancyVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->packageDependancyVersionsScheduledForDeletion = clone $packageDependancyVersionsToDelete;

        foreach ($packageDependancyVersionsToDelete as $packageDependancyVersionRemoved) {
            $packageDependancyVersionRemoved->setPackageDependancy(null);
        }

        $this->collPackageDependancyVersions = null;
        foreach ($packageDependancyVersions as $packageDependancyVersion) {
            $this->addPackageDependancyVersion($packageDependancyVersion);
        }

        $this->collPackageDependancyVersions = $packageDependancyVersions;
        $this->collPackageDependancyVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PackageDependancyVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PackageDependancyVersion objects.
     * @throws PropelException
     */
    public function countPackageDependancyVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageDependancyVersionsPartial && !$this->isNew();
        if (null === $this->collPackageDependancyVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPackageDependancyVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPackageDependancyVersions());
            }

            $query = ChildPackageDependancyVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPackageDependancy($this)
                ->count($con);
        }

        return count($this->collPackageDependancyVersions);
    }

    /**
     * Method called to associate a ChildPackageDependancyVersion object to this object
     * through the ChildPackageDependancyVersion foreign key attribute.
     *
     * @param  ChildPackageDependancyVersion $l ChildPackageDependancyVersion
     * @return $this|\Packagerator\Model\PackageDependancy The current object (for fluent API support)
     */
    public function addPackageDependancyVersion(ChildPackageDependancyVersion $l)
    {
        if ($this->collPackageDependancyVersions === null) {
            $this->initPackageDependancyVersions();
            $this->collPackageDependancyVersionsPartial = true;
        }

        if (!$this->collPackageDependancyVersions->contains($l)) {
            $this->doAddPackageDependancyVersion($l);

            if ($this->packageDependancyVersionsScheduledForDeletion and $this->packageDependancyVersionsScheduledForDeletion->contains($l)) {
                $this->packageDependancyVersionsScheduledForDeletion->remove($this->packageDependancyVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPackageDependancyVersion $packageDependancyVersion The ChildPackageDependancyVersion object to add.
     */
    protected function doAddPackageDependancyVersion(ChildPackageDependancyVersion $packageDependancyVersion)
    {
        $this->collPackageDependancyVersions[]= $packageDependancyVersion;
        $packageDependancyVersion->setPackageDependancy($this);
    }

    /**
     * @param  ChildPackageDependancyVersion $packageDependancyVersion The ChildPackageDependancyVersion object to remove.
     * @return $this|ChildPackageDependancy The current object (for fluent API support)
     */
    public function removePackageDependancyVersion(ChildPackageDependancyVersion $packageDependancyVersion)
    {
        if ($this->getPackageDependancyVersions()->contains($packageDependancyVersion)) {
            $pos = $this->collPackageDependancyVersions->search($packageDependancyVersion);
            $this->collPackageDependancyVersions->remove($pos);
            if (null === $this->packageDependancyVersionsScheduledForDeletion) {
                $this->packageDependancyVersionsScheduledForDeletion = clone $this->collPackageDependancyVersions;
                $this->packageDependancyVersionsScheduledForDeletion->clear();
            }
            $this->packageDependancyVersionsScheduledForDeletion[]= clone $packageDependancyVersion;
            $packageDependancyVersion->setPackageDependancy(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aPackageRelatedByPackageId) {
            $this->aPackageRelatedByPackageId->removePackageDependancyRelatedByPackageId($this);
        }
        if (null !== $this->aRequiredPackage) {
            $this->aRequiredPackage->removePackageDependancyRelatedByRequiredPackageId($this);
        }
        $this->id = null;
        $this->package_id = null;
        $this->required_package_id = null;
        $this->version = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPackageDependancyVersions) {
                foreach ($this->collPackageDependancyVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPackageDependancyVersions = null;
        $this->aPackageRelatedByPackageId = null;
        $this->aRequiredPackage = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PackageDependancyTableMap::DEFAULT_STRING_FORMAT);
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\Packagerator\Model\PackageDependancy
     */
    public function enforceVersioning()
    {
        $this->enforceVersion = true;

        return $this;
    }

    /**
     * Checks whether the current state must be recorded as a version
     *
     * @return  boolean
     */
    public function isVersioningNecessary($con = null)
    {
        if ($this->alreadyInSave) {
            return false;
        }

        if ($this->enforceVersion) {
            return true;
        }

        if (ChildPackageDependancyQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        if (null !== ($object = $this->getPackageRelatedByPackageId($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }

        if (null !== ($object = $this->getRequiredPackage($con)) && $object->isVersioningNecessary($con)) {
            return true;
        }


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildPackageDependancyVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildPackageDependancyVersion();
        $version->setId($this->getId());
        $version->setPackageId($this->getPackageId());
        $version->setRequiredPackageId($this->getRequiredPackageId());
        $version->setVersion($this->getVersion());
        $version->setPackageDependancy($this);
        if (($related = $this->getPackageRelatedByPackageId(null, $con)) && $related->getVersion()) {
            $version->setPackageIdVersion($related->getVersion());
        }
        if (($related = $this->getRequiredPackage(null, $con)) && $related->getVersion()) {
            $version->setRequiredPackageIdVersion($related->getVersion());
        }
        $version->save($con);

        return $version;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con The connection to use
     *
     * @return  $this|ChildPackageDependancy The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildPackageDependancy object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildPackageDependancyVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildPackageDependancy The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildPackageDependancy'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setPackageId($version->getPackageId());
        $this->setRequiredPackageId($version->getRequiredPackageId());
        $this->setVersion($version->getVersion());
        if ($fkValue = $version->getPackageId()) {
            if (isset($loadedObjects['ChildPackage']) && isset($loadedObjects['ChildPackage'][$fkValue]) && isset($loadedObjects['ChildPackage'][$fkValue][$version->getPackageIdVersion()])) {
                $related = $loadedObjects['ChildPackage'][$fkValue][$version->getPackageIdVersion()];
            } else {
                $related = new ChildPackage();
                $relatedVersion = ChildPackageVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersion($version->getPackageIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setPackageRelatedByPackageId($related);
        }
        if ($fkValue = $version->getRequiredPackageId()) {
            if (isset($loadedObjects['ChildPackage']) && isset($loadedObjects['ChildPackage'][$fkValue]) && isset($loadedObjects['ChildPackage'][$fkValue][$version->getRequiredPackageIdVersion()])) {
                $related = $loadedObjects['ChildPackage'][$fkValue][$version->getRequiredPackageIdVersion()];
            } else {
                $related = new ChildPackage();
                $relatedVersion = ChildPackageVersionQuery::create()
                    ->filterById($fkValue)
                    ->filterByVersion($version->getRequiredPackageIdVersion())
                    ->findOne($con);
                $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                $related->setNew(false);
            }
            $this->setRequiredPackage($related);
        }

        return $this;
    }

    /**
     * Gets the latest persisted version number for the current object
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  integer
     */
    public function getLastVersionNumber($con = null)
    {
        $v = ChildPackageDependancyVersionQuery::create()
            ->filterByPackageDependancy($this)
            ->orderByVersion('desc')
            ->findOne($con);
        if (!$v) {
            return 0;
        }

        return $v->getVersion();
    }

    /**
     * Checks whether the current object is the latest one
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  Boolean
     */
    public function isLastVersion($con = null)
    {
        return $this->getLastVersionNumber($con) == $this->getVersion();
    }

    /**
     * Retrieves a version object for this entity and a version number
     *
     * @param   integer $versionNumber The version number to read
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildPackageDependancyVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildPackageDependancyVersionQuery::create()
            ->filterByPackageDependancy($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection|ChildPackageDependancyVersion[] A list of ChildPackageDependancyVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(PackageDependancyVersionTableMap::COL_VERSION);

        return $this->getPackageDependancyVersions($criteria, $con);
    }

    /**
     * Compares the current object with another of its version.
     * <code>
     * print_r($book->compareVersion(1));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $versionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersion($versionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->toArray();
        $toVersion = $this->getOneVersion($versionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Compares two versions of the current object.
     * <code>
     * print_r($book->compareVersions(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   integer             $fromVersionNumber
     * @param   integer             $toVersionNumber
     * @param   string              $keys Main key used for the result diff (versions|columns)
     * @param   ConnectionInterface $con the connection to use
     * @param   array               $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    public function compareVersions($fromVersionNumber, $toVersionNumber, $keys = 'columns', $con = null, $ignoredColumns = array())
    {
        $fromVersion = $this->getOneVersion($fromVersionNumber, $con)->toArray();
        $toVersion = $this->getOneVersion($toVersionNumber, $con)->toArray();

        return $this->computeDiff($fromVersion, $toVersion, $keys, $ignoredColumns);
    }

    /**
     * Computes the diff between two versions.
     * <code>
     * print_r($book->computeDiff(1, 2));
     * => array(
     *   '1' => array('Title' => 'Book title at version 1'),
     *   '2' => array('Title' => 'Book title at version 2')
     * );
     * </code>
     *
     * @param   array     $fromVersion     An array representing the original version.
     * @param   array     $toVersion       An array representing the destination version.
     * @param   string    $keys            Main key used for the result diff (versions|columns).
     * @param   array     $ignoredColumns  The columns to exclude from the diff.
     *
     * @return  array A list of differences
     */
    protected function computeDiff($fromVersion, $toVersion, $keys = 'columns', $ignoredColumns = array())
    {
        $fromVersionNumber = $fromVersion['Version'];
        $toVersionNumber = $toVersion['Version'];
        $ignoredColumns = array_merge(array(
            'Version',
        ), $ignoredColumns);
        $diff = array();
        foreach ($fromVersion as $key => $value) {
            if (in_array($key, $ignoredColumns)) {
                continue;
            }
            if ($toVersion[$key] != $value) {
                switch ($keys) {
                    case 'versions':
                        $diff[$fromVersionNumber][$key] = $value;
                        $diff[$toVersionNumber][$key] = $toVersion[$key];
                        break;
                    default:
                        $diff[$key] = array(
                            $fromVersionNumber => $value,
                            $toVersionNumber => $toVersion[$key],
                        );
                        break;
                }
            }
        }

        return $diff;
    }
    /**
     * retrieve the last $number versions.
     *
     * @param Integer $number the number of record to return.
     * @return PropelCollection|\Packagerator\Model\PackageDependancyVersion[] List of \Packagerator\Model\PackageDependancyVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildPackageDependancyVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(PackageDependancyVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getPackageDependancyVersions($criteria, $con);
    }
    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
