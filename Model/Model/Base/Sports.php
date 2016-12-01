<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\AmbassadorParticipant as ChildAmbassadorParticipant;
use Model\Model\AmbassadorParticipantQuery as ChildAmbassadorParticipantQuery;
use Model\Model\Sports as ChildSports;
use Model\Model\SportsQuery as ChildSportsQuery;
use Model\Model\Sportsteam as ChildSportsteam;
use Model\Model\SportsteamQuery as ChildSportsteamQuery;
use Model\Model\Map\AmbassadorParticipantTableMap;
use Model\Model\Map\SportsTableMap;
use Model\Model\Map\SportsteamTableMap;
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
 * Base class that represents a row from the 'sports' table.
 *
 *
 *
 * @package    propel.generator.Model.Model.Base
 */
abstract class Sports implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Model\\Map\\SportsTableMap';


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
     * The value for the sportid field.
     *
     * @var        int
     */
    protected $sportid;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the feeperparticipant field.
     *
     * @var        int
     */
    protected $feeperparticipant;

    /**
     * The value for the maxparticipants field.
     *
     * @var        int
     */
    protected $maxparticipants;

    /**
     * @var        ObjectCollection|ChildAmbassadorParticipant[] Collection to store aggregation of ChildAmbassadorParticipant objects.
     */
    protected $collAmbassadorParticipants;
    protected $collAmbassadorParticipantsPartial;

    /**
     * @var        ObjectCollection|ChildSportsteam[] Collection to store aggregation of ChildSportsteam objects.
     */
    protected $collSportsteams;
    protected $collSportsteamsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildAmbassadorParticipant[]
     */
    protected $ambassadorParticipantsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSportsteam[]
     */
    protected $sportsteamsScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Model\Base\Sports object.
     */
    public function __construct()
    {
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
     * Compares this with another <code>Sports</code> instance.  If
     * <code>obj</code> is an instance of <code>Sports</code>, delegates to
     * <code>equals(Sports)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Sports The current object, for fluid interface
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
     * Get the [sportid] column value.
     *
     * @return int
     */
    public function getSportid()
    {
        return $this->sportid;
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
     * Get the [feeperparticipant] column value.
     *
     * @return int
     */
    public function getFeeperparticipant()
    {
        return $this->feeperparticipant;
    }

    /**
     * Get the [maxparticipants] column value.
     *
     * @return int
     */
    public function getMaxparticipants()
    {
        return $this->maxparticipants;
    }

    /**
     * Set the value of [sportid] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sports The current object (for fluent API support)
     */
    public function setSportid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sportid !== $v) {
            $this->sportid = $v;
            $this->modifiedColumns[SportsTableMap::COL_SPORTID] = true;
        }

        return $this;
    } // setSportid()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Sports The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[SportsTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [feeperparticipant] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sports The current object (for fluent API support)
     */
    public function setFeeperparticipant($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->feeperparticipant !== $v) {
            $this->feeperparticipant = $v;
            $this->modifiedColumns[SportsTableMap::COL_FEEPERPARTICIPANT] = true;
        }

        return $this;
    } // setFeeperparticipant()

    /**
     * Set the value of [maxparticipants] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sports The current object (for fluent API support)
     */
    public function setMaxparticipants($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->maxparticipants !== $v) {
            $this->maxparticipants = $v;
            $this->modifiedColumns[SportsTableMap::COL_MAXPARTICIPANTS] = true;
        }

        return $this;
    } // setMaxparticipants()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SportsTableMap::translateFieldName('Sportid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sportid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SportsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SportsTableMap::translateFieldName('Feeperparticipant', TableMap::TYPE_PHPNAME, $indexType)];
            $this->feeperparticipant = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SportsTableMap::translateFieldName('Maxparticipants', TableMap::TYPE_PHPNAME, $indexType)];
            $this->maxparticipants = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = SportsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Model\\Sports'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(SportsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSportsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAmbassadorParticipants = null;

            $this->collSportsteams = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Sports::setDeleted()
     * @see Sports::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SportsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSportsQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SportsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
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
                SportsTableMap::addInstanceToPool($this);
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

            if ($this->ambassadorParticipantsScheduledForDeletion !== null) {
                if (!$this->ambassadorParticipantsScheduledForDeletion->isEmpty()) {
                    \Model\Model\AmbassadorParticipantQuery::create()
                        ->filterByPrimaryKeys($this->ambassadorParticipantsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->ambassadorParticipantsScheduledForDeletion = null;
                }
            }

            if ($this->collAmbassadorParticipants !== null) {
                foreach ($this->collAmbassadorParticipants as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->sportsteamsScheduledForDeletion !== null) {
                if (!$this->sportsteamsScheduledForDeletion->isEmpty()) {
                    \Model\Model\SportsteamQuery::create()
                        ->filterByPrimaryKeys($this->sportsteamsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sportsteamsScheduledForDeletion = null;
                }
            }

            if ($this->collSportsteams !== null) {
                foreach ($this->collSportsteams as $referrerFK) {
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

        $this->modifiedColumns[SportsTableMap::COL_SPORTID] = true;
        if (null !== $this->sportid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SportsTableMap::COL_SPORTID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SportsTableMap::COL_SPORTID)) {
            $modifiedColumns[':p' . $index++]  = 'SportID';
        }
        if ($this->isColumnModified(SportsTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'Name';
        }
        if ($this->isColumnModified(SportsTableMap::COL_FEEPERPARTICIPANT)) {
            $modifiedColumns[':p' . $index++]  = 'FeePerParticipant';
        }
        if ($this->isColumnModified(SportsTableMap::COL_MAXPARTICIPANTS)) {
            $modifiedColumns[':p' . $index++]  = 'MaxParticipants';
        }

        $sql = sprintf(
            'INSERT INTO sports (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'SportID':
                        $stmt->bindValue($identifier, $this->sportid, PDO::PARAM_INT);
                        break;
                    case 'Name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'FeePerParticipant':
                        $stmt->bindValue($identifier, $this->feeperparticipant, PDO::PARAM_INT);
                        break;
                    case 'MaxParticipants':
                        $stmt->bindValue($identifier, $this->maxparticipants, PDO::PARAM_INT);
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
        $this->setSportid($pk);

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
        $pos = SportsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getSportid();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getFeeperparticipant();
                break;
            case 3:
                return $this->getMaxparticipants();
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

        if (isset($alreadyDumpedObjects['Sports'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Sports'][$this->hashCode()] = true;
        $keys = SportsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getSportid(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getFeeperparticipant(),
            $keys[3] => $this->getMaxparticipants(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collAmbassadorParticipants) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ambassadorParticipants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ambassador_participants';
                        break;
                    default:
                        $key = 'AmbassadorParticipants';
                }

                $result[$key] = $this->collAmbassadorParticipants->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSportsteams) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sportsteams';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sportsteams';
                        break;
                    default:
                        $key = 'Sportsteams';
                }

                $result[$key] = $this->collSportsteams->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Model\Sports
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SportsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Model\Sports
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setSportid($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setFeeperparticipant($value);
                break;
            case 3:
                $this->setMaxparticipants($value);
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
        $keys = SportsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setSportid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFeeperparticipant($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMaxparticipants($arr[$keys[3]]);
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
     * @return $this|\Model\Model\Sports The current object, for fluid interface
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
        $criteria = new Criteria(SportsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SportsTableMap::COL_SPORTID)) {
            $criteria->add(SportsTableMap::COL_SPORTID, $this->sportid);
        }
        if ($this->isColumnModified(SportsTableMap::COL_NAME)) {
            $criteria->add(SportsTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(SportsTableMap::COL_FEEPERPARTICIPANT)) {
            $criteria->add(SportsTableMap::COL_FEEPERPARTICIPANT, $this->feeperparticipant);
        }
        if ($this->isColumnModified(SportsTableMap::COL_MAXPARTICIPANTS)) {
            $criteria->add(SportsTableMap::COL_MAXPARTICIPANTS, $this->maxparticipants);
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
        $criteria = ChildSportsQuery::create();
        $criteria->add(SportsTableMap::COL_SPORTID, $this->sportid);

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
        $validPk = null !== $this->getSportid();

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
        return $this->getSportid();
    }

    /**
     * Generic method to set the primary key (sportid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setSportid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getSportid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Model\Model\Sports (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setFeeperparticipant($this->getFeeperparticipant());
        $copyObj->setMaxparticipants($this->getMaxparticipants());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAmbassadorParticipants() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAmbassadorParticipant($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSportsteams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSportsteam($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setSportid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Model\Model\Sports Clone of current object.
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
        if ('AmbassadorParticipant' == $relationName) {
            return $this->initAmbassadorParticipants();
        }
        if ('Sportsteam' == $relationName) {
            return $this->initSportsteams();
        }
    }

    /**
     * Clears out the collAmbassadorParticipants collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addAmbassadorParticipants()
     */
    public function clearAmbassadorParticipants()
    {
        $this->collAmbassadorParticipants = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collAmbassadorParticipants collection loaded partially.
     */
    public function resetPartialAmbassadorParticipants($v = true)
    {
        $this->collAmbassadorParticipantsPartial = $v;
    }

    /**
     * Initializes the collAmbassadorParticipants collection.
     *
     * By default this just sets the collAmbassadorParticipants collection to an empty array (like clearcollAmbassadorParticipants());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAmbassadorParticipants($overrideExisting = true)
    {
        if (null !== $this->collAmbassadorParticipants && !$overrideExisting) {
            return;
        }

        $collectionClassName = AmbassadorParticipantTableMap::getTableMap()->getCollectionClassName();

        $this->collAmbassadorParticipants = new $collectionClassName;
        $this->collAmbassadorParticipants->setModel('\Model\Model\AmbassadorParticipant');
    }

    /**
     * Gets an array of ChildAmbassadorParticipant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSports is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildAmbassadorParticipant[] List of ChildAmbassadorParticipant objects
     * @throws PropelException
     */
    public function getAmbassadorParticipants(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collAmbassadorParticipantsPartial && !$this->isNew();
        if (null === $this->collAmbassadorParticipants || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAmbassadorParticipants) {
                // return empty collection
                $this->initAmbassadorParticipants();
            } else {
                $collAmbassadorParticipants = ChildAmbassadorParticipantQuery::create(null, $criteria)
                    ->filterBySports($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collAmbassadorParticipantsPartial && count($collAmbassadorParticipants)) {
                        $this->initAmbassadorParticipants(false);

                        foreach ($collAmbassadorParticipants as $obj) {
                            if (false == $this->collAmbassadorParticipants->contains($obj)) {
                                $this->collAmbassadorParticipants->append($obj);
                            }
                        }

                        $this->collAmbassadorParticipantsPartial = true;
                    }

                    return $collAmbassadorParticipants;
                }

                if ($partial && $this->collAmbassadorParticipants) {
                    foreach ($this->collAmbassadorParticipants as $obj) {
                        if ($obj->isNew()) {
                            $collAmbassadorParticipants[] = $obj;
                        }
                    }
                }

                $this->collAmbassadorParticipants = $collAmbassadorParticipants;
                $this->collAmbassadorParticipantsPartial = false;
            }
        }

        return $this->collAmbassadorParticipants;
    }

    /**
     * Sets a collection of ChildAmbassadorParticipant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $ambassadorParticipants A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSports The current object (for fluent API support)
     */
    public function setAmbassadorParticipants(Collection $ambassadorParticipants, ConnectionInterface $con = null)
    {
        /** @var ChildAmbassadorParticipant[] $ambassadorParticipantsToDelete */
        $ambassadorParticipantsToDelete = $this->getAmbassadorParticipants(new Criteria(), $con)->diff($ambassadorParticipants);


        $this->ambassadorParticipantsScheduledForDeletion = $ambassadorParticipantsToDelete;

        foreach ($ambassadorParticipantsToDelete as $ambassadorParticipantRemoved) {
            $ambassadorParticipantRemoved->setSports(null);
        }

        $this->collAmbassadorParticipants = null;
        foreach ($ambassadorParticipants as $ambassadorParticipant) {
            $this->addAmbassadorParticipant($ambassadorParticipant);
        }

        $this->collAmbassadorParticipants = $ambassadorParticipants;
        $this->collAmbassadorParticipantsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AmbassadorParticipant objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related AmbassadorParticipant objects.
     * @throws PropelException
     */
    public function countAmbassadorParticipants(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collAmbassadorParticipantsPartial && !$this->isNew();
        if (null === $this->collAmbassadorParticipants || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAmbassadorParticipants) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getAmbassadorParticipants());
            }

            $query = ChildAmbassadorParticipantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySports($this)
                ->count($con);
        }

        return count($this->collAmbassadorParticipants);
    }

    /**
     * Method called to associate a ChildAmbassadorParticipant object to this object
     * through the ChildAmbassadorParticipant foreign key attribute.
     *
     * @param  ChildAmbassadorParticipant $l ChildAmbassadorParticipant
     * @return $this|\Model\Model\Sports The current object (for fluent API support)
     */
    public function addAmbassadorParticipant(ChildAmbassadorParticipant $l)
    {
        if ($this->collAmbassadorParticipants === null) {
            $this->initAmbassadorParticipants();
            $this->collAmbassadorParticipantsPartial = true;
        }

        if (!$this->collAmbassadorParticipants->contains($l)) {
            $this->doAddAmbassadorParticipant($l);

            if ($this->ambassadorParticipantsScheduledForDeletion and $this->ambassadorParticipantsScheduledForDeletion->contains($l)) {
                $this->ambassadorParticipantsScheduledForDeletion->remove($this->ambassadorParticipantsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildAmbassadorParticipant $ambassadorParticipant The ChildAmbassadorParticipant object to add.
     */
    protected function doAddAmbassadorParticipant(ChildAmbassadorParticipant $ambassadorParticipant)
    {
        $this->collAmbassadorParticipants[]= $ambassadorParticipant;
        $ambassadorParticipant->setSports($this);
    }

    /**
     * @param  ChildAmbassadorParticipant $ambassadorParticipant The ChildAmbassadorParticipant object to remove.
     * @return $this|ChildSports The current object (for fluent API support)
     */
    public function removeAmbassadorParticipant(ChildAmbassadorParticipant $ambassadorParticipant)
    {
        if ($this->getAmbassadorParticipants()->contains($ambassadorParticipant)) {
            $pos = $this->collAmbassadorParticipants->search($ambassadorParticipant);
            $this->collAmbassadorParticipants->remove($pos);
            if (null === $this->ambassadorParticipantsScheduledForDeletion) {
                $this->ambassadorParticipantsScheduledForDeletion = clone $this->collAmbassadorParticipants;
                $this->ambassadorParticipantsScheduledForDeletion->clear();
            }
            $this->ambassadorParticipantsScheduledForDeletion[]= $ambassadorParticipant;
            $ambassadorParticipant->setSports(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sports is new, it will return
     * an empty collection; or if this Sports has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sports.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAmbassadorParticipant[] List of ChildAmbassadorParticipant objects
     */
    public function getAmbassadorParticipantsJoinEvents(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAmbassadorParticipantQuery::create(null, $criteria);
        $query->joinWith('Events', $joinBehavior);

        return $this->getAmbassadorParticipants($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sports is new, it will return
     * an empty collection; or if this Sports has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sports.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAmbassadorParticipant[] List of ChildAmbassadorParticipant objects
     */
    public function getAmbassadorParticipantsJoinParticipant(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAmbassadorParticipantQuery::create(null, $criteria);
        $query->joinWith('Participant', $joinBehavior);

        return $this->getAmbassadorParticipants($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sports is new, it will return
     * an empty collection; or if this Sports has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sports.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAmbassadorParticipant[] List of ChildAmbassadorParticipant objects
     */
    public function getAmbassadorParticipantsJoinAmbassador(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAmbassadorParticipantQuery::create(null, $criteria);
        $query->joinWith('Ambassador', $joinBehavior);

        return $this->getAmbassadorParticipants($query, $con);
    }

    /**
     * Clears out the collSportsteams collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSportsteams()
     */
    public function clearSportsteams()
    {
        $this->collSportsteams = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSportsteams collection loaded partially.
     */
    public function resetPartialSportsteams($v = true)
    {
        $this->collSportsteamsPartial = $v;
    }

    /**
     * Initializes the collSportsteams collection.
     *
     * By default this just sets the collSportsteams collection to an empty array (like clearcollSportsteams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSportsteams($overrideExisting = true)
    {
        if (null !== $this->collSportsteams && !$overrideExisting) {
            return;
        }

        $collectionClassName = SportsteamTableMap::getTableMap()->getCollectionClassName();

        $this->collSportsteams = new $collectionClassName;
        $this->collSportsteams->setModel('\Model\Model\Sportsteam');
    }

    /**
     * Gets an array of ChildSportsteam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSports is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSportsteam[] List of ChildSportsteam objects
     * @throws PropelException
     */
    public function getSportsteams(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSportsteamsPartial && !$this->isNew();
        if (null === $this->collSportsteams || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSportsteams) {
                // return empty collection
                $this->initSportsteams();
            } else {
                $collSportsteams = ChildSportsteamQuery::create(null, $criteria)
                    ->filterBySports($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSportsteamsPartial && count($collSportsteams)) {
                        $this->initSportsteams(false);

                        foreach ($collSportsteams as $obj) {
                            if (false == $this->collSportsteams->contains($obj)) {
                                $this->collSportsteams->append($obj);
                            }
                        }

                        $this->collSportsteamsPartial = true;
                    }

                    return $collSportsteams;
                }

                if ($partial && $this->collSportsteams) {
                    foreach ($this->collSportsteams as $obj) {
                        if ($obj->isNew()) {
                            $collSportsteams[] = $obj;
                        }
                    }
                }

                $this->collSportsteams = $collSportsteams;
                $this->collSportsteamsPartial = false;
            }
        }

        return $this->collSportsteams;
    }

    /**
     * Sets a collection of ChildSportsteam objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sportsteams A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSports The current object (for fluent API support)
     */
    public function setSportsteams(Collection $sportsteams, ConnectionInterface $con = null)
    {
        /** @var ChildSportsteam[] $sportsteamsToDelete */
        $sportsteamsToDelete = $this->getSportsteams(new Criteria(), $con)->diff($sportsteams);


        $this->sportsteamsScheduledForDeletion = $sportsteamsToDelete;

        foreach ($sportsteamsToDelete as $sportsteamRemoved) {
            $sportsteamRemoved->setSports(null);
        }

        $this->collSportsteams = null;
        foreach ($sportsteams as $sportsteam) {
            $this->addSportsteam($sportsteam);
        }

        $this->collSportsteams = $sportsteams;
        $this->collSportsteamsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Sportsteam objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Sportsteam objects.
     * @throws PropelException
     */
    public function countSportsteams(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSportsteamsPartial && !$this->isNew();
        if (null === $this->collSportsteams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSportsteams) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSportsteams());
            }

            $query = ChildSportsteamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySports($this)
                ->count($con);
        }

        return count($this->collSportsteams);
    }

    /**
     * Method called to associate a ChildSportsteam object to this object
     * through the ChildSportsteam foreign key attribute.
     *
     * @param  ChildSportsteam $l ChildSportsteam
     * @return $this|\Model\Model\Sports The current object (for fluent API support)
     */
    public function addSportsteam(ChildSportsteam $l)
    {
        if ($this->collSportsteams === null) {
            $this->initSportsteams();
            $this->collSportsteamsPartial = true;
        }

        if (!$this->collSportsteams->contains($l)) {
            $this->doAddSportsteam($l);

            if ($this->sportsteamsScheduledForDeletion and $this->sportsteamsScheduledForDeletion->contains($l)) {
                $this->sportsteamsScheduledForDeletion->remove($this->sportsteamsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSportsteam $sportsteam The ChildSportsteam object to add.
     */
    protected function doAddSportsteam(ChildSportsteam $sportsteam)
    {
        $this->collSportsteams[]= $sportsteam;
        $sportsteam->setSports($this);
    }

    /**
     * @param  ChildSportsteam $sportsteam The ChildSportsteam object to remove.
     * @return $this|ChildSports The current object (for fluent API support)
     */
    public function removeSportsteam(ChildSportsteam $sportsteam)
    {
        if ($this->getSportsteams()->contains($sportsteam)) {
            $pos = $this->collSportsteams->search($sportsteam);
            $this->collSportsteams->remove($pos);
            if (null === $this->sportsteamsScheduledForDeletion) {
                $this->sportsteamsScheduledForDeletion = clone $this->collSportsteams;
                $this->sportsteamsScheduledForDeletion->clear();
            }
            $this->sportsteamsScheduledForDeletion[]= clone $sportsteam;
            $sportsteam->setSports(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sports is new, it will return
     * an empty collection; or if this Sports has previously
     * been saved, it will retrieve related Sportsteams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sports.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSportsteam[] List of ChildSportsteam objects
     */
    public function getSportsteamsJoinParticipant(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSportsteamQuery::create(null, $criteria);
        $query->joinWith('Participant', $joinBehavior);

        return $this->getSportsteams($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->sportid = null;
        $this->name = null;
        $this->feeperparticipant = null;
        $this->maxparticipants = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
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
            if ($this->collAmbassadorParticipants) {
                foreach ($this->collAmbassadorParticipants as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSportsteams) {
                foreach ($this->collSportsteams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAmbassadorParticipants = null;
        $this->collSportsteams = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SportsTableMap::DEFAULT_STRING_FORMAT);
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
