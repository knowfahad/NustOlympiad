<?php

namespace Model\Model\Base;

use \DateTime;
use \Exception;
use \PDO;
use Model\Model\Participant as ChildParticipant;
use Model\Model\ParticipantQuery as ChildParticipantQuery;
use Model\Model\Sports as ChildSports;
use Model\Model\SportsQuery as ChildSportsQuery;
use Model\Model\Sportsparticipants as ChildSportsparticipants;
use Model\Model\SportsparticipantsQuery as ChildSportsparticipantsQuery;
use Model\Model\Sportsteam as ChildSportsteam;
use Model\Model\SportsteamQuery as ChildSportsteamQuery;
use Model\Model\Map\SportsparticipantsTableMap;
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
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'sportsteam' table.
 *
 *
 *
 * @package    propel.generator.Model.Model.Base
 */
abstract class Sportsteam implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Model\\Map\\SportsteamTableMap';


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
     * The value for the teamid field.
     *
     * @var        int
     */
    protected $teamid;

    /**
     * The value for the sportid field.
     *
     * @var        int
     */
    protected $sportid;

    /**
     * The value for the teamname field.
     *
     * @var        string
     */
    protected $teamname;

    /**
     * The value for the headcnic field.
     *
     * @var        string
     */
    protected $headcnic;

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
     * The value for the duedata field.
     *
     * @var        DateTime
     */
    protected $duedata;

    /**
     * The value for the paymentstatus field.
     *
     * @var        int
     */
    protected $paymentstatus;

    /**
     * @var        ChildSports
     */
    protected $aSports;

    /**
     * @var        ChildParticipant
     */
    protected $aParticipant;

    /**
     * @var        ObjectCollection|ChildSportsparticipants[] Collection to store aggregation of ChildSportsparticipants objects.
     */
    protected $collSportsparticipantss;
    protected $collSportsparticipantssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSportsparticipants[]
     */
    protected $sportsparticipantssScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Model\Base\Sportsteam object.
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
     * Compares this with another <code>Sportsteam</code> instance.  If
     * <code>obj</code> is an instance of <code>Sportsteam</code>, delegates to
     * <code>equals(Sportsteam)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Sportsteam The current object, for fluid interface
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
     * Get the [teamid] column value.
     *
     * @return int
     */
    public function getTeamid()
    {
        return $this->teamid;
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
     * Get the [teamname] column value.
     *
     * @return string
     */
    public function getTeamname()
    {
        return $this->teamname;
    }

    /**
     * Get the [headcnic] column value.
     *
     * @return string
     */
    public function getHeadcnic()
    {
        return $this->headcnic;
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
     * Get the [optionally formatted] temporal [duedata] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDuedata($format = NULL)
    {
        if ($format === null) {
            return $this->duedata;
        } else {
            return $this->duedata instanceof \DateTimeInterface ? $this->duedata->format($format) : null;
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
     * Set the value of [teamid] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setTeamid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->teamid !== $v) {
            $this->teamid = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_TEAMID] = true;
        }

        return $this;
    } // setTeamid()

    /**
     * Set the value of [sportid] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setSportid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->sportid !== $v) {
            $this->sportid = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_SPORTID] = true;
        }

        if ($this->aSports !== null && $this->aSports->getSportid() !== $v) {
            $this->aSports = null;
        }

        return $this;
    } // setSportid()

    /**
     * Set the value of [teamname] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setTeamname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->teamname !== $v) {
            $this->teamname = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_TEAMNAME] = true;
        }

        return $this;
    } // setTeamname()

    /**
     * Set the value of [headcnic] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setHeadcnic($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->headcnic !== $v) {
            $this->headcnic = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_HEADCNIC] = true;
        }

        if ($this->aParticipant !== null && $this->aParticipant->getCnic() !== $v) {
            $this->aParticipant = null;
        }

        return $this;
    } // setHeadcnic()

    /**
     * Set the value of [challanid] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setChallanid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->challanid !== $v) {
            $this->challanid = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_CHALLANID] = true;
        }

        return $this;
    } // setChallanid()

    /**
     * Set the value of [amountpayable] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setAmountpayable($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->amountpayable !== $v) {
            $this->amountpayable = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_AMOUNTPAYABLE] = true;
        }

        return $this;
    } // setAmountpayable()

    /**
     * Sets the value of [duedata] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setDuedata($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->duedata !== null || $dt !== null) {
            if ($this->duedata === null || $dt === null || $dt->format("Y-m-d") !== $this->duedata->format("Y-m-d")) {
                $this->duedata = $dt === null ? null : clone $dt;
                $this->modifiedColumns[SportsteamTableMap::COL_DUEDATA] = true;
            }
        } // if either are not null

        return $this;
    } // setDuedata()

    /**
     * Set the value of [paymentstatus] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function setPaymentstatus($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->paymentstatus !== $v) {
            $this->paymentstatus = $v;
            $this->modifiedColumns[SportsteamTableMap::COL_PAYMENTSTATUS] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : SportsteamTableMap::translateFieldName('Teamid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->teamid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : SportsteamTableMap::translateFieldName('Sportid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->sportid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : SportsteamTableMap::translateFieldName('Teamname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->teamname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : SportsteamTableMap::translateFieldName('Headcnic', TableMap::TYPE_PHPNAME, $indexType)];
            $this->headcnic = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : SportsteamTableMap::translateFieldName('Challanid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->challanid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : SportsteamTableMap::translateFieldName('Amountpayable', TableMap::TYPE_PHPNAME, $indexType)];
            $this->amountpayable = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : SportsteamTableMap::translateFieldName('Duedata', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->duedata = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : SportsteamTableMap::translateFieldName('Paymentstatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->paymentstatus = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = SportsteamTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Model\\Sportsteam'), 0, $e);
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
        if ($this->aSports !== null && $this->sportid !== $this->aSports->getSportid()) {
            $this->aSports = null;
        }
        if ($this->aParticipant !== null && $this->headcnic !== $this->aParticipant->getCnic()) {
            $this->aParticipant = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(SportsteamTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildSportsteamQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aSports = null;
            $this->aParticipant = null;
            $this->collSportsparticipantss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Sportsteam::setDeleted()
     * @see Sportsteam::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(SportsteamTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildSportsteamQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(SportsteamTableMap::DATABASE_NAME);
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
                SportsteamTableMap::addInstanceToPool($this);
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

            if ($this->aSports !== null) {
                if ($this->aSports->isModified() || $this->aSports->isNew()) {
                    $affectedRows += $this->aSports->save($con);
                }
                $this->setSports($this->aSports);
            }

            if ($this->aParticipant !== null) {
                if ($this->aParticipant->isModified() || $this->aParticipant->isNew()) {
                    $affectedRows += $this->aParticipant->save($con);
                }
                $this->setParticipant($this->aParticipant);
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

            if ($this->sportsparticipantssScheduledForDeletion !== null) {
                if (!$this->sportsparticipantssScheduledForDeletion->isEmpty()) {
                    \Model\Model\SportsparticipantsQuery::create()
                        ->filterByPrimaryKeys($this->sportsparticipantssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->sportsparticipantssScheduledForDeletion = null;
                }
            }

            if ($this->collSportsparticipantss !== null) {
                foreach ($this->collSportsparticipantss as $referrerFK) {
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

        $this->modifiedColumns[SportsteamTableMap::COL_TEAMID] = true;
        if (null !== $this->teamid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . SportsteamTableMap::COL_TEAMID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SportsteamTableMap::COL_TEAMID)) {
            $modifiedColumns[':p' . $index++]  = 'TeamID';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_SPORTID)) {
            $modifiedColumns[':p' . $index++]  = 'SportID';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_TEAMNAME)) {
            $modifiedColumns[':p' . $index++]  = 'TeamName';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_HEADCNIC)) {
            $modifiedColumns[':p' . $index++]  = 'HeadCNIC';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_CHALLANID)) {
            $modifiedColumns[':p' . $index++]  = 'ChallanID';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_AMOUNTPAYABLE)) {
            $modifiedColumns[':p' . $index++]  = 'AmountPayable';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_DUEDATA)) {
            $modifiedColumns[':p' . $index++]  = 'DueData';
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_PAYMENTSTATUS)) {
            $modifiedColumns[':p' . $index++]  = 'PaymentStatus';
        }

        $sql = sprintf(
            'INSERT INTO sportsteam (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'TeamID':
                        $stmt->bindValue($identifier, $this->teamid, PDO::PARAM_INT);
                        break;
                    case 'SportID':
                        $stmt->bindValue($identifier, $this->sportid, PDO::PARAM_INT);
                        break;
                    case 'TeamName':
                        $stmt->bindValue($identifier, $this->teamname, PDO::PARAM_STR);
                        break;
                    case 'HeadCNIC':
                        $stmt->bindValue($identifier, $this->headcnic, PDO::PARAM_STR);
                        break;
                    case 'ChallanID':
                        $stmt->bindValue($identifier, $this->challanid, PDO::PARAM_STR);
                        break;
                    case 'AmountPayable':
                        $stmt->bindValue($identifier, $this->amountpayable, PDO::PARAM_INT);
                        break;
                    case 'DueData':
                        $stmt->bindValue($identifier, $this->duedata ? $this->duedata->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
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

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setTeamid($pk);

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
        $pos = SportsteamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getTeamid();
                break;
            case 1:
                return $this->getSportid();
                break;
            case 2:
                return $this->getTeamname();
                break;
            case 3:
                return $this->getHeadcnic();
                break;
            case 4:
                return $this->getChallanid();
                break;
            case 5:
                return $this->getAmountpayable();
                break;
            case 6:
                return $this->getDuedata();
                break;
            case 7:
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

        if (isset($alreadyDumpedObjects['Sportsteam'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Sportsteam'][$this->hashCode()] = true;
        $keys = SportsteamTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getTeamid(),
            $keys[1] => $this->getSportid(),
            $keys[2] => $this->getTeamname(),
            $keys[3] => $this->getHeadcnic(),
            $keys[4] => $this->getChallanid(),
            $keys[5] => $this->getAmountpayable(),
            $keys[6] => $this->getDuedata(),
            $keys[7] => $this->getPaymentstatus(),
        );
        if ($result[$keys[6]] instanceof \DateTime) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aSports) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sports';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sports';
                        break;
                    default:
                        $key = 'Sports';
                }

                $result[$key] = $this->aSports->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aParticipant) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'participant';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'participant';
                        break;
                    default:
                        $key = 'Participant';
                }

                $result[$key] = $this->aParticipant->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collSportsparticipantss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'sportsparticipantss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'sportsparticipantss';
                        break;
                    default:
                        $key = 'Sportsparticipantss';
                }

                $result[$key] = $this->collSportsparticipantss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Model\Sportsteam
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = SportsteamTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Model\Sportsteam
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setTeamid($value);
                break;
            case 1:
                $this->setSportid($value);
                break;
            case 2:
                $this->setTeamname($value);
                break;
            case 3:
                $this->setHeadcnic($value);
                break;
            case 4:
                $this->setChallanid($value);
                break;
            case 5:
                $this->setAmountpayable($value);
                break;
            case 6:
                $this->setDuedata($value);
                break;
            case 7:
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
        $keys = SportsteamTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setTeamid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setSportid($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTeamname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setHeadcnic($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setChallanid($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAmountpayable($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setDuedata($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setPaymentstatus($arr[$keys[7]]);
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
     * @return $this|\Model\Model\Sportsteam The current object, for fluid interface
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
        $criteria = new Criteria(SportsteamTableMap::DATABASE_NAME);

        if ($this->isColumnModified(SportsteamTableMap::COL_TEAMID)) {
            $criteria->add(SportsteamTableMap::COL_TEAMID, $this->teamid);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_SPORTID)) {
            $criteria->add(SportsteamTableMap::COL_SPORTID, $this->sportid);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_TEAMNAME)) {
            $criteria->add(SportsteamTableMap::COL_TEAMNAME, $this->teamname);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_HEADCNIC)) {
            $criteria->add(SportsteamTableMap::COL_HEADCNIC, $this->headcnic);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_CHALLANID)) {
            $criteria->add(SportsteamTableMap::COL_CHALLANID, $this->challanid);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_AMOUNTPAYABLE)) {
            $criteria->add(SportsteamTableMap::COL_AMOUNTPAYABLE, $this->amountpayable);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_DUEDATA)) {
            $criteria->add(SportsteamTableMap::COL_DUEDATA, $this->duedata);
        }
        if ($this->isColumnModified(SportsteamTableMap::COL_PAYMENTSTATUS)) {
            $criteria->add(SportsteamTableMap::COL_PAYMENTSTATUS, $this->paymentstatus);
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
        $criteria = ChildSportsteamQuery::create();
        $criteria->add(SportsteamTableMap::COL_TEAMID, $this->teamid);

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
        $validPk = null !== $this->getTeamid();

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
        return $this->getTeamid();
    }

    /**
     * Generic method to set the primary key (teamid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setTeamid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getTeamid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Model\Model\Sportsteam (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSportid($this->getSportid());
        $copyObj->setTeamname($this->getTeamname());
        $copyObj->setHeadcnic($this->getHeadcnic());
        $copyObj->setChallanid($this->getChallanid());
        $copyObj->setAmountpayable($this->getAmountpayable());
        $copyObj->setDuedata($this->getDuedata());
        $copyObj->setPaymentstatus($this->getPaymentstatus());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getSportsparticipantss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSportsparticipants($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setTeamid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Model\Model\Sportsteam Clone of current object.
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
     * Declares an association between this object and a ChildSports object.
     *
     * @param  ChildSports $v
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSports(ChildSports $v = null)
    {
        if ($v === null) {
            $this->setSportid(NULL);
        } else {
            $this->setSportid($v->getSportid());
        }

        $this->aSports = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildSports object, it will not be re-added.
        if ($v !== null) {
            $v->addSportsteam($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildSports object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildSports The associated ChildSports object.
     * @throws PropelException
     */
    public function getSports(ConnectionInterface $con = null)
    {
        if ($this->aSports === null && ($this->sportid !== null)) {
            $this->aSports = ChildSportsQuery::create()->findPk($this->sportid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSports->addSportsteams($this);
             */
        }

        return $this->aSports;
    }

    /**
     * Declares an association between this object and a ChildParticipant object.
     *
     * @param  ChildParticipant $v
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setParticipant(ChildParticipant $v = null)
    {
        if ($v === null) {
            $this->setHeadcnic(NULL);
        } else {
            $this->setHeadcnic($v->getCnic());
        }

        $this->aParticipant = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildParticipant object, it will not be re-added.
        if ($v !== null) {
            $v->addSportsteam($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildParticipant object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildParticipant The associated ChildParticipant object.
     * @throws PropelException
     */
    public function getParticipant(ConnectionInterface $con = null)
    {
        if ($this->aParticipant === null && (($this->headcnic !== "" && $this->headcnic !== null))) {
            $this->aParticipant = ChildParticipantQuery::create()
                ->filterBySportsteam($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aParticipant->addSportsteams($this);
             */
        }

        return $this->aParticipant;
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
        if ('Sportsparticipants' == $relationName) {
            return $this->initSportsparticipantss();
        }
    }

    /**
     * Clears out the collSportsparticipantss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addSportsparticipantss()
     */
    public function clearSportsparticipantss()
    {
        $this->collSportsparticipantss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collSportsparticipantss collection loaded partially.
     */
    public function resetPartialSportsparticipantss($v = true)
    {
        $this->collSportsparticipantssPartial = $v;
    }

    /**
     * Initializes the collSportsparticipantss collection.
     *
     * By default this just sets the collSportsparticipantss collection to an empty array (like clearcollSportsparticipantss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSportsparticipantss($overrideExisting = true)
    {
        if (null !== $this->collSportsparticipantss && !$overrideExisting) {
            return;
        }

        $collectionClassName = SportsparticipantsTableMap::getTableMap()->getCollectionClassName();

        $this->collSportsparticipantss = new $collectionClassName;
        $this->collSportsparticipantss->setModel('\Model\Model\Sportsparticipants');
    }

    /**
     * Gets an array of ChildSportsparticipants objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildSportsteam is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildSportsparticipants[] List of ChildSportsparticipants objects
     * @throws PropelException
     */
    public function getSportsparticipantss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collSportsparticipantssPartial && !$this->isNew();
        if (null === $this->collSportsparticipantss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSportsparticipantss) {
                // return empty collection
                $this->initSportsparticipantss();
            } else {
                $collSportsparticipantss = ChildSportsparticipantsQuery::create(null, $criteria)
                    ->filterBySportsteam($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collSportsparticipantssPartial && count($collSportsparticipantss)) {
                        $this->initSportsparticipantss(false);

                        foreach ($collSportsparticipantss as $obj) {
                            if (false == $this->collSportsparticipantss->contains($obj)) {
                                $this->collSportsparticipantss->append($obj);
                            }
                        }

                        $this->collSportsparticipantssPartial = true;
                    }

                    return $collSportsparticipantss;
                }

                if ($partial && $this->collSportsparticipantss) {
                    foreach ($this->collSportsparticipantss as $obj) {
                        if ($obj->isNew()) {
                            $collSportsparticipantss[] = $obj;
                        }
                    }
                }

                $this->collSportsparticipantss = $collSportsparticipantss;
                $this->collSportsparticipantssPartial = false;
            }
        }

        return $this->collSportsparticipantss;
    }

    /**
     * Sets a collection of ChildSportsparticipants objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $sportsparticipantss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildSportsteam The current object (for fluent API support)
     */
    public function setSportsparticipantss(Collection $sportsparticipantss, ConnectionInterface $con = null)
    {
        /** @var ChildSportsparticipants[] $sportsparticipantssToDelete */
        $sportsparticipantssToDelete = $this->getSportsparticipantss(new Criteria(), $con)->diff($sportsparticipantss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->sportsparticipantssScheduledForDeletion = clone $sportsparticipantssToDelete;

        foreach ($sportsparticipantssToDelete as $sportsparticipantsRemoved) {
            $sportsparticipantsRemoved->setSportsteam(null);
        }

        $this->collSportsparticipantss = null;
        foreach ($sportsparticipantss as $sportsparticipants) {
            $this->addSportsparticipants($sportsparticipants);
        }

        $this->collSportsparticipantss = $sportsparticipantss;
        $this->collSportsparticipantssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Sportsparticipants objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Sportsparticipants objects.
     * @throws PropelException
     */
    public function countSportsparticipantss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collSportsparticipantssPartial && !$this->isNew();
        if (null === $this->collSportsparticipantss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSportsparticipantss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSportsparticipantss());
            }

            $query = ChildSportsparticipantsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySportsteam($this)
                ->count($con);
        }

        return count($this->collSportsparticipantss);
    }

    /**
     * Method called to associate a ChildSportsparticipants object to this object
     * through the ChildSportsparticipants foreign key attribute.
     *
     * @param  ChildSportsparticipants $l ChildSportsparticipants
     * @return $this|\Model\Model\Sportsteam The current object (for fluent API support)
     */
    public function addSportsparticipants(ChildSportsparticipants $l)
    {
        if ($this->collSportsparticipantss === null) {
            $this->initSportsparticipantss();
            $this->collSportsparticipantssPartial = true;
        }

        if (!$this->collSportsparticipantss->contains($l)) {
            $this->doAddSportsparticipants($l);

            if ($this->sportsparticipantssScheduledForDeletion and $this->sportsparticipantssScheduledForDeletion->contains($l)) {
                $this->sportsparticipantssScheduledForDeletion->remove($this->sportsparticipantssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildSportsparticipants $sportsparticipants The ChildSportsparticipants object to add.
     */
    protected function doAddSportsparticipants(ChildSportsparticipants $sportsparticipants)
    {
        $this->collSportsparticipantss[]= $sportsparticipants;
        $sportsparticipants->setSportsteam($this);
    }

    /**
     * @param  ChildSportsparticipants $sportsparticipants The ChildSportsparticipants object to remove.
     * @return $this|ChildSportsteam The current object (for fluent API support)
     */
    public function removeSportsparticipants(ChildSportsparticipants $sportsparticipants)
    {
        if ($this->getSportsparticipantss()->contains($sportsparticipants)) {
            $pos = $this->collSportsparticipantss->search($sportsparticipants);
            $this->collSportsparticipantss->remove($pos);
            if (null === $this->sportsparticipantssScheduledForDeletion) {
                $this->sportsparticipantssScheduledForDeletion = clone $this->collSportsparticipantss;
                $this->sportsparticipantssScheduledForDeletion->clear();
            }
            $this->sportsparticipantssScheduledForDeletion[]= clone $sportsparticipants;
            $sportsparticipants->setSportsteam(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Sportsteam is new, it will return
     * an empty collection; or if this Sportsteam has previously
     * been saved, it will retrieve related Sportsparticipantss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Sportsteam.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSportsparticipants[] List of ChildSportsparticipants objects
     */
    public function getSportsparticipantssJoinParticipant(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSportsparticipantsQuery::create(null, $criteria);
        $query->joinWith('Participant', $joinBehavior);

        return $this->getSportsparticipantss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aSports) {
            $this->aSports->removeSportsteam($this);
        }
        if (null !== $this->aParticipant) {
            $this->aParticipant->removeSportsteam($this);
        }
        $this->teamid = null;
        $this->sportid = null;
        $this->teamname = null;
        $this->headcnic = null;
        $this->challanid = null;
        $this->amountpayable = null;
        $this->duedata = null;
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
            if ($this->collSportsparticipantss) {
                foreach ($this->collSportsparticipantss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collSportsparticipantss = null;
        $this->aSports = null;
        $this->aParticipant = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(SportsteamTableMap::DEFAULT_STRING_FORMAT);
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
