<?php

namespace Model\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Model\Model\Challan as ChildChallan;
use Model\Model\ChallanQuery as ChildChallanQuery;
use Model\Model\Participant as ChildParticipant;
use Model\Model\ParticipantQuery as ChildParticipantQuery;
use Model\Model\Map\ChallanTableMap;
use Model\Model\Map\ParticipantTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'challan' table.
 *
 *
 *
 * @package    propel.generator.Model.Model.Base
 */
abstract class Challan implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Model\\Map\\ChallanTableMap';


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
     * The value for the challanid field.
     *
     * @var        string
     */
    protected $challanid;

    /**
     * The value for the amountpayable field.
     *
     * @var        int
     */
    protected $amountpayable;

    /**
     * The value for the duedate field.
     *
     * @var        DateTime
     */
    protected $duedate;

    /**
     * The value for the paymentstatus field.
     *
     * @var        int
     */
    protected $paymentstatus;

    /**
     * @var        ObjectCollection|ChildParticipant[] Collection to store aggregation of ChildParticipant objects.
     */
    protected $collParticipantsRelatedByAccomodationchallanid;
    protected $collParticipantsRelatedByAccomodationchallanidPartial;

    /**
     * @var        ObjectCollection|ChildParticipant[] Collection to store aggregation of ChildParticipant objects.
     */
    protected $collParticipantsRelatedByRegistrationchallanid;
    protected $collParticipantsRelatedByRegistrationchallanidPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParticipant[]
     */
    protected $participantsRelatedByAccomodationchallanidScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildParticipant[]
     */
    protected $participantsRelatedByRegistrationchallanidScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Model\Base\Challan object.
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
     * Compares this with another <code>Challan</code> instance.  If
     * <code>obj</code> is an instance of <code>Challan</code>, delegates to
     * <code>equals(Challan)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Challan The current object, for fluid interface
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
     * Get the [challanid] column value.
     *
     * @return string
     */
    public function getChallanid()
    {
        return $this->challanid;
    }

    /**
     * Get the [amountpayable] column value.
     *
     * @return int
     */
    public function getAmountpayable()
    {
        return $this->amountpayable;
    }

    /**
     * Get the [optionally formatted] temporal [duedate] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDuedate($format = NULL)
    {
        if ($format === null) {
            return $this->duedate;
        } else {
            return $this->duedate instanceof \DateTimeInterface ? $this->duedate->format($format) : null;
        }
    }

    /**
     * Get the [paymentstatus] column value.
     *
     * @return int
     */
    public function getPaymentstatus()
    {
        return $this->paymentstatus;
    }

    /**
     * Set the value of [challanid] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Challan The current object (for fluent API support)
     */
    public function setChallanid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->challanid !== $v) {
            $this->challanid = $v;
            $this->modifiedColumns[ChallanTableMap::COL_CHALLANID] = true;
        }

        return $this;
    } // setChallanid()

    /**
     * Set the value of [amountpayable] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Challan The current object (for fluent API support)
     */
    public function setAmountpayable($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->amountpayable !== $v) {
            $this->amountpayable = $v;
            $this->modifiedColumns[ChallanTableMap::COL_AMOUNTPAYABLE] = true;
        }

        return $this;
    } // setAmountpayable()

    /**
     * Sets the value of [duedate] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Model\Model\Challan The current object (for fluent API support)
     */
    public function setDuedate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->duedate !== null || $dt !== null) {
            if ($this->duedate === null || $dt === null || $dt->format("Y-m-d") !== $this->duedate->format("Y-m-d")) {
                $this->duedate = $dt === null ? null : clone $dt;
                $this->modifiedColumns[ChallanTableMap::COL_DUEDATE] = true;
            }
        } // if either are not null

        return $this;
    } // setDuedate()

    /**
     * Set the value of [paymentstatus] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Challan The current object (for fluent API support)
     */
    public function setPaymentstatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->paymentstatus !== $v) {
            $this->paymentstatus = $v;
            $this->modifiedColumns[ChallanTableMap::COL_PAYMENTSTATUS] = true;
        }

        return $this;
    } // setPaymentstatus()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ChallanTableMap::translateFieldName('Challanid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->challanid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ChallanTableMap::translateFieldName('Amountpayable', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amountpayable = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ChallanTableMap::translateFieldName('Duedate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->duedate = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ChallanTableMap::translateFieldName('Paymentstatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->paymentstatus = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 4; // 4 = ChallanTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Model\\Challan'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(ChallanTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildChallanQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collParticipantsRelatedByAccomodationchallanid = null;

            $this->collParticipantsRelatedByRegistrationchallanid = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Challan::setDeleted()
     * @see Challan::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChallanTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildChallanQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ChallanTableMap::DATABASE_NAME);
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
                ChallanTableMap::addInstanceToPool($this);
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

            if ($this->participantsRelatedByAccomodationchallanidScheduledForDeletion !== null) {
                if (!$this->participantsRelatedByAccomodationchallanidScheduledForDeletion->isEmpty()) {
                    foreach ($this->participantsRelatedByAccomodationchallanidScheduledForDeletion as $participantRelatedByAccomodationchallanid) {
                        // need to save related object because we set the relation to null
                        $participantRelatedByAccomodationchallanid->save($con);
                    }
                    $this->participantsRelatedByAccomodationchallanidScheduledForDeletion = null;
                }
            }

            if ($this->collParticipantsRelatedByAccomodationchallanid !== null) {
                foreach ($this->collParticipantsRelatedByAccomodationchallanid as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->participantsRelatedByRegistrationchallanidScheduledForDeletion !== null) {
                if (!$this->participantsRelatedByRegistrationchallanidScheduledForDeletion->isEmpty()) {
                    \Model\Model\ParticipantQuery::create()
                        ->filterByPrimaryKeys($this->participantsRelatedByRegistrationchallanidScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->participantsRelatedByRegistrationchallanidScheduledForDeletion = null;
                }
            }

            if ($this->collParticipantsRelatedByRegistrationchallanid !== null) {
                foreach ($this->collParticipantsRelatedByRegistrationchallanid as $referrerFK) {
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


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ChallanTableMap::COL_CHALLANID)) {
            $modifiedColumns[':p' . $index++]  = 'ChallanID';
        }
        if ($this->isColumnModified(ChallanTableMap::COL_AMOUNTPAYABLE)) {
            $modifiedColumns[':p' . $index++]  = 'AmountPayable';
        }
        if ($this->isColumnModified(ChallanTableMap::COL_DUEDATE)) {
            $modifiedColumns[':p' . $index++]  = 'DueDate';
        }
        if ($this->isColumnModified(ChallanTableMap::COL_PAYMENTSTATUS)) {
            $modifiedColumns[':p' . $index++]  = 'PaymentStatus';
        }

        $sql = sprintf(
            'INSERT INTO challan (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ChallanID':
                        $stmt->bindValue($identifier, $this->challanid, PDO::PARAM_STR);
                        break;
                    case 'AmountPayable':
                        $stmt->bindValue($identifier, $this->amountpayable, PDO::PARAM_INT);
                        break;
                    case 'DueDate':
                        $stmt->bindValue($identifier, $this->duedate ? $this->duedate->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'PaymentStatus':
                        $stmt->bindValue($identifier, $this->paymentstatus, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

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
        $pos = ChallanTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getChallanid();
                break;
            case 1:
                return $this->getAmountpayable();
                break;
            case 2:
                return $this->getDuedate();
                break;
            case 3:
                return $this->getPaymentstatus();
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

        if (isset($alreadyDumpedObjects['Challan'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Challan'][$this->hashCode()] = true;
        $keys = ChallanTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getChallanid(),
            $keys[1] => $this->getAmountpayable(),
            $keys[2] => $this->getDuedate(),
            $keys[3] => $this->getPaymentstatus(),
        );
        if ($result[$keys[2]] instanceof \DateTime) {
            $result[$keys[2]] = $result[$keys[2]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collParticipantsRelatedByAccomodationchallanid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'participants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'participants';
                        break;
                    default:
                        $key = 'Participants';
                }

                $result[$key] = $this->collParticipantsRelatedByAccomodationchallanid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collParticipantsRelatedByRegistrationchallanid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'participants';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'participants';
                        break;
                    default:
                        $key = 'Participants';
                }

                $result[$key] = $this->collParticipantsRelatedByRegistrationchallanid->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Model\Challan
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ChallanTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Model\Challan
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setChallanid($value);
                break;
            case 1:
                $this->setAmountpayable($value);
                break;
            case 2:
                $this->setDuedate($value);
                break;
            case 3:
                $this->setPaymentstatus($value);
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
        $keys = ChallanTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setChallanid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setAmountpayable($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDuedate($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setPaymentstatus($arr[$keys[3]]);
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
     * @return $this|\Model\Model\Challan The current object, for fluid interface
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
        $criteria = new Criteria(ChallanTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ChallanTableMap::COL_CHALLANID)) {
            $criteria->add(ChallanTableMap::COL_CHALLANID, $this->challanid);
        }
        if ($this->isColumnModified(ChallanTableMap::COL_AMOUNTPAYABLE)) {
            $criteria->add(ChallanTableMap::COL_AMOUNTPAYABLE, $this->amountpayable);
        }
        if ($this->isColumnModified(ChallanTableMap::COL_DUEDATE)) {
            $criteria->add(ChallanTableMap::COL_DUEDATE, $this->duedate);
        }
        if ($this->isColumnModified(ChallanTableMap::COL_PAYMENTSTATUS)) {
            $criteria->add(ChallanTableMap::COL_PAYMENTSTATUS, $this->paymentstatus);
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
        $criteria = ChildChallanQuery::create();
        $criteria->add(ChallanTableMap::COL_CHALLANID, $this->challanid);

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
        $validPk = null !== $this->getChallanid();

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
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getChallanid();
    }

    /**
     * Generic method to set the primary key (challanid column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setChallanid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getChallanid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Model\Model\Challan (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setChallanid($this->getChallanid());
        $copyObj->setAmountpayable($this->getAmountpayable());
        $copyObj->setDuedate($this->getDuedate());
        $copyObj->setPaymentstatus($this->getPaymentstatus());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getParticipantsRelatedByAccomodationchallanid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipantRelatedByAccomodationchallanid($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getParticipantsRelatedByRegistrationchallanid() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipantRelatedByRegistrationchallanid($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
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
     * @return \Model\Model\Challan Clone of current object.
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
        if ('ParticipantRelatedByAccomodationchallanid' == $relationName) {
            return $this->initParticipantsRelatedByAccomodationchallanid();
        }
        if ('ParticipantRelatedByRegistrationchallanid' == $relationName) {
            return $this->initParticipantsRelatedByRegistrationchallanid();
        }
    }

    /**
     * Clears out the collParticipantsRelatedByAccomodationchallanid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParticipantsRelatedByAccomodationchallanid()
     */
    public function clearParticipantsRelatedByAccomodationchallanid()
    {
        $this->collParticipantsRelatedByAccomodationchallanid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParticipantsRelatedByAccomodationchallanid collection loaded partially.
     */
    public function resetPartialParticipantsRelatedByAccomodationchallanid($v = true)
    {
        $this->collParticipantsRelatedByAccomodationchallanidPartial = $v;
    }

    /**
     * Initializes the collParticipantsRelatedByAccomodationchallanid collection.
     *
     * By default this just sets the collParticipantsRelatedByAccomodationchallanid collection to an empty array (like clearcollParticipantsRelatedByAccomodationchallanid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParticipantsRelatedByAccomodationchallanid($overrideExisting = true)
    {
        if (null !== $this->collParticipantsRelatedByAccomodationchallanid && !$overrideExisting) {
            return;
        }

        $collectionClassName = ParticipantTableMap::getTableMap()->getCollectionClassName();

        $this->collParticipantsRelatedByAccomodationchallanid = new $collectionClassName;
        $this->collParticipantsRelatedByAccomodationchallanid->setModel('\Model\Model\Participant');
    }

    /**
     * Gets an array of ChildParticipant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChallan is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     * @throws PropelException
     */
    public function getParticipantsRelatedByAccomodationchallanid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantsRelatedByAccomodationchallanidPartial && !$this->isNew();
        if (null === $this->collParticipantsRelatedByAccomodationchallanid || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParticipantsRelatedByAccomodationchallanid) {
                // return empty collection
                $this->initParticipantsRelatedByAccomodationchallanid();
            } else {
                $collParticipantsRelatedByAccomodationchallanid = ChildParticipantQuery::create(null, $criteria)
                    ->filterByChallanRelatedByAccomodationchallanid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParticipantsRelatedByAccomodationchallanidPartial && count($collParticipantsRelatedByAccomodationchallanid)) {
                        $this->initParticipantsRelatedByAccomodationchallanid(false);

                        foreach ($collParticipantsRelatedByAccomodationchallanid as $obj) {
                            if (false == $this->collParticipantsRelatedByAccomodationchallanid->contains($obj)) {
                                $this->collParticipantsRelatedByAccomodationchallanid->append($obj);
                            }
                        }

                        $this->collParticipantsRelatedByAccomodationchallanidPartial = true;
                    }

                    return $collParticipantsRelatedByAccomodationchallanid;
                }

                if ($partial && $this->collParticipantsRelatedByAccomodationchallanid) {
                    foreach ($this->collParticipantsRelatedByAccomodationchallanid as $obj) {
                        if ($obj->isNew()) {
                            $collParticipantsRelatedByAccomodationchallanid[] = $obj;
                        }
                    }
                }

                $this->collParticipantsRelatedByAccomodationchallanid = $collParticipantsRelatedByAccomodationchallanid;
                $this->collParticipantsRelatedByAccomodationchallanidPartial = false;
            }
        }

        return $this->collParticipantsRelatedByAccomodationchallanid;
    }

    /**
     * Sets a collection of ChildParticipant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $participantsRelatedByAccomodationchallanid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildChallan The current object (for fluent API support)
     */
    public function setParticipantsRelatedByAccomodationchallanid(Collection $participantsRelatedByAccomodationchallanid, ConnectionInterface $con = null)
    {
        /** @var ChildParticipant[] $participantsRelatedByAccomodationchallanidToDelete */
        $participantsRelatedByAccomodationchallanidToDelete = $this->getParticipantsRelatedByAccomodationchallanid(new Criteria(), $con)->diff($participantsRelatedByAccomodationchallanid);


        $this->participantsRelatedByAccomodationchallanidScheduledForDeletion = $participantsRelatedByAccomodationchallanidToDelete;

        foreach ($participantsRelatedByAccomodationchallanidToDelete as $participantRelatedByAccomodationchallanidRemoved) {
            $participantRelatedByAccomodationchallanidRemoved->setChallanRelatedByAccomodationchallanid(null);
        }

        $this->collParticipantsRelatedByAccomodationchallanid = null;
        foreach ($participantsRelatedByAccomodationchallanid as $participantRelatedByAccomodationchallanid) {
            $this->addParticipantRelatedByAccomodationchallanid($participantRelatedByAccomodationchallanid);
        }

        $this->collParticipantsRelatedByAccomodationchallanid = $participantsRelatedByAccomodationchallanid;
        $this->collParticipantsRelatedByAccomodationchallanidPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Participant objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Participant objects.
     * @throws PropelException
     */
    public function countParticipantsRelatedByAccomodationchallanid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantsRelatedByAccomodationchallanidPartial && !$this->isNew();
        if (null === $this->collParticipantsRelatedByAccomodationchallanid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipantsRelatedByAccomodationchallanid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParticipantsRelatedByAccomodationchallanid());
            }

            $query = ChildParticipantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChallanRelatedByAccomodationchallanid($this)
                ->count($con);
        }

        return count($this->collParticipantsRelatedByAccomodationchallanid);
    }

    /**
     * Method called to associate a ChildParticipant object to this object
     * through the ChildParticipant foreign key attribute.
     *
     * @param  ChildParticipant $l ChildParticipant
     * @return $this|\Model\Model\Challan The current object (for fluent API support)
     */
    public function addParticipantRelatedByAccomodationchallanid(ChildParticipant $l)
    {
        if ($this->collParticipantsRelatedByAccomodationchallanid === null) {
            $this->initParticipantsRelatedByAccomodationchallanid();
            $this->collParticipantsRelatedByAccomodationchallanidPartial = true;
        }

        if (!$this->collParticipantsRelatedByAccomodationchallanid->contains($l)) {
            $this->doAddParticipantRelatedByAccomodationchallanid($l);

            if ($this->participantsRelatedByAccomodationchallanidScheduledForDeletion and $this->participantsRelatedByAccomodationchallanidScheduledForDeletion->contains($l)) {
                $this->participantsRelatedByAccomodationchallanidScheduledForDeletion->remove($this->participantsRelatedByAccomodationchallanidScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildParticipant $participantRelatedByAccomodationchallanid The ChildParticipant object to add.
     */
    protected function doAddParticipantRelatedByAccomodationchallanid(ChildParticipant $participantRelatedByAccomodationchallanid)
    {
        $this->collParticipantsRelatedByAccomodationchallanid[]= $participantRelatedByAccomodationchallanid;
        $participantRelatedByAccomodationchallanid->setChallanRelatedByAccomodationchallanid($this);
    }

    /**
     * @param  ChildParticipant $participantRelatedByAccomodationchallanid The ChildParticipant object to remove.
     * @return $this|ChildChallan The current object (for fluent API support)
     */
    public function removeParticipantRelatedByAccomodationchallanid(ChildParticipant $participantRelatedByAccomodationchallanid)
    {
        if ($this->getParticipantsRelatedByAccomodationchallanid()->contains($participantRelatedByAccomodationchallanid)) {
            $pos = $this->collParticipantsRelatedByAccomodationchallanid->search($participantRelatedByAccomodationchallanid);
            $this->collParticipantsRelatedByAccomodationchallanid->remove($pos);
            if (null === $this->participantsRelatedByAccomodationchallanidScheduledForDeletion) {
                $this->participantsRelatedByAccomodationchallanidScheduledForDeletion = clone $this->collParticipantsRelatedByAccomodationchallanid;
                $this->participantsRelatedByAccomodationchallanidScheduledForDeletion->clear();
            }
            $this->participantsRelatedByAccomodationchallanidScheduledForDeletion[]= $participantRelatedByAccomodationchallanid;
            $participantRelatedByAccomodationchallanid->setChallanRelatedByAccomodationchallanid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Challan is new, it will return
     * an empty collection; or if this Challan has previously
     * been saved, it will retrieve related ParticipantsRelatedByAccomodationchallanid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Challan.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     */
    public function getParticipantsRelatedByAccomodationchallanidJoinAmbassador(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParticipantQuery::create(null, $criteria);
        $query->joinWith('Ambassador', $joinBehavior);

        return $this->getParticipantsRelatedByAccomodationchallanid($query, $con);
    }

    /**
     * Clears out the collParticipantsRelatedByRegistrationchallanid collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParticipantsRelatedByRegistrationchallanid()
     */
    public function clearParticipantsRelatedByRegistrationchallanid()
    {
        $this->collParticipantsRelatedByRegistrationchallanid = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParticipantsRelatedByRegistrationchallanid collection loaded partially.
     */
    public function resetPartialParticipantsRelatedByRegistrationchallanid($v = true)
    {
        $this->collParticipantsRelatedByRegistrationchallanidPartial = $v;
    }

    /**
     * Initializes the collParticipantsRelatedByRegistrationchallanid collection.
     *
     * By default this just sets the collParticipantsRelatedByRegistrationchallanid collection to an empty array (like clearcollParticipantsRelatedByRegistrationchallanid());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParticipantsRelatedByRegistrationchallanid($overrideExisting = true)
    {
        if (null !== $this->collParticipantsRelatedByRegistrationchallanid && !$overrideExisting) {
            return;
        }

        $collectionClassName = ParticipantTableMap::getTableMap()->getCollectionClassName();

        $this->collParticipantsRelatedByRegistrationchallanid = new $collectionClassName;
        $this->collParticipantsRelatedByRegistrationchallanid->setModel('\Model\Model\Participant');
    }

    /**
     * Gets an array of ChildParticipant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildChallan is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     * @throws PropelException
     */
    public function getParticipantsRelatedByRegistrationchallanid(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantsRelatedByRegistrationchallanidPartial && !$this->isNew();
        if (null === $this->collParticipantsRelatedByRegistrationchallanid || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParticipantsRelatedByRegistrationchallanid) {
                // return empty collection
                $this->initParticipantsRelatedByRegistrationchallanid();
            } else {
                $collParticipantsRelatedByRegistrationchallanid = ChildParticipantQuery::create(null, $criteria)
                    ->filterByChallanRelatedByRegistrationchallanid($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParticipantsRelatedByRegistrationchallanidPartial && count($collParticipantsRelatedByRegistrationchallanid)) {
                        $this->initParticipantsRelatedByRegistrationchallanid(false);

                        foreach ($collParticipantsRelatedByRegistrationchallanid as $obj) {
                            if (false == $this->collParticipantsRelatedByRegistrationchallanid->contains($obj)) {
                                $this->collParticipantsRelatedByRegistrationchallanid->append($obj);
                            }
                        }

                        $this->collParticipantsRelatedByRegistrationchallanidPartial = true;
                    }

                    return $collParticipantsRelatedByRegistrationchallanid;
                }

                if ($partial && $this->collParticipantsRelatedByRegistrationchallanid) {
                    foreach ($this->collParticipantsRelatedByRegistrationchallanid as $obj) {
                        if ($obj->isNew()) {
                            $collParticipantsRelatedByRegistrationchallanid[] = $obj;
                        }
                    }
                }

                $this->collParticipantsRelatedByRegistrationchallanid = $collParticipantsRelatedByRegistrationchallanid;
                $this->collParticipantsRelatedByRegistrationchallanidPartial = false;
            }
        }

        return $this->collParticipantsRelatedByRegistrationchallanid;
    }

    /**
     * Sets a collection of ChildParticipant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $participantsRelatedByRegistrationchallanid A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildChallan The current object (for fluent API support)
     */
    public function setParticipantsRelatedByRegistrationchallanid(Collection $participantsRelatedByRegistrationchallanid, ConnectionInterface $con = null)
    {
        /** @var ChildParticipant[] $participantsRelatedByRegistrationchallanidToDelete */
        $participantsRelatedByRegistrationchallanidToDelete = $this->getParticipantsRelatedByRegistrationchallanid(new Criteria(), $con)->diff($participantsRelatedByRegistrationchallanid);


        $this->participantsRelatedByRegistrationchallanidScheduledForDeletion = $participantsRelatedByRegistrationchallanidToDelete;

        foreach ($participantsRelatedByRegistrationchallanidToDelete as $participantRelatedByRegistrationchallanidRemoved) {
            $participantRelatedByRegistrationchallanidRemoved->setChallanRelatedByRegistrationchallanid(null);
        }

        $this->collParticipantsRelatedByRegistrationchallanid = null;
        foreach ($participantsRelatedByRegistrationchallanid as $participantRelatedByRegistrationchallanid) {
            $this->addParticipantRelatedByRegistrationchallanid($participantRelatedByRegistrationchallanid);
        }

        $this->collParticipantsRelatedByRegistrationchallanid = $participantsRelatedByRegistrationchallanid;
        $this->collParticipantsRelatedByRegistrationchallanidPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Participant objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Participant objects.
     * @throws PropelException
     */
    public function countParticipantsRelatedByRegistrationchallanid(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantsRelatedByRegistrationchallanidPartial && !$this->isNew();
        if (null === $this->collParticipantsRelatedByRegistrationchallanid || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipantsRelatedByRegistrationchallanid) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParticipantsRelatedByRegistrationchallanid());
            }

            $query = ChildParticipantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChallanRelatedByRegistrationchallanid($this)
                ->count($con);
        }

        return count($this->collParticipantsRelatedByRegistrationchallanid);
    }

    /**
     * Method called to associate a ChildParticipant object to this object
     * through the ChildParticipant foreign key attribute.
     *
     * @param  ChildParticipant $l ChildParticipant
     * @return $this|\Model\Model\Challan The current object (for fluent API support)
     */
    public function addParticipantRelatedByRegistrationchallanid(ChildParticipant $l)
    {
        if ($this->collParticipantsRelatedByRegistrationchallanid === null) {
            $this->initParticipantsRelatedByRegistrationchallanid();
            $this->collParticipantsRelatedByRegistrationchallanidPartial = true;
        }

        if (!$this->collParticipantsRelatedByRegistrationchallanid->contains($l)) {
            $this->doAddParticipantRelatedByRegistrationchallanid($l);

            if ($this->participantsRelatedByRegistrationchallanidScheduledForDeletion and $this->participantsRelatedByRegistrationchallanidScheduledForDeletion->contains($l)) {
                $this->participantsRelatedByRegistrationchallanidScheduledForDeletion->remove($this->participantsRelatedByRegistrationchallanidScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildParticipant $participantRelatedByRegistrationchallanid The ChildParticipant object to add.
     */
    protected function doAddParticipantRelatedByRegistrationchallanid(ChildParticipant $participantRelatedByRegistrationchallanid)
    {
        $this->collParticipantsRelatedByRegistrationchallanid[]= $participantRelatedByRegistrationchallanid;
        $participantRelatedByRegistrationchallanid->setChallanRelatedByRegistrationchallanid($this);
    }

    /**
     * @param  ChildParticipant $participantRelatedByRegistrationchallanid The ChildParticipant object to remove.
     * @return $this|ChildChallan The current object (for fluent API support)
     */
    public function removeParticipantRelatedByRegistrationchallanid(ChildParticipant $participantRelatedByRegistrationchallanid)
    {
        if ($this->getParticipantsRelatedByRegistrationchallanid()->contains($participantRelatedByRegistrationchallanid)) {
            $pos = $this->collParticipantsRelatedByRegistrationchallanid->search($participantRelatedByRegistrationchallanid);
            $this->collParticipantsRelatedByRegistrationchallanid->remove($pos);
            if (null === $this->participantsRelatedByRegistrationchallanidScheduledForDeletion) {
                $this->participantsRelatedByRegistrationchallanidScheduledForDeletion = clone $this->collParticipantsRelatedByRegistrationchallanid;
                $this->participantsRelatedByRegistrationchallanidScheduledForDeletion->clear();
            }
            $this->participantsRelatedByRegistrationchallanidScheduledForDeletion[]= clone $participantRelatedByRegistrationchallanid;
            $participantRelatedByRegistrationchallanid->setChallanRelatedByRegistrationchallanid(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Challan is new, it will return
     * an empty collection; or if this Challan has previously
     * been saved, it will retrieve related ParticipantsRelatedByRegistrationchallanid from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Challan.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     */
    public function getParticipantsRelatedByRegistrationchallanidJoinAmbassador(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParticipantQuery::create(null, $criteria);
        $query->joinWith('Ambassador', $joinBehavior);

        return $this->getParticipantsRelatedByRegistrationchallanid($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->challanid = null;
        $this->amountpayable = null;
        $this->duedate = null;
        $this->paymentstatus = null;
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
            if ($this->collParticipantsRelatedByAccomodationchallanid) {
                foreach ($this->collParticipantsRelatedByAccomodationchallanid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collParticipantsRelatedByRegistrationchallanid) {
                foreach ($this->collParticipantsRelatedByRegistrationchallanid as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collParticipantsRelatedByAccomodationchallanid = null;
        $this->collParticipantsRelatedByRegistrationchallanid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ChallanTableMap::DEFAULT_STRING_FORMAT);
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