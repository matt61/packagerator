<?php

namespace Packagerator\Model\Base;

use \Exception;
use \PDO;
use Packagerator\Model\Package as ChildPackage;
use Packagerator\Model\PackageDependancy as ChildPackageDependancy;
use Packagerator\Model\PackageDependancyQuery as ChildPackageDependancyQuery;
use Packagerator\Model\PackageDependancyVersionQuery as ChildPackageDependancyVersionQuery;
use Packagerator\Model\PackageQuery as ChildPackageQuery;
use Packagerator\Model\PackageVersion as ChildPackageVersion;
use Packagerator\Model\PackageVersionQuery as ChildPackageVersionQuery;
use Packagerator\Model\Map\PackageDependancyTableMap;
use Packagerator\Model\Map\PackageDependancyVersionTableMap;
use Packagerator\Model\Map\PackageTableMap;
use Packagerator\Model\Map\PackageVersionTableMap;
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
 * Base class that represents a row from the 'package' table.
 *
 *
 *
 * @package    propel.generator.Packagerator.Model.Base
 */
abstract class Package implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Packagerator\\Model\\Map\\PackageTableMap';


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
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the version field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $version;

    /**
     * @var        ObjectCollection|ChildPackageDependancy[] Collection to store aggregation of ChildPackageDependancy objects.
     */
    protected $collPackageDependanciesRelatedByPackageId;
    protected $collPackageDependanciesRelatedByPackageIdPartial;

    /**
     * @var        ObjectCollection|ChildPackageDependancy[] Collection to store aggregation of ChildPackageDependancy objects.
     */
    protected $collPackageDependanciesRelatedByRequiredPackageId;
    protected $collPackageDependanciesRelatedByRequiredPackageIdPartial;

    /**
     * @var        ObjectCollection|ChildPackageVersion[] Collection to store aggregation of ChildPackageVersion objects.
     */
    protected $collPackageVersions;
    protected $collPackageVersionsPartial;

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
     * @var ObjectCollection|ChildPackageDependancy[]
     */
    protected $packageDependanciesRelatedByPackageIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPackageDependancy[]
     */
    protected $packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPackageVersion[]
     */
    protected $packageVersionsScheduledForDeletion = null;

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
     * Initializes internal state of Packagerator\Model\Base\Package object.
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
     * Compares this with another <code>Package</code> instance.  If
     * <code>obj</code> is an instance of <code>Package</code>, delegates to
     * <code>equals(Package)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Package The current object, for fluid interface
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
     * @return $this|\Packagerator\Model\Package The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PackageTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Packagerator\Model\Package The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PackageTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [version] column.
     *
     * @param int $v new value
     * @return $this|\Packagerator\Model\Package The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[PackageTableMap::COL_VERSION] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PackageTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PackageTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PackageTableMap::translateFieldName('Version', TableMap::TYPE_PHPNAME, $indexType)];
            $this->version = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 3; // 3 = PackageTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Packagerator\\Model\\Package'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PackageTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPackageQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPackageDependanciesRelatedByPackageId = null;

            $this->collPackageDependanciesRelatedByRequiredPackageId = null;

            $this->collPackageVersions = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Package::setDeleted()
     * @see Package::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PackageTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPackageQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PackageTableMap::DATABASE_NAME);
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
                PackageTableMap::addInstanceToPool($this);
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

            if ($this->packageDependanciesRelatedByPackageIdScheduledForDeletion !== null) {
                if (!$this->packageDependanciesRelatedByPackageIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->packageDependanciesRelatedByPackageIdScheduledForDeletion as $packageDependancyRelatedByPackageId) {
                        // need to save related object because we set the relation to null
                        $packageDependancyRelatedByPackageId->save($con);
                    }
                    $this->packageDependanciesRelatedByPackageIdScheduledForDeletion = null;
                }
            }

            if ($this->collPackageDependanciesRelatedByPackageId !== null) {
                foreach ($this->collPackageDependanciesRelatedByPackageId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion !== null) {
                if (!$this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion as $packageDependancyRelatedByRequiredPackageId) {
                        // need to save related object because we set the relation to null
                        $packageDependancyRelatedByRequiredPackageId->save($con);
                    }
                    $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion = null;
                }
            }

            if ($this->collPackageDependanciesRelatedByRequiredPackageId !== null) {
                foreach ($this->collPackageDependanciesRelatedByRequiredPackageId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->packageVersionsScheduledForDeletion !== null) {
                if (!$this->packageVersionsScheduledForDeletion->isEmpty()) {
                    \Packagerator\Model\PackageVersionQuery::create()
                        ->filterByPrimaryKeys($this->packageVersionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->packageVersionsScheduledForDeletion = null;
                }
            }

            if ($this->collPackageVersions !== null) {
                foreach ($this->collPackageVersions as $referrerFK) {
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

        $this->modifiedColumns[PackageTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PackageTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PackageTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PackageTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PackageTableMap::COL_VERSION)) {
            $modifiedColumns[':p' . $index++]  = 'version';
        }

        $sql = sprintf(
            'INSERT INTO package (%s) VALUES (%s)',
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
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
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
        $pos = PackageTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getName();
                break;
            case 2:
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

        if (isset($alreadyDumpedObjects['Package'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Package'][$this->hashCode()] = true;
        $keys = PackageTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getVersion(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collPackageDependanciesRelatedByPackageId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'packageDependancies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'package_dependancies';
                        break;
                    default:
                        $key = 'PackageDependancies';
                }

                $result[$key] = $this->collPackageDependanciesRelatedByPackageId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPackageDependanciesRelatedByRequiredPackageId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'packageDependancies';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'package_dependancies';
                        break;
                    default:
                        $key = 'PackageDependancies';
                }

                $result[$key] = $this->collPackageDependanciesRelatedByRequiredPackageId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPackageVersions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'packageVersions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'package_versions';
                        break;
                    default:
                        $key = 'PackageVersions';
                }

                $result[$key] = $this->collPackageVersions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Packagerator\Model\Package
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PackageTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Packagerator\Model\Package
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
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
        $keys = PackageTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setVersion($arr[$keys[2]]);
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
     * @return $this|\Packagerator\Model\Package The current object, for fluid interface
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
        $criteria = new Criteria(PackageTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PackageTableMap::COL_ID)) {
            $criteria->add(PackageTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PackageTableMap::COL_NAME)) {
            $criteria->add(PackageTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PackageTableMap::COL_VERSION)) {
            $criteria->add(PackageTableMap::COL_VERSION, $this->version);
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
        $criteria = ChildPackageQuery::create();
        $criteria->add(PackageTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Packagerator\Model\Package (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setVersion($this->getVersion());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPackageDependanciesRelatedByPackageId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPackageDependancyRelatedByPackageId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPackageDependanciesRelatedByRequiredPackageId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPackageDependancyRelatedByRequiredPackageId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPackageVersions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPackageVersion($relObj->copy($deepCopy));
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
     * @return \Packagerator\Model\Package Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PackageDependancyRelatedByPackageId' == $relationName) {
            return $this->initPackageDependanciesRelatedByPackageId();
        }
        if ('PackageDependancyRelatedByRequiredPackageId' == $relationName) {
            return $this->initPackageDependanciesRelatedByRequiredPackageId();
        }
        if ('PackageVersion' == $relationName) {
            return $this->initPackageVersions();
        }
    }

    /**
     * Clears out the collPackageDependanciesRelatedByPackageId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPackageDependanciesRelatedByPackageId()
     */
    public function clearPackageDependanciesRelatedByPackageId()
    {
        $this->collPackageDependanciesRelatedByPackageId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPackageDependanciesRelatedByPackageId collection loaded partially.
     */
    public function resetPartialPackageDependanciesRelatedByPackageId($v = true)
    {
        $this->collPackageDependanciesRelatedByPackageIdPartial = $v;
    }

    /**
     * Initializes the collPackageDependanciesRelatedByPackageId collection.
     *
     * By default this just sets the collPackageDependanciesRelatedByPackageId collection to an empty array (like clearcollPackageDependanciesRelatedByPackageId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPackageDependanciesRelatedByPackageId($overrideExisting = true)
    {
        if (null !== $this->collPackageDependanciesRelatedByPackageId && !$overrideExisting) {
            return;
        }

        $collectionClassName = PackageDependancyTableMap::getTableMap()->getCollectionClassName();

        $this->collPackageDependanciesRelatedByPackageId = new $collectionClassName;
        $this->collPackageDependanciesRelatedByPackageId->setModel('\Packagerator\Model\PackageDependancy');
    }

    /**
     * Gets an array of ChildPackageDependancy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPackage is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPackageDependancy[] List of ChildPackageDependancy objects
     * @throws PropelException
     */
    public function getPackageDependanciesRelatedByPackageId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageDependanciesRelatedByPackageIdPartial && !$this->isNew();
        if (null === $this->collPackageDependanciesRelatedByPackageId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPackageDependanciesRelatedByPackageId) {
                // return empty collection
                $this->initPackageDependanciesRelatedByPackageId();
            } else {
                $collPackageDependanciesRelatedByPackageId = ChildPackageDependancyQuery::create(null, $criteria)
                    ->filterByPackageRelatedByPackageId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPackageDependanciesRelatedByPackageIdPartial && count($collPackageDependanciesRelatedByPackageId)) {
                        $this->initPackageDependanciesRelatedByPackageId(false);

                        foreach ($collPackageDependanciesRelatedByPackageId as $obj) {
                            if (false == $this->collPackageDependanciesRelatedByPackageId->contains($obj)) {
                                $this->collPackageDependanciesRelatedByPackageId->append($obj);
                            }
                        }

                        $this->collPackageDependanciesRelatedByPackageIdPartial = true;
                    }

                    return $collPackageDependanciesRelatedByPackageId;
                }

                if ($partial && $this->collPackageDependanciesRelatedByPackageId) {
                    foreach ($this->collPackageDependanciesRelatedByPackageId as $obj) {
                        if ($obj->isNew()) {
                            $collPackageDependanciesRelatedByPackageId[] = $obj;
                        }
                    }
                }

                $this->collPackageDependanciesRelatedByPackageId = $collPackageDependanciesRelatedByPackageId;
                $this->collPackageDependanciesRelatedByPackageIdPartial = false;
            }
        }

        return $this->collPackageDependanciesRelatedByPackageId;
    }

    /**
     * Sets a collection of ChildPackageDependancy objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $packageDependanciesRelatedByPackageId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function setPackageDependanciesRelatedByPackageId(Collection $packageDependanciesRelatedByPackageId, ConnectionInterface $con = null)
    {
        /** @var ChildPackageDependancy[] $packageDependanciesRelatedByPackageIdToDelete */
        $packageDependanciesRelatedByPackageIdToDelete = $this->getPackageDependanciesRelatedByPackageId(new Criteria(), $con)->diff($packageDependanciesRelatedByPackageId);


        $this->packageDependanciesRelatedByPackageIdScheduledForDeletion = $packageDependanciesRelatedByPackageIdToDelete;

        foreach ($packageDependanciesRelatedByPackageIdToDelete as $packageDependancyRelatedByPackageIdRemoved) {
            $packageDependancyRelatedByPackageIdRemoved->setPackageRelatedByPackageId(null);
        }

        $this->collPackageDependanciesRelatedByPackageId = null;
        foreach ($packageDependanciesRelatedByPackageId as $packageDependancyRelatedByPackageId) {
            $this->addPackageDependancyRelatedByPackageId($packageDependancyRelatedByPackageId);
        }

        $this->collPackageDependanciesRelatedByPackageId = $packageDependanciesRelatedByPackageId;
        $this->collPackageDependanciesRelatedByPackageIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PackageDependancy objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PackageDependancy objects.
     * @throws PropelException
     */
    public function countPackageDependanciesRelatedByPackageId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageDependanciesRelatedByPackageIdPartial && !$this->isNew();
        if (null === $this->collPackageDependanciesRelatedByPackageId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPackageDependanciesRelatedByPackageId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPackageDependanciesRelatedByPackageId());
            }

            $query = ChildPackageDependancyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPackageRelatedByPackageId($this)
                ->count($con);
        }

        return count($this->collPackageDependanciesRelatedByPackageId);
    }

    /**
     * Method called to associate a ChildPackageDependancy object to this object
     * through the ChildPackageDependancy foreign key attribute.
     *
     * @param  ChildPackageDependancy $l ChildPackageDependancy
     * @return $this|\Packagerator\Model\Package The current object (for fluent API support)
     */
    public function addPackageDependancyRelatedByPackageId(ChildPackageDependancy $l)
    {
        if ($this->collPackageDependanciesRelatedByPackageId === null) {
            $this->initPackageDependanciesRelatedByPackageId();
            $this->collPackageDependanciesRelatedByPackageIdPartial = true;
        }

        if (!$this->collPackageDependanciesRelatedByPackageId->contains($l)) {
            $this->doAddPackageDependancyRelatedByPackageId($l);

            if ($this->packageDependanciesRelatedByPackageIdScheduledForDeletion and $this->packageDependanciesRelatedByPackageIdScheduledForDeletion->contains($l)) {
                $this->packageDependanciesRelatedByPackageIdScheduledForDeletion->remove($this->packageDependanciesRelatedByPackageIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPackageDependancy $packageDependancyRelatedByPackageId The ChildPackageDependancy object to add.
     */
    protected function doAddPackageDependancyRelatedByPackageId(ChildPackageDependancy $packageDependancyRelatedByPackageId)
    {
        $this->collPackageDependanciesRelatedByPackageId[]= $packageDependancyRelatedByPackageId;
        $packageDependancyRelatedByPackageId->setPackageRelatedByPackageId($this);
    }

    /**
     * @param  ChildPackageDependancy $packageDependancyRelatedByPackageId The ChildPackageDependancy object to remove.
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function removePackageDependancyRelatedByPackageId(ChildPackageDependancy $packageDependancyRelatedByPackageId)
    {
        if ($this->getPackageDependanciesRelatedByPackageId()->contains($packageDependancyRelatedByPackageId)) {
            $pos = $this->collPackageDependanciesRelatedByPackageId->search($packageDependancyRelatedByPackageId);
            $this->collPackageDependanciesRelatedByPackageId->remove($pos);
            if (null === $this->packageDependanciesRelatedByPackageIdScheduledForDeletion) {
                $this->packageDependanciesRelatedByPackageIdScheduledForDeletion = clone $this->collPackageDependanciesRelatedByPackageId;
                $this->packageDependanciesRelatedByPackageIdScheduledForDeletion->clear();
            }
            $this->packageDependanciesRelatedByPackageIdScheduledForDeletion[]= $packageDependancyRelatedByPackageId;
            $packageDependancyRelatedByPackageId->setPackageRelatedByPackageId(null);
        }

        return $this;
    }

    /**
     * Clears out the collPackageDependanciesRelatedByRequiredPackageId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPackageDependanciesRelatedByRequiredPackageId()
     */
    public function clearPackageDependanciesRelatedByRequiredPackageId()
    {
        $this->collPackageDependanciesRelatedByRequiredPackageId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPackageDependanciesRelatedByRequiredPackageId collection loaded partially.
     */
    public function resetPartialPackageDependanciesRelatedByRequiredPackageId($v = true)
    {
        $this->collPackageDependanciesRelatedByRequiredPackageIdPartial = $v;
    }

    /**
     * Initializes the collPackageDependanciesRelatedByRequiredPackageId collection.
     *
     * By default this just sets the collPackageDependanciesRelatedByRequiredPackageId collection to an empty array (like clearcollPackageDependanciesRelatedByRequiredPackageId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPackageDependanciesRelatedByRequiredPackageId($overrideExisting = true)
    {
        if (null !== $this->collPackageDependanciesRelatedByRequiredPackageId && !$overrideExisting) {
            return;
        }

        $collectionClassName = PackageDependancyTableMap::getTableMap()->getCollectionClassName();

        $this->collPackageDependanciesRelatedByRequiredPackageId = new $collectionClassName;
        $this->collPackageDependanciesRelatedByRequiredPackageId->setModel('\Packagerator\Model\PackageDependancy');
    }

    /**
     * Gets an array of ChildPackageDependancy objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPackage is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPackageDependancy[] List of ChildPackageDependancy objects
     * @throws PropelException
     */
    public function getPackageDependanciesRelatedByRequiredPackageId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageDependanciesRelatedByRequiredPackageIdPartial && !$this->isNew();
        if (null === $this->collPackageDependanciesRelatedByRequiredPackageId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPackageDependanciesRelatedByRequiredPackageId) {
                // return empty collection
                $this->initPackageDependanciesRelatedByRequiredPackageId();
            } else {
                $collPackageDependanciesRelatedByRequiredPackageId = ChildPackageDependancyQuery::create(null, $criteria)
                    ->filterByRequiredPackage($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPackageDependanciesRelatedByRequiredPackageIdPartial && count($collPackageDependanciesRelatedByRequiredPackageId)) {
                        $this->initPackageDependanciesRelatedByRequiredPackageId(false);

                        foreach ($collPackageDependanciesRelatedByRequiredPackageId as $obj) {
                            if (false == $this->collPackageDependanciesRelatedByRequiredPackageId->contains($obj)) {
                                $this->collPackageDependanciesRelatedByRequiredPackageId->append($obj);
                            }
                        }

                        $this->collPackageDependanciesRelatedByRequiredPackageIdPartial = true;
                    }

                    return $collPackageDependanciesRelatedByRequiredPackageId;
                }

                if ($partial && $this->collPackageDependanciesRelatedByRequiredPackageId) {
                    foreach ($this->collPackageDependanciesRelatedByRequiredPackageId as $obj) {
                        if ($obj->isNew()) {
                            $collPackageDependanciesRelatedByRequiredPackageId[] = $obj;
                        }
                    }
                }

                $this->collPackageDependanciesRelatedByRequiredPackageId = $collPackageDependanciesRelatedByRequiredPackageId;
                $this->collPackageDependanciesRelatedByRequiredPackageIdPartial = false;
            }
        }

        return $this->collPackageDependanciesRelatedByRequiredPackageId;
    }

    /**
     * Sets a collection of ChildPackageDependancy objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $packageDependanciesRelatedByRequiredPackageId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function setPackageDependanciesRelatedByRequiredPackageId(Collection $packageDependanciesRelatedByRequiredPackageId, ConnectionInterface $con = null)
    {
        /** @var ChildPackageDependancy[] $packageDependanciesRelatedByRequiredPackageIdToDelete */
        $packageDependanciesRelatedByRequiredPackageIdToDelete = $this->getPackageDependanciesRelatedByRequiredPackageId(new Criteria(), $con)->diff($packageDependanciesRelatedByRequiredPackageId);


        $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion = $packageDependanciesRelatedByRequiredPackageIdToDelete;

        foreach ($packageDependanciesRelatedByRequiredPackageIdToDelete as $packageDependancyRelatedByRequiredPackageIdRemoved) {
            $packageDependancyRelatedByRequiredPackageIdRemoved->setRequiredPackage(null);
        }

        $this->collPackageDependanciesRelatedByRequiredPackageId = null;
        foreach ($packageDependanciesRelatedByRequiredPackageId as $packageDependancyRelatedByRequiredPackageId) {
            $this->addPackageDependancyRelatedByRequiredPackageId($packageDependancyRelatedByRequiredPackageId);
        }

        $this->collPackageDependanciesRelatedByRequiredPackageId = $packageDependanciesRelatedByRequiredPackageId;
        $this->collPackageDependanciesRelatedByRequiredPackageIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PackageDependancy objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PackageDependancy objects.
     * @throws PropelException
     */
    public function countPackageDependanciesRelatedByRequiredPackageId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageDependanciesRelatedByRequiredPackageIdPartial && !$this->isNew();
        if (null === $this->collPackageDependanciesRelatedByRequiredPackageId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPackageDependanciesRelatedByRequiredPackageId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPackageDependanciesRelatedByRequiredPackageId());
            }

            $query = ChildPackageDependancyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByRequiredPackage($this)
                ->count($con);
        }

        return count($this->collPackageDependanciesRelatedByRequiredPackageId);
    }

    /**
     * Method called to associate a ChildPackageDependancy object to this object
     * through the ChildPackageDependancy foreign key attribute.
     *
     * @param  ChildPackageDependancy $l ChildPackageDependancy
     * @return $this|\Packagerator\Model\Package The current object (for fluent API support)
     */
    public function addPackageDependancyRelatedByRequiredPackageId(ChildPackageDependancy $l)
    {
        if ($this->collPackageDependanciesRelatedByRequiredPackageId === null) {
            $this->initPackageDependanciesRelatedByRequiredPackageId();
            $this->collPackageDependanciesRelatedByRequiredPackageIdPartial = true;
        }

        if (!$this->collPackageDependanciesRelatedByRequiredPackageId->contains($l)) {
            $this->doAddPackageDependancyRelatedByRequiredPackageId($l);

            if ($this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion and $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion->contains($l)) {
                $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion->remove($this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPackageDependancy $packageDependancyRelatedByRequiredPackageId The ChildPackageDependancy object to add.
     */
    protected function doAddPackageDependancyRelatedByRequiredPackageId(ChildPackageDependancy $packageDependancyRelatedByRequiredPackageId)
    {
        $this->collPackageDependanciesRelatedByRequiredPackageId[]= $packageDependancyRelatedByRequiredPackageId;
        $packageDependancyRelatedByRequiredPackageId->setRequiredPackage($this);
    }

    /**
     * @param  ChildPackageDependancy $packageDependancyRelatedByRequiredPackageId The ChildPackageDependancy object to remove.
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function removePackageDependancyRelatedByRequiredPackageId(ChildPackageDependancy $packageDependancyRelatedByRequiredPackageId)
    {
        if ($this->getPackageDependanciesRelatedByRequiredPackageId()->contains($packageDependancyRelatedByRequiredPackageId)) {
            $pos = $this->collPackageDependanciesRelatedByRequiredPackageId->search($packageDependancyRelatedByRequiredPackageId);
            $this->collPackageDependanciesRelatedByRequiredPackageId->remove($pos);
            if (null === $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion) {
                $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion = clone $this->collPackageDependanciesRelatedByRequiredPackageId;
                $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion->clear();
            }
            $this->packageDependanciesRelatedByRequiredPackageIdScheduledForDeletion[]= $packageDependancyRelatedByRequiredPackageId;
            $packageDependancyRelatedByRequiredPackageId->setRequiredPackage(null);
        }

        return $this;
    }

    /**
     * Clears out the collPackageVersions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPackageVersions()
     */
    public function clearPackageVersions()
    {
        $this->collPackageVersions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPackageVersions collection loaded partially.
     */
    public function resetPartialPackageVersions($v = true)
    {
        $this->collPackageVersionsPartial = $v;
    }

    /**
     * Initializes the collPackageVersions collection.
     *
     * By default this just sets the collPackageVersions collection to an empty array (like clearcollPackageVersions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPackageVersions($overrideExisting = true)
    {
        if (null !== $this->collPackageVersions && !$overrideExisting) {
            return;
        }

        $collectionClassName = PackageVersionTableMap::getTableMap()->getCollectionClassName();

        $this->collPackageVersions = new $collectionClassName;
        $this->collPackageVersions->setModel('\Packagerator\Model\PackageVersion');
    }

    /**
     * Gets an array of ChildPackageVersion objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPackage is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPackageVersion[] List of ChildPackageVersion objects
     * @throws PropelException
     */
    public function getPackageVersions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageVersionsPartial && !$this->isNew();
        if (null === $this->collPackageVersions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPackageVersions) {
                // return empty collection
                $this->initPackageVersions();
            } else {
                $collPackageVersions = ChildPackageVersionQuery::create(null, $criteria)
                    ->filterByPackage($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPackageVersionsPartial && count($collPackageVersions)) {
                        $this->initPackageVersions(false);

                        foreach ($collPackageVersions as $obj) {
                            if (false == $this->collPackageVersions->contains($obj)) {
                                $this->collPackageVersions->append($obj);
                            }
                        }

                        $this->collPackageVersionsPartial = true;
                    }

                    return $collPackageVersions;
                }

                if ($partial && $this->collPackageVersions) {
                    foreach ($this->collPackageVersions as $obj) {
                        if ($obj->isNew()) {
                            $collPackageVersions[] = $obj;
                        }
                    }
                }

                $this->collPackageVersions = $collPackageVersions;
                $this->collPackageVersionsPartial = false;
            }
        }

        return $this->collPackageVersions;
    }

    /**
     * Sets a collection of ChildPackageVersion objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $packageVersions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function setPackageVersions(Collection $packageVersions, ConnectionInterface $con = null)
    {
        /** @var ChildPackageVersion[] $packageVersionsToDelete */
        $packageVersionsToDelete = $this->getPackageVersions(new Criteria(), $con)->diff($packageVersions);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->packageVersionsScheduledForDeletion = clone $packageVersionsToDelete;

        foreach ($packageVersionsToDelete as $packageVersionRemoved) {
            $packageVersionRemoved->setPackage(null);
        }

        $this->collPackageVersions = null;
        foreach ($packageVersions as $packageVersion) {
            $this->addPackageVersion($packageVersion);
        }

        $this->collPackageVersions = $packageVersions;
        $this->collPackageVersionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PackageVersion objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PackageVersion objects.
     * @throws PropelException
     */
    public function countPackageVersions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPackageVersionsPartial && !$this->isNew();
        if (null === $this->collPackageVersions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPackageVersions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPackageVersions());
            }

            $query = ChildPackageVersionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPackage($this)
                ->count($con);
        }

        return count($this->collPackageVersions);
    }

    /**
     * Method called to associate a ChildPackageVersion object to this object
     * through the ChildPackageVersion foreign key attribute.
     *
     * @param  ChildPackageVersion $l ChildPackageVersion
     * @return $this|\Packagerator\Model\Package The current object (for fluent API support)
     */
    public function addPackageVersion(ChildPackageVersion $l)
    {
        if ($this->collPackageVersions === null) {
            $this->initPackageVersions();
            $this->collPackageVersionsPartial = true;
        }

        if (!$this->collPackageVersions->contains($l)) {
            $this->doAddPackageVersion($l);

            if ($this->packageVersionsScheduledForDeletion and $this->packageVersionsScheduledForDeletion->contains($l)) {
                $this->packageVersionsScheduledForDeletion->remove($this->packageVersionsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPackageVersion $packageVersion The ChildPackageVersion object to add.
     */
    protected function doAddPackageVersion(ChildPackageVersion $packageVersion)
    {
        $this->collPackageVersions[]= $packageVersion;
        $packageVersion->setPackage($this);
    }

    /**
     * @param  ChildPackageVersion $packageVersion The ChildPackageVersion object to remove.
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function removePackageVersion(ChildPackageVersion $packageVersion)
    {
        if ($this->getPackageVersions()->contains($packageVersion)) {
            $pos = $this->collPackageVersions->search($packageVersion);
            $this->collPackageVersions->remove($pos);
            if (null === $this->packageVersionsScheduledForDeletion) {
                $this->packageVersionsScheduledForDeletion = clone $this->collPackageVersions;
                $this->packageVersionsScheduledForDeletion->clear();
            }
            $this->packageVersionsScheduledForDeletion[]= clone $packageVersion;
            $packageVersion->setPackage(null);
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
        $this->id = null;
        $this->name = null;
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
            if ($this->collPackageDependanciesRelatedByPackageId) {
                foreach ($this->collPackageDependanciesRelatedByPackageId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPackageDependanciesRelatedByRequiredPackageId) {
                foreach ($this->collPackageDependanciesRelatedByRequiredPackageId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPackageVersions) {
                foreach ($this->collPackageVersions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPackageDependanciesRelatedByPackageId = null;
        $this->collPackageDependanciesRelatedByRequiredPackageId = null;
        $this->collPackageVersions = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PackageTableMap::DEFAULT_STRING_FORMAT);
    }

    // versionable behavior

    /**
     * Enforce a new Version of this object upon next save.
     *
     * @return $this|\Packagerator\Model\Package
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

        if (ChildPackageQuery::isVersioningEnabled() && ($this->isNew() || $this->isModified()) || $this->isDeleted()) {
            return true;
        }
        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getPackageDependanciesRelatedByPackageId(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;

                return true;
            }
        }
        $this->alreadyInSave = false;

        // to avoid infinite loops, emulate in save
        $this->alreadyInSave = true;
        foreach ($this->getPackageDependanciesRelatedByRequiredPackageId(null, $con) as $relatedObject) {
            if ($relatedObject->isVersioningNecessary($con)) {
                $this->alreadyInSave = false;

                return true;
            }
        }
        $this->alreadyInSave = false;


        return false;
    }

    /**
     * Creates a version of the current object and saves it.
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ChildPackageVersion A version object
     */
    public function addVersion($con = null)
    {
        $this->enforceVersion = false;

        $version = new ChildPackageVersion();
        $version->setId($this->getId());
        $version->setName($this->getName());
        $version->setVersion($this->getVersion());
        $version->setPackage($this);
        if ($relateds = $this->getPackageDependanciesRelatedByPackageId(null, $con)->toKeyValue('Id', 'Version')) {
            $version->setPackageDependancyIds(array_keys($relateds));
            $version->setPackageDependancyVersions(array_values($relateds));
        }
        if ($relateds = $this->getPackageDependanciesRelatedByRequiredPackageId(null, $con)->toKeyValue('Id', 'Version')) {
            $version->setPackageDependancyIds(array_keys($relateds));
            $version->setPackageDependancyVersions(array_values($relateds));
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
     * @return  $this|ChildPackage The current object (for fluent API support)
     */
    public function toVersion($versionNumber, $con = null)
    {
        $version = $this->getOneVersion($versionNumber, $con);
        if (!$version) {
            throw new PropelException(sprintf('No ChildPackage object found with version %d', $version));
        }
        $this->populateFromVersion($version, $con);

        return $this;
    }

    /**
     * Sets the properties of the current object to the value they had at a specific version
     *
     * @param ChildPackageVersion $version The version object to use
     * @param ConnectionInterface   $con the connection to use
     * @param array                 $loadedObjects objects that been loaded in a chain of populateFromVersion calls on referrer or fk objects.
     *
     * @return $this|ChildPackage The current object (for fluent API support)
     */
    public function populateFromVersion($version, $con = null, &$loadedObjects = array())
    {
        $loadedObjects['ChildPackage'][$version->getId()][$version->getVersion()] = $this;
        $this->setId($version->getId());
        $this->setName($version->getName());
        $this->setVersion($version->getVersion());
        if ($fkValues = $version->getPackageDependancyIds()) {
            $this->clearPackageDependanciesRelatedByPackageId();
            $fkVersions = $version->getPackageDependancyVersions();
            $query = ChildPackageDependancyVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(PackageDependancyVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(PackageDependancyVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildPackageDependancy']) && isset($loadedObjects['ChildPackageDependancy'][$relatedVersion->getId()]) && isset($loadedObjects['ChildPackageDependancy'][$relatedVersion->getId()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildPackageDependancy'][$relatedVersion->getId()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildPackageDependancy();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addPackageDependancyRelatedByPackageId($related);
                $this->collPackageDependanciesRelatedByPackageIdPartial = false;
            }
        }
        if ($fkValues = $version->getPackageDependancyIds()) {
            $this->clearPackageDependancyRelatedByRequiredPackageId();
            $fkVersions = $version->getPackageDependancyVersions();
            $query = ChildPackageDependancyVersionQuery::create();
            foreach ($fkValues as $key => $value) {
                $c1 = $query->getNewCriterion(PackageDependancyVersionTableMap::COL_ID, $value);
                $c2 = $query->getNewCriterion(PackageDependancyVersionTableMap::COL_VERSION, $fkVersions[$key]);
                $c1->addAnd($c2);
                $query->addOr($c1);
            }
            foreach ($query->find($con) as $relatedVersion) {
                if (isset($loadedObjects['ChildPackageDependancy']) && isset($loadedObjects['ChildPackageDependancy'][$relatedVersion->getId()]) && isset($loadedObjects['ChildPackageDependancy'][$relatedVersion->getId()][$relatedVersion->getVersion()])) {
                    $related = $loadedObjects['ChildPackageDependancy'][$relatedVersion->getId()][$relatedVersion->getVersion()];
                } else {
                    $related = new ChildPackageDependancy();
                    $related->populateFromVersion($relatedVersion, $con, $loadedObjects);
                    $related->setNew(false);
                }
                $this->addPackageDependancyRelatedByRequiredPackageId($related);
                $this->collPackageDependancyRelatedByRequiredPackageIdPartial = false;
            }
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
        $v = ChildPackageVersionQuery::create()
            ->filterByPackage($this)
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
     * @return  ChildPackageVersion A version object
     */
    public function getOneVersion($versionNumber, $con = null)
    {
        return ChildPackageVersionQuery::create()
            ->filterByPackage($this)
            ->filterByVersion($versionNumber)
            ->findOne($con);
    }

    /**
     * Gets all the versions of this object, in incremental order
     *
     * @param   ConnectionInterface $con the connection to use
     *
     * @return  ObjectCollection|ChildPackageVersion[] A list of ChildPackageVersion objects
     */
    public function getAllVersions($con = null)
    {
        $criteria = new Criteria();
        $criteria->addAscendingOrderByColumn(PackageVersionTableMap::COL_VERSION);

        return $this->getPackageVersions($criteria, $con);
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
     * @return PropelCollection|\Packagerator\Model\PackageVersion[] List of \Packagerator\Model\PackageVersion objects
     */
    public function getLastVersions($number = 10, $criteria = null, $con = null)
    {
        $criteria = ChildPackageVersionQuery::create(null, $criteria);
        $criteria->addDescendingOrderByColumn(PackageVersionTableMap::COL_VERSION);
        $criteria->limit($number);

        return $this->getPackageVersions($criteria, $con);
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
