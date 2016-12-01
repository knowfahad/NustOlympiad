<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Ambassador as ChildAmbassador;
use Model\Model\AmbassadorParticipant as ChildAmbassadorParticipant;
use Model\Model\AmbassadorParticipantQuery as ChildAmbassadorParticipantQuery;
use Model\Model\AmbassadorQuery as ChildAmbassadorQuery;
use Model\Model\Participant as ChildParticipant;
use Model\Model\ParticipantQuery as ChildParticipantQuery;
use Model\Model\Map\AmbassadorParticipantTableMap;
use Model\Model\Map\AmbassadorTableMap;
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

/**
 * Base class that represents a row from the 'ambassador' table.
 *
 *
 *
 * @package    propel.generator.Model.Model.Base
 */
abstract class Ambassador implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Model\\Map\\AmbassadorTableMap';


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
     * The value for the ambassadorid field.
     *
     * @var        string
     */
    protected $ambassadorid;

    /**
     * The value for the cnic field.
     *
     * @var        string
     */
    protected $cnic;

    /**
     * The value for the firstname field.
     *
     * @var        string
     */
    protected $firstname;

    /**
     * The value for the lastname field.
     *
     * @var        string
     */
    protected $lastname;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * @var        ObjectCollection|ChildAmbassadorParticipant[] Collection to store aggregation of ChildAmbassadorParticipant objects.
     */
    protected $collAmbassadorParticipants;
    protected $collAmbassadorParticipantsPartial;

    /**
     * @var        ObjectCollection|ChildParticipant[] Collection to store aggregation of ChildParticipant objects.
     */
    protected $collParticipants;
    protected $collParticipantsPartial;

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
     * @var ObjectCollection|ChildParticipant[]
     */
    protected $participantsScheduledForDeletion = null;

    /**
     * Initializes internal state of Model\Model\Base\Ambassador object.
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
     * Compares this with another <code>Ambassador</code> instance.  If
     * <code>obj</code> is an instance of <code>Ambassador</code>, delegates to
     * <code>equals(Ambassador)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Ambassador The current object, for fluid interface
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
     * Get the [ambassadorid] column value.
     *
     * @return string
     */
    public function getAmbassadorid()
    {
        return $this->ambassadorid;
    }

    /**
     * Get the [cnic] column value.
     *
     * @return string
     */
    public function getCnic()
    {
        return $this->cnic;
    }

    /**
     * Get the [firstname] column value.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the [lastname] column value.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of [ambassadorid] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
     */
    public function setAmbassadorid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ambassadorid !== $v) {
            $this->ambassadorid = $v;
            $this->modifiedColumns[AmbassadorTableMap::COL_AMBASSADORID] = true;
        }

        return $this;
    } // setAmbassadorid()

    /**
     * Set the value of [cnic] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
     */
    public function setCnic($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cnic !== $v) {
            $this->cnic = $v;
            $this->modifiedColumns[AmbassadorTableMap::COL_CNIC] = true;
        }

        return $this;
    } // setCnic()

    /**
     * Set the value of [firstname] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[AmbassadorTableMap::COL_FIRSTNAME] = true;
        }

        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[AmbassadorTableMap::COL_LASTNAME] = true;
        }

        return $this;
    } // setLastname()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[AmbassadorTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : AmbassadorTableMap::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ambassadorid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : AmbassadorTableMap::translateFieldName('Cnic', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cnic = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : AmbassadorTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : AmbassadorTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : AmbassadorTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 5; // 5 = AmbassadorTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Model\\Ambassador'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildAmbassadorQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAmbassadorParticipants = null;

            $this->collParticipants = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Ambassador::setDeleted()
     * @see Ambassador::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildAmbassadorQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorTableMap::DATABASE_NAME);
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
                AmbassadorTableMap::addInstanceToPool($this);
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

            if ($this->participantsScheduledForDeletion !== null) {
                if (!$this->participantsScheduledForDeletion->isEmpty()) {
                    foreach ($this->participantsScheduledForDeletion as $participant) {
                        // need to save related object because we set the relation to null
                        $participant->save($con);
                    }
                    $this->participantsScheduledForDeletion = null;
                }
            }

            if ($this->collParticipants !== null) {
                foreach ($this->collParticipants as $referrerFK) {
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
        if ($this->isColumnModified(AmbassadorTableMap::COL_AMBASSADORID)) {
            $modifiedColumns[':p' . $index++]  = 'AmbassadorID';
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_CNIC)) {
            $modifiedColumns[':p' . $index++]  = 'CNIC';
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'FirstName';
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'LastName';
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'Email';
        }

        $sql = sprintf(
            'INSERT INTO ambassador (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'AmbassadorID':
                        $stmt->bindValue($identifier, $this->ambassadorid, PDO::PARAM_STR);
                        break;
                    case 'CNIC':
                        $stmt->bindValue($identifier, $this->cnic, PDO::PARAM_STR);
                        break;
                    case 'FirstName':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'LastName':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'Email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
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
        $pos = AmbassadorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getAmbassadorid();
                break;
            case 1:
                return $this->getCnic();
                break;
            case 2:
                return $this->getFirstname();
                break;
            case 3:
                return $this->getLastname();
                break;
            case 4:
                return $this->getEmail();
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

        if (isset($alreadyDumpedObjects['Ambassador'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Ambassador'][$this->hashCode()] = true;
        $keys = AmbassadorTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAmbassadorid(),
            $keys[1] => $this->getCnic(),
            $keys[2] => $this->getFirstname(),
            $keys[3] => $this->getLastname(),
            $keys[4] => $this->getEmail(),
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
            if (null !== $this->collParticipants) {

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

                $result[$key] = $this->collParticipants->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Model\Ambassador
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = AmbassadorTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Model\Ambassador
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setAmbassadorid($value);
                break;
            case 1:
                $this->setCnic($value);
                break;
            case 2:
                $this->setFirstname($value);
                break;
            case 3:
                $this->setLastname($value);
                break;
            case 4:
                $this->setEmail($value);
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
        $keys = AmbassadorTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setAmbassadorid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCnic($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setFirstname($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setLastname($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEmail($arr[$keys[4]]);
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
     * @return $this|\Model\Model\Ambassador The current object, for fluid interface
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
        $criteria = new Criteria(AmbassadorTableMap::DATABASE_NAME);

        if ($this->isColumnModified(AmbassadorTableMap::COL_AMBASSADORID)) {
            $criteria->add(AmbassadorTableMap::COL_AMBASSADORID, $this->ambassadorid);
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_CNIC)) {
            $criteria->add(AmbassadorTableMap::COL_CNIC, $this->cnic);
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_FIRSTNAME)) {
            $criteria->add(AmbassadorTableMap::COL_FIRSTNAME, $this->firstname);
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_LASTNAME)) {
            $criteria->add(AmbassadorTableMap::COL_LASTNAME, $this->lastname);
        }
        if ($this->isColumnModified(AmbassadorTableMap::COL_EMAIL)) {
            $criteria->add(AmbassadorTableMap::COL_EMAIL, $this->email);
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
        $criteria = ChildAmbassadorQuery::create();
        $criteria->add(AmbassadorTableMap::COL_AMBASSADORID, $this->ambassadorid);

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
        $validPk = null !== $this->getAmbassadorid();

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
        return $this->getAmbassadorid();
    }

    /**
     * Generic method to set the primary key (ambassadorid column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAmbassadorid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getAmbassadorid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Model\Model\Ambassador (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAmbassadorid($this->getAmbassadorid());
        $copyObj->setCnic($this->getCnic());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setEmail($this->getEmail());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAmbassadorParticipants() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAmbassadorParticipant($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getParticipants() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addParticipant($relObj->copy($deepCopy));
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
     * @return \Model\Model\Ambassador Clone of current object.
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
        if ('Participant' == $relationName) {
            return $this->initParticipants();
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
     * If this ChildAmbassador is new, it will return
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
                    ->filterByAmbassador($this)
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
     * @return $this|ChildAmbassador The current object (for fluent API support)
     */
    public function setAmbassadorParticipants(Collection $ambassadorParticipants, ConnectionInterface $con = null)
    {
        /** @var ChildAmbassadorParticipant[] $ambassadorParticipantsToDelete */
        $ambassadorParticipantsToDelete = $this->getAmbassadorParticipants(new Criteria(), $con)->diff($ambassadorParticipants);


        $this->ambassadorParticipantsScheduledForDeletion = $ambassadorParticipantsToDelete;

        foreach ($ambassadorParticipantsToDelete as $ambassadorParticipantRemoved) {
            $ambassadorParticipantRemoved->setAmbassador(null);
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
                ->filterByAmbassador($this)
                ->count($con);
        }

        return count($this->collAmbassadorParticipants);
    }

    /**
     * Method called to associate a ChildAmbassadorParticipant object to this object
     * through the ChildAmbassadorParticipant foreign key attribute.
     *
     * @param  ChildAmbassadorParticipant $l ChildAmbassadorParticipant
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
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
        $ambassadorParticipant->setAmbassador($this);
    }

    /**
     * @param  ChildAmbassadorParticipant $ambassadorParticipant The ChildAmbassadorParticipant object to remove.
     * @return $this|ChildAmbassador The current object (for fluent API support)
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
            $this->ambassadorParticipantsScheduledForDeletion[]= clone $ambassadorParticipant;
            $ambassadorParticipant->setAmbassador(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Ambassador is new, it will return
     * an empty collection; or if this Ambassador has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ambassador.
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
     * Otherwise if this Ambassador is new, it will return
     * an empty collection; or if this Ambassador has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ambassador.
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
     * Otherwise if this Ambassador is new, it will return
     * an empty collection; or if this Ambassador has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ambassador.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildAmbassadorParticipant[] List of ChildAmbassadorParticipant objects
     */
    public function getAmbassadorParticipantsJoinSports(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildAmbassadorParticipantQuery::create(null, $criteria);
        $query->joinWith('Sports', $joinBehavior);

        return $this->getAmbassadorParticipants($query, $con);
    }

    /**
     * Clears out the collParticipants collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addParticipants()
     */
    public function clearParticipants()
    {
        $this->collParticipants = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collParticipants collection loaded partially.
     */
    public function resetPartialParticipants($v = true)
    {
        $this->collParticipantsPartial = $v;
    }

    /**
     * Initializes the collParticipants collection.
     *
     * By default this just sets the collParticipants collection to an empty array (like clearcollParticipants());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initParticipants($overrideExisting = true)
    {
        if (null !== $this->collParticipants && !$overrideExisting) {
            return;
        }

        $collectionClassName = ParticipantTableMap::getTableMap()->getCollectionClassName();

        $this->collParticipants = new $collectionClassName;
        $this->collParticipants->setModel('\Model\Model\Participant');
    }

    /**
     * Gets an array of ChildParticipant objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildAmbassador is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     * @throws PropelException
     */
    public function getParticipants(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantsPartial && !$this->isNew();
        if (null === $this->collParticipants || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collParticipants) {
                // return empty collection
                $this->initParticipants();
            } else {
                $collParticipants = ChildParticipantQuery::create(null, $criteria)
                    ->filterByAmbassador($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collParticipantsPartial && count($collParticipants)) {
                        $this->initParticipants(false);

                        foreach ($collParticipants as $obj) {
                            if (false == $this->collParticipants->contains($obj)) {
                                $this->collParticipants->append($obj);
                            }
                        }

                        $this->collParticipantsPartial = true;
                    }

                    return $collParticipants;
                }

                if ($partial && $this->collParticipants) {
                    foreach ($this->collParticipants as $obj) {
                        if ($obj->isNew()) {
                            $collParticipants[] = $obj;
                        }
                    }
                }

                $this->collParticipants = $collParticipants;
                $this->collParticipantsPartial = false;
            }
        }

        return $this->collParticipants;
    }

    /**
     * Sets a collection of ChildParticipant objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $participants A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildAmbassador The current object (for fluent API support)
     */
    public function setParticipants(Collection $participants, ConnectionInterface $con = null)
    {
        /** @var ChildParticipant[] $participantsToDelete */
        $participantsToDelete = $this->getParticipants(new Criteria(), $con)->diff($participants);


        $this->participantsScheduledForDeletion = $participantsToDelete;

        foreach ($participantsToDelete as $participantRemoved) {
            $participantRemoved->setAmbassador(null);
        }

        $this->collParticipants = null;
        foreach ($participants as $participant) {
            $this->addParticipant($participant);
        }

        $this->collParticipants = $participants;
        $this->collParticipantsPartial = false;

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
    public function countParticipants(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collParticipantsPartial && !$this->isNew();
        if (null === $this->collParticipants || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collParticipants) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getParticipants());
            }

            $query = ChildParticipantQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAmbassador($this)
                ->count($con);
        }

        return count($this->collParticipants);
    }

    /**
     * Method called to associate a ChildParticipant object to this object
     * through the ChildParticipant foreign key attribute.
     *
     * @param  ChildParticipant $l ChildParticipant
     * @return $this|\Model\Model\Ambassador The current object (for fluent API support)
     */
    public function addParticipant(ChildParticipant $l)
    {
        if ($this->collParticipants === null) {
            $this->initParticipants();
            $this->collParticipantsPartial = true;
        }

        if (!$this->collParticipants->contains($l)) {
            $this->doAddParticipant($l);

            if ($this->participantsScheduledForDeletion and $this->participantsScheduledForDeletion->contains($l)) {
                $this->participantsScheduledForDeletion->remove($this->participantsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildParticipant $participant The ChildParticipant object to add.
     */
    protected function doAddParticipant(ChildParticipant $participant)
    {
        $this->collParticipants[]= $participant;
        $participant->setAmbassador($this);
    }

    /**
     * @param  ChildParticipant $participant The ChildParticipant object to remove.
     * @return $this|ChildAmbassador The current object (for fluent API support)
     */
    public function removeParticipant(ChildParticipant $participant)
    {
        if ($this->getParticipants()->contains($participant)) {
            $pos = $this->collParticipants->search($participant);
            $this->collParticipants->remove($pos);
            if (null === $this->participantsScheduledForDeletion) {
                $this->participantsScheduledForDeletion = clone $this->collParticipants;
                $this->participantsScheduledForDeletion->clear();
            }
            $this->participantsScheduledForDeletion[]= $participant;
            $participant->setAmbassador(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Ambassador is new, it will return
     * an empty collection; or if this Ambassador has previously
     * been saved, it will retrieve related Participants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ambassador.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     */
    public function getParticipantsJoinChallanRelatedByAccomodationchallanid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParticipantQuery::create(null, $criteria);
        $query->joinWith('ChallanRelatedByAccomodationchallanid', $joinBehavior);

        return $this->getParticipants($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Ambassador is new, it will return
     * an empty collection; or if this Ambassador has previously
     * been saved, it will retrieve related Participants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Ambassador.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildParticipant[] List of ChildParticipant objects
     */
    public function getParticipantsJoinChallanRelatedByRegistrationchallanid(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildParticipantQuery::create(null, $criteria);
        $query->joinWith('ChallanRelatedByRegistrationchallanid', $joinBehavior);

        return $this->getParticipants($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->ambassadorid = null;
        $this->cnic = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->email = null;
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
            if ($this->collParticipants) {
                foreach ($this->collParticipants as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAmbassadorParticipants = null;
        $this->collParticipants = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AmbassadorTableMap::DEFAULT_STRING_FORMAT);
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
