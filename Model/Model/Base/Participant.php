<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Ambassador as ChildAmbassador;
use Model\Model\AmbassadorParticipant as ChildAmbassadorParticipant;
use Model\Model\AmbassadorParticipantQuery as ChildAmbassadorParticipantQuery;
use Model\Model\AmbassadorQuery as ChildAmbassadorQuery;
use Model\Model\Challan as ChildChallan;
use Model\Model\ChallanQuery as ChildChallanQuery;
use Model\Model\Eventparticipants as ChildEventparticipants;
use Model\Model\EventparticipantsQuery as ChildEventparticipantsQuery;
use Model\Model\Participant as ChildParticipant;
use Model\Model\ParticipantQuery as ChildParticipantQuery;
use Model\Model\Sportsparticipants as ChildSportsparticipants;
use Model\Model\SportsparticipantsQuery as ChildSportsparticipantsQuery;
use Model\Model\Sportsteam as ChildSportsteam;
use Model\Model\SportsteamQuery as ChildSportsteamQuery;
use Model\Model\Useraccount as ChildUseraccount;
use Model\Model\UseraccountQuery as ChildUseraccountQuery;
use Model\Model\Map\AmbassadorParticipantTableMap;
use Model\Model\Map\EventparticipantsTableMap;
use Model\Model\Map\ParticipantTableMap;
use Model\Model\Map\SportsparticipantsTableMap;
use Model\Model\Map\SportsteamTableMap;
use Model\Model\Map\UseraccountTableMap;
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
 * Base class that represents a row from the 'participant' table.
 *
 *
 *
 * @package    propel.generator.Model.Model.Base
 */
abstract class Participant implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Model\\Model\\Map\\ParticipantTableMap';


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
     * The value for the participantid field.
     *
     * @var        int
     */
    protected $participantid;

    /**
     * The value for the cnic field.
     *
     * @var        string
     */
    protected $cnic;

    /**
     * The value for the registrationchallanid field.
     *
     * @var        string
     */
    protected $registrationchallanid;

    /**
     * The value for the accomodationchallanid field.
     *
     * @var        string
     */
    protected $accomodationchallanid;

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
     * The value for the gender field.
     *
     * Note: this column has a database default value of: 'Male'
     * @var        string
     */
    protected $gender;

    /**
     * The value for the address field.
     *
     * @var        string
     */
    protected $address;

    /**
     * The value for the phoneno field.
     *
     * @var        string
     */
    protected $phoneno;

    /**
     * The value for the nustregno field.
     *
     * @var        string
     */
    protected $nustregno;

    /**
     * The value for the ambassadorid field.
     *
     * @var        string
     */
    protected $ambassadorid;

    /**
     * @var        ChildChallan
     */
    protected $aChallanRelatedByAccomodationchallanid;

    /**
     * @var        ChildAmbassador
     */
    protected $aAmbassador;

    /**
     * @var        ChildChallan
     */
    protected $aChallanRelatedByRegistrationchallanid;

    /**
     * @var        ObjectCollection|ChildAmbassadorParticipant[] Collection to store aggregation of ChildAmbassadorParticipant objects.
     */
    protected $collAmbassadorParticipants;
    protected $collAmbassadorParticipantsPartial;

    /**
     * @var        ObjectCollection|ChildEventparticipants[] Collection to store aggregation of ChildEventparticipants objects.
     */
    protected $collEventparticipantss;
    protected $collEventparticipantssPartial;

    /**
     * @var        ObjectCollection|ChildSportsparticipants[] Collection to store aggregation of ChildSportsparticipants objects.
     */
    protected $collSportsparticipantss;
    protected $collSportsparticipantssPartial;

    /**
     * @var        ObjectCollection|ChildSportsteam[] Collection to store aggregation of ChildSportsteam objects.
     */
    protected $collSportsteams;
    protected $collSportsteamsPartial;

    /**
     * @var        ObjectCollection|ChildUseraccount[] Collection to store aggregation of ChildUseraccount objects.
     */
    protected $collUseraccounts;
    protected $collUseraccountsPartial;

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
     * @var ObjectCollection|ChildEventparticipants[]
     */
    protected $eventparticipantssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSportsparticipants[]
     */
    protected $sportsparticipantssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildSportsteam[]
     */
    protected $sportsteamsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUseraccount[]
     */
    protected $useraccountsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->gender = 'Male';
    }

    /**
     * Initializes internal state of Model\Model\Base\Participant object.
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
     * Compares this with another <code>Participant</code> instance.  If
     * <code>obj</code> is an instance of <code>Participant</code>, delegates to
     * <code>equals(Participant)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Participant The current object, for fluid interface
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
     * Get the [participantid] column value.
     *
     * @return int
     */
    public function getParticipantid()
    {
        return $this->participantid;
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
     * Get the [registrationchallanid] column value.
     *
     * @return string
     */
    public function getRegistrationchallanid()
    {
        return $this->registrationchallanid;
    }

    /**
     * Get the [accomodationchallanid] column value.
     *
     * @return string
     */
    public function getAccomodationchallanid()
    {
        return $this->accomodationchallanid;
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
     * Get the [gender] column value.
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Get the [address] column value.
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Get the [phoneno] column value.
     *
     * @return string
     */
    public function getPhoneno()
    {
        return $this->phoneno;
    }

    /**
     * Get the [nustregno] column value.
     *
     * @return string
     */
    public function getNustregno()
    {
        return $this->nustregno;
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
     * Set the value of [participantid] column.
     *
     * @param int $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setParticipantid($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->participantid !== $v) {
            $this->participantid = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_PARTICIPANTID] = true;
        }

        return $this;
    } // setParticipantid()

    /**
     * Set the value of [cnic] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setCnic($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cnic !== $v) {
            $this->cnic = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_CNIC] = true;
        }

        return $this;
    } // setCnic()

    /**
     * Set the value of [registrationchallanid] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setRegistrationchallanid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->registrationchallanid !== $v) {
            $this->registrationchallanid = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_REGISTRATIONCHALLANID] = true;
        }

        if ($this->aChallanRelatedByRegistrationchallanid !== null && $this->aChallanRelatedByRegistrationchallanid->getChallanid() !== $v) {
            $this->aChallanRelatedByRegistrationchallanid = null;
        }

        return $this;
    } // setRegistrationchallanid()

    /**
     * Set the value of [accomodationchallanid] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setAccomodationchallanid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->accomodationchallanid !== $v) {
            $this->accomodationchallanid = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_ACCOMODATIONCHALLANID] = true;
        }

        if ($this->aChallanRelatedByAccomodationchallanid !== null && $this->aChallanRelatedByAccomodationchallanid->getChallanid() !== $v) {
            $this->aChallanRelatedByAccomodationchallanid = null;
        }

        return $this;
    } // setAccomodationchallanid()

    /**
     * Set the value of [firstname] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setFirstname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->firstname !== $v) {
            $this->firstname = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_FIRSTNAME] = true;
        }

        return $this;
    } // setFirstname()

    /**
     * Set the value of [lastname] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setLastname($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->lastname !== $v) {
            $this->lastname = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_LASTNAME] = true;
        }

        return $this;
    } // setLastname()

    /**
     * Set the value of [gender] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setGender($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->gender !== $v) {
            $this->gender = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_GENDER] = true;
        }

        return $this;
    } // setGender()

    /**
     * Set the value of [address] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setAddress($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->address !== $v) {
            $this->address = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_ADDRESS] = true;
        }

        return $this;
    } // setAddress()

    /**
     * Set the value of [phoneno] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setPhoneno($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->phoneno !== $v) {
            $this->phoneno = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_PHONENO] = true;
        }

        return $this;
    } // setPhoneno()

    /**
     * Set the value of [nustregno] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setNustregno($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nustregno !== $v) {
            $this->nustregno = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_NUSTREGNO] = true;
        }

        return $this;
    } // setNustregno()

    /**
     * Set the value of [ambassadorid] column.
     *
     * @param string $v new value
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function setAmbassadorid($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->ambassadorid !== $v) {
            $this->ambassadorid = $v;
            $this->modifiedColumns[ParticipantTableMap::COL_AMBASSADORID] = true;
        }

        if ($this->aAmbassador !== null && $this->aAmbassador->getAmbassadorid() !== $v) {
            $this->aAmbassador = null;
        }

        return $this;
    } // setAmbassadorid()

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
            if ($this->gender !== 'Male') {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : ParticipantTableMap::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->participantid = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : ParticipantTableMap::translateFieldName('Cnic', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cnic = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : ParticipantTableMap::translateFieldName('Registrationchallanid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->registrationchallanid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : ParticipantTableMap::translateFieldName('Accomodationchallanid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->accomodationchallanid = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : ParticipantTableMap::translateFieldName('Firstname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->firstname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : ParticipantTableMap::translateFieldName('Lastname', TableMap::TYPE_PHPNAME, $indexType)];
            $this->lastname = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : ParticipantTableMap::translateFieldName('Gender', TableMap::TYPE_PHPNAME, $indexType)];
            $this->gender = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : ParticipantTableMap::translateFieldName('Address', TableMap::TYPE_PHPNAME, $indexType)];
            $this->address = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : ParticipantTableMap::translateFieldName('Phoneno', TableMap::TYPE_PHPNAME, $indexType)];
            $this->phoneno = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : ParticipantTableMap::translateFieldName('Nustregno', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nustregno = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : ParticipantTableMap::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)];
            $this->ambassadorid = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = ParticipantTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Model\\Model\\Participant'), 0, $e);
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
        if ($this->aChallanRelatedByRegistrationchallanid !== null && $this->registrationchallanid !== $this->aChallanRelatedByRegistrationchallanid->getChallanid()) {
            $this->aChallanRelatedByRegistrationchallanid = null;
        }
        if ($this->aChallanRelatedByAccomodationchallanid !== null && $this->accomodationchallanid !== $this->aChallanRelatedByAccomodationchallanid->getChallanid()) {
            $this->aChallanRelatedByAccomodationchallanid = null;
        }
        if ($this->aAmbassador !== null && $this->ambassadorid !== $this->aAmbassador->getAmbassadorid()) {
            $this->aAmbassador = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(ParticipantTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildParticipantQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aChallanRelatedByAccomodationchallanid = null;
            $this->aAmbassador = null;
            $this->aChallanRelatedByRegistrationchallanid = null;
            $this->collAmbassadorParticipants = null;

            $this->collEventparticipantss = null;

            $this->collSportsparticipantss = null;

            $this->collSportsteams = null;

            $this->collUseraccounts = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Participant::setDeleted()
     * @see Participant::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildParticipantQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantTableMap::DATABASE_NAME);
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
                ParticipantTableMap::addInstanceToPool($this);
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

            if ($this->aChallanRelatedByAccomodationchallanid !== null) {
                if ($this->aChallanRelatedByAccomodationchallanid->isModified() || $this->aChallanRelatedByAccomodationchallanid->isNew()) {
                    $affectedRows += $this->aChallanRelatedByAccomodationchallanid->save($con);
                }
                $this->setChallanRelatedByAccomodationchallanid($this->aChallanRelatedByAccomodationchallanid);
            }

            if ($this->aAmbassador !== null) {
                if ($this->aAmbassador->isModified() || $this->aAmbassador->isNew()) {
                    $affectedRows += $this->aAmbassador->save($con);
                }
                $this->setAmbassador($this->aAmbassador);
            }

            if ($this->aChallanRelatedByRegistrationchallanid !== null) {
                if ($this->aChallanRelatedByRegistrationchallanid->isModified() || $this->aChallanRelatedByRegistrationchallanid->isNew()) {
                    $affectedRows += $this->aChallanRelatedByRegistrationchallanid->save($con);
                }
                $this->setChallanRelatedByRegistrationchallanid($this->aChallanRelatedByRegistrationchallanid);
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

            if ($this->eventparticipantssScheduledForDeletion !== null) {
                if (!$this->eventparticipantssScheduledForDeletion->isEmpty()) {
                    \Model\Model\EventparticipantsQuery::create()
                        ->filterByPrimaryKeys($this->eventparticipantssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->eventparticipantssScheduledForDeletion = null;
                }
            }

            if ($this->collEventparticipantss !== null) {
                foreach ($this->collEventparticipantss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

            if ($this->useraccountsScheduledForDeletion !== null) {
                if (!$this->useraccountsScheduledForDeletion->isEmpty()) {
                    \Model\Model\UseraccountQuery::create()
                        ->filterByPrimaryKeys($this->useraccountsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->useraccountsScheduledForDeletion = null;
                }
            }

            if ($this->collUseraccounts !== null) {
                foreach ($this->collUseraccounts as $referrerFK) {
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

        $this->modifiedColumns[ParticipantTableMap::COL_PARTICIPANTID] = true;
        if (null !== $this->participantid) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ParticipantTableMap::COL_PARTICIPANTID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ParticipantTableMap::COL_PARTICIPANTID)) {
            $modifiedColumns[':p' . $index++]  = 'ParticipantID';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_CNIC)) {
            $modifiedColumns[':p' . $index++]  = 'CNIC';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_REGISTRATIONCHALLANID)) {
            $modifiedColumns[':p' . $index++]  = 'RegistrationChallanID';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_ACCOMODATIONCHALLANID)) {
            $modifiedColumns[':p' . $index++]  = 'AccomodationChallanID';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_FIRSTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'FirstName';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_LASTNAME)) {
            $modifiedColumns[':p' . $index++]  = 'LastName';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_GENDER)) {
            $modifiedColumns[':p' . $index++]  = 'Gender';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_ADDRESS)) {
            $modifiedColumns[':p' . $index++]  = 'Address';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_PHONENO)) {
            $modifiedColumns[':p' . $index++]  = 'PhoneNo';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_NUSTREGNO)) {
            $modifiedColumns[':p' . $index++]  = 'NUSTRegNo';
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_AMBASSADORID)) {
            $modifiedColumns[':p' . $index++]  = 'AmbassadorID';
        }

        $sql = sprintf(
            'INSERT INTO participant (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'ParticipantID':
                        $stmt->bindValue($identifier, $this->participantid, PDO::PARAM_INT);
                        break;
                    case 'CNIC':
                        $stmt->bindValue($identifier, $this->cnic, PDO::PARAM_STR);
                        break;
                    case 'RegistrationChallanID':
                        $stmt->bindValue($identifier, $this->registrationchallanid, PDO::PARAM_STR);
                        break;
                    case 'AccomodationChallanID':
                        $stmt->bindValue($identifier, $this->accomodationchallanid, PDO::PARAM_STR);
                        break;
                    case 'FirstName':
                        $stmt->bindValue($identifier, $this->firstname, PDO::PARAM_STR);
                        break;
                    case 'LastName':
                        $stmt->bindValue($identifier, $this->lastname, PDO::PARAM_STR);
                        break;
                    case 'Gender':
                        $stmt->bindValue($identifier, $this->gender, PDO::PARAM_STR);
                        break;
                    case 'Address':
                        $stmt->bindValue($identifier, $this->address, PDO::PARAM_STR);
                        break;
                    case 'PhoneNo':
                        $stmt->bindValue($identifier, $this->phoneno, PDO::PARAM_STR);
                        break;
                    case 'NUSTRegNo':
                        $stmt->bindValue($identifier, $this->nustregno, PDO::PARAM_STR);
                        break;
                    case 'AmbassadorID':
                        $stmt->bindValue($identifier, $this->ambassadorid, PDO::PARAM_STR);
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
        $this->setParticipantid($pk);

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
        $pos = ParticipantTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getParticipantid();
                break;
            case 1:
                return $this->getCnic();
                break;
            case 2:
                return $this->getRegistrationchallanid();
                break;
            case 3:
                return $this->getAccomodationchallanid();
                break;
            case 4:
                return $this->getFirstname();
                break;
            case 5:
                return $this->getLastname();
                break;
            case 6:
                return $this->getGender();
                break;
            case 7:
                return $this->getAddress();
                break;
            case 8:
                return $this->getPhoneno();
                break;
            case 9:
                return $this->getNustregno();
                break;
            case 10:
                return $this->getAmbassadorid();
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

        if (isset($alreadyDumpedObjects['Participant'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Participant'][$this->hashCode()] = true;
        $keys = ParticipantTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getParticipantid(),
            $keys[1] => $this->getCnic(),
            $keys[2] => $this->getRegistrationchallanid(),
            $keys[3] => $this->getAccomodationchallanid(),
            $keys[4] => $this->getFirstname(),
            $keys[5] => $this->getLastname(),
            $keys[6] => $this->getGender(),
            $keys[7] => $this->getAddress(),
            $keys[8] => $this->getPhoneno(),
            $keys[9] => $this->getNustregno(),
            $keys[10] => $this->getAmbassadorid(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aChallanRelatedByAccomodationchallanid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'challan';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'challan';
                        break;
                    default:
                        $key = 'Challan';
                }

                $result[$key] = $this->aChallanRelatedByAccomodationchallanid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAmbassador) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'ambassador';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'ambassador';
                        break;
                    default:
                        $key = 'Ambassador';
                }

                $result[$key] = $this->aAmbassador->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aChallanRelatedByRegistrationchallanid) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'challan';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'challan';
                        break;
                    default:
                        $key = 'Challan';
                }

                $result[$key] = $this->aChallanRelatedByRegistrationchallanid->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
            if (null !== $this->collEventparticipantss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'eventparticipantss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'eventparticipantss';
                        break;
                    default:
                        $key = 'Eventparticipantss';
                }

                $result[$key] = $this->collEventparticipantss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->collUseraccounts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'useraccounts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'useraccounts';
                        break;
                    default:
                        $key = 'Useraccounts';
                }

                $result[$key] = $this->collUseraccounts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Model\Model\Participant
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = ParticipantTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Model\Model\Participant
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setParticipantid($value);
                break;
            case 1:
                $this->setCnic($value);
                break;
            case 2:
                $this->setRegistrationchallanid($value);
                break;
            case 3:
                $this->setAccomodationchallanid($value);
                break;
            case 4:
                $this->setFirstname($value);
                break;
            case 5:
                $this->setLastname($value);
                break;
            case 6:
                $this->setGender($value);
                break;
            case 7:
                $this->setAddress($value);
                break;
            case 8:
                $this->setPhoneno($value);
                break;
            case 9:
                $this->setNustregno($value);
                break;
            case 10:
                $this->setAmbassadorid($value);
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
        $keys = ParticipantTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setParticipantid($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setCnic($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setRegistrationchallanid($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setAccomodationchallanid($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setFirstname($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setLastname($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setGender($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setAddress($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setPhoneno($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setNustregno($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setAmbassadorid($arr[$keys[10]]);
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
     * @return $this|\Model\Model\Participant The current object, for fluid interface
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
        $criteria = new Criteria(ParticipantTableMap::DATABASE_NAME);

        if ($this->isColumnModified(ParticipantTableMap::COL_PARTICIPANTID)) {
            $criteria->add(ParticipantTableMap::COL_PARTICIPANTID, $this->participantid);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_CNIC)) {
            $criteria->add(ParticipantTableMap::COL_CNIC, $this->cnic);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_REGISTRATIONCHALLANID)) {
            $criteria->add(ParticipantTableMap::COL_REGISTRATIONCHALLANID, $this->registrationchallanid);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_ACCOMODATIONCHALLANID)) {
            $criteria->add(ParticipantTableMap::COL_ACCOMODATIONCHALLANID, $this->accomodationchallanid);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_FIRSTNAME)) {
            $criteria->add(ParticipantTableMap::COL_FIRSTNAME, $this->firstname);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_LASTNAME)) {
            $criteria->add(ParticipantTableMap::COL_LASTNAME, $this->lastname);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_GENDER)) {
            $criteria->add(ParticipantTableMap::COL_GENDER, $this->gender);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_ADDRESS)) {
            $criteria->add(ParticipantTableMap::COL_ADDRESS, $this->address);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_PHONENO)) {
            $criteria->add(ParticipantTableMap::COL_PHONENO, $this->phoneno);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_NUSTREGNO)) {
            $criteria->add(ParticipantTableMap::COL_NUSTREGNO, $this->nustregno);
        }
        if ($this->isColumnModified(ParticipantTableMap::COL_AMBASSADORID)) {
            $criteria->add(ParticipantTableMap::COL_AMBASSADORID, $this->ambassadorid);
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
        $criteria = ChildParticipantQuery::create();
        $criteria->add(ParticipantTableMap::COL_PARTICIPANTID, $this->participantid);

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
        $validPk = null !== $this->getParticipantid();

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
        return $this->getParticipantid();
    }

    /**
     * Generic method to set the primary key (participantid column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setParticipantid($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getParticipantid();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Model\Model\Participant (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCnic($this->getCnic());
        $copyObj->setRegistrationchallanid($this->getRegistrationchallanid());
        $copyObj->setAccomodationchallanid($this->getAccomodationchallanid());
        $copyObj->setFirstname($this->getFirstname());
        $copyObj->setLastname($this->getLastname());
        $copyObj->setGender($this->getGender());
        $copyObj->setAddress($this->getAddress());
        $copyObj->setPhoneno($this->getPhoneno());
        $copyObj->setNustregno($this->getNustregno());
        $copyObj->setAmbassadorid($this->getAmbassadorid());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getAmbassadorParticipants() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAmbassadorParticipant($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getEventparticipantss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addEventparticipants($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSportsparticipantss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSportsparticipants($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSportsteams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSportsteam($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUseraccounts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUseraccount($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setParticipantid(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Model\Model\Participant Clone of current object.
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
     * Declares an association between this object and a ChildChallan object.
     *
     * @param  ChildChallan $v
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     * @throws PropelException
     */
    public function setChallanRelatedByAccomodationchallanid(ChildChallan $v = null)
    {
        if ($v === null) {
            $this->setAccomodationchallanid(NULL);
        } else {
            $this->setAccomodationchallanid($v->getChallanid());
        }

        $this->aChallanRelatedByAccomodationchallanid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildChallan object, it will not be re-added.
        if ($v !== null) {
            $v->addParticipantRelatedByAccomodationchallanid($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildChallan object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildChallan The associated ChildChallan object.
     * @throws PropelException
     */
    public function getChallanRelatedByAccomodationchallanid(ConnectionInterface $con = null)
    {
        if ($this->aChallanRelatedByAccomodationchallanid === null && (($this->accomodationchallanid !== "" && $this->accomodationchallanid !== null))) {
            $this->aChallanRelatedByAccomodationchallanid = ChildChallanQuery::create()->findPk($this->accomodationchallanid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aChallanRelatedByAccomodationchallanid->addParticipantsRelatedByAccomodationchallanid($this);
             */
        }

        return $this->aChallanRelatedByAccomodationchallanid;
    }

    /**
     * Declares an association between this object and a ChildAmbassador object.
     *
     * @param  ChildAmbassador $v
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAmbassador(ChildAmbassador $v = null)
    {
        if ($v === null) {
            $this->setAmbassadorid(NULL);
        } else {
            $this->setAmbassadorid($v->getAmbassadorid());
        }

        $this->aAmbassador = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildAmbassador object, it will not be re-added.
        if ($v !== null) {
            $v->addParticipant($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildAmbassador object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildAmbassador The associated ChildAmbassador object.
     * @throws PropelException
     */
    public function getAmbassador(ConnectionInterface $con = null)
    {
        if ($this->aAmbassador === null && (($this->ambassadorid !== "" && $this->ambassadorid !== null))) {
            $this->aAmbassador = ChildAmbassadorQuery::create()->findPk($this->ambassadorid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAmbassador->addParticipants($this);
             */
        }

        return $this->aAmbassador;
    }

    /**
     * Declares an association between this object and a ChildChallan object.
     *
     * @param  ChildChallan $v
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     * @throws PropelException
     */
    public function setChallanRelatedByRegistrationchallanid(ChildChallan $v = null)
    {
        if ($v === null) {
            $this->setRegistrationchallanid(NULL);
        } else {
            $this->setRegistrationchallanid($v->getChallanid());
        }

        $this->aChallanRelatedByRegistrationchallanid = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildChallan object, it will not be re-added.
        if ($v !== null) {
            $v->addParticipantRelatedByRegistrationchallanid($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildChallan object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildChallan The associated ChildChallan object.
     * @throws PropelException
     */
    public function getChallanRelatedByRegistrationchallanid(ConnectionInterface $con = null)
    {
        if ($this->aChallanRelatedByRegistrationchallanid === null && (($this->registrationchallanid !== "" && $this->registrationchallanid !== null))) {
            $this->aChallanRelatedByRegistrationchallanid = ChildChallanQuery::create()->findPk($this->registrationchallanid, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aChallanRelatedByRegistrationchallanid->addParticipantsRelatedByRegistrationchallanid($this);
             */
        }

        return $this->aChallanRelatedByRegistrationchallanid;
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
        if ('Eventparticipants' == $relationName) {
            return $this->initEventparticipantss();
        }
        if ('Sportsparticipants' == $relationName) {
            return $this->initSportsparticipantss();
        }
        if ('Sportsteam' == $relationName) {
            return $this->initSportsteams();
        }
        if ('Useraccount' == $relationName) {
            return $this->initUseraccounts();
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
     * If this ChildParticipant is new, it will return
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
                    ->filterByParticipant($this)
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
     * @return $this|ChildParticipant The current object (for fluent API support)
     */
    public function setAmbassadorParticipants(Collection $ambassadorParticipants, ConnectionInterface $con = null)
    {
        /** @var ChildAmbassadorParticipant[] $ambassadorParticipantsToDelete */
        $ambassadorParticipantsToDelete = $this->getAmbassadorParticipants(new Criteria(), $con)->diff($ambassadorParticipants);


        $this->ambassadorParticipantsScheduledForDeletion = $ambassadorParticipantsToDelete;

        foreach ($ambassadorParticipantsToDelete as $ambassadorParticipantRemoved) {
            $ambassadorParticipantRemoved->setParticipant(null);
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
                ->filterByParticipant($this)
                ->count($con);
        }

        return count($this->collAmbassadorParticipants);
    }

    /**
     * Method called to associate a ChildAmbassadorParticipant object to this object
     * through the ChildAmbassadorParticipant foreign key attribute.
     *
     * @param  ChildAmbassadorParticipant $l ChildAmbassadorParticipant
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
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
        $ambassadorParticipant->setParticipant($this);
    }

    /**
     * @param  ChildAmbassadorParticipant $ambassadorParticipant The ChildAmbassadorParticipant object to remove.
     * @return $this|ChildParticipant The current object (for fluent API support)
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
            $ambassadorParticipant->setParticipant(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participant is new, it will return
     * an empty collection; or if this Participant has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participant.
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
     * Otherwise if this Participant is new, it will return
     * an empty collection; or if this Participant has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participant.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participant is new, it will return
     * an empty collection; or if this Participant has previously
     * been saved, it will retrieve related AmbassadorParticipants from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participant.
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
     * Clears out the collEventparticipantss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addEventparticipantss()
     */
    public function clearEventparticipantss()
    {
        $this->collEventparticipantss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collEventparticipantss collection loaded partially.
     */
    public function resetPartialEventparticipantss($v = true)
    {
        $this->collEventparticipantssPartial = $v;
    }

    /**
     * Initializes the collEventparticipantss collection.
     *
     * By default this just sets the collEventparticipantss collection to an empty array (like clearcollEventparticipantss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initEventparticipantss($overrideExisting = true)
    {
        if (null !== $this->collEventparticipantss && !$overrideExisting) {
            return;
        }

        $collectionClassName = EventparticipantsTableMap::getTableMap()->getCollectionClassName();

        $this->collEventparticipantss = new $collectionClassName;
        $this->collEventparticipantss->setModel('\Model\Model\Eventparticipants');
    }

    /**
     * Gets an array of ChildEventparticipants objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParticipant is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildEventparticipants[] List of ChildEventparticipants objects
     * @throws PropelException
     */
    public function getEventparticipantss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collEventparticipantssPartial && !$this->isNew();
        if (null === $this->collEventparticipantss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collEventparticipantss) {
                // return empty collection
                $this->initEventparticipantss();
            } else {
                $collEventparticipantss = ChildEventparticipantsQuery::create(null, $criteria)
                    ->filterByParticipant($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collEventparticipantssPartial && count($collEventparticipantss)) {
                        $this->initEventparticipantss(false);

                        foreach ($collEventparticipantss as $obj) {
                            if (false == $this->collEventparticipantss->contains($obj)) {
                                $this->collEventparticipantss->append($obj);
                            }
                        }

                        $this->collEventparticipantssPartial = true;
                    }

                    return $collEventparticipantss;
                }

                if ($partial && $this->collEventparticipantss) {
                    foreach ($this->collEventparticipantss as $obj) {
                        if ($obj->isNew()) {
                            $collEventparticipantss[] = $obj;
                        }
                    }
                }

                $this->collEventparticipantss = $collEventparticipantss;
                $this->collEventparticipantssPartial = false;
            }
        }

        return $this->collEventparticipantss;
    }

    /**
     * Sets a collection of ChildEventparticipants objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $eventparticipantss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParticipant The current object (for fluent API support)
     */
    public function setEventparticipantss(Collection $eventparticipantss, ConnectionInterface $con = null)
    {
        /** @var ChildEventparticipants[] $eventparticipantssToDelete */
        $eventparticipantssToDelete = $this->getEventparticipantss(new Criteria(), $con)->diff($eventparticipantss);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->eventparticipantssScheduledForDeletion = clone $eventparticipantssToDelete;

        foreach ($eventparticipantssToDelete as $eventparticipantsRemoved) {
            $eventparticipantsRemoved->setParticipant(null);
        }

        $this->collEventparticipantss = null;
        foreach ($eventparticipantss as $eventparticipants) {
            $this->addEventparticipants($eventparticipants);
        }

        $this->collEventparticipantss = $eventparticipantss;
        $this->collEventparticipantssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Eventparticipants objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Eventparticipants objects.
     * @throws PropelException
     */
    public function countEventparticipantss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collEventparticipantssPartial && !$this->isNew();
        if (null === $this->collEventparticipantss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collEventparticipantss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getEventparticipantss());
            }

            $query = ChildEventparticipantsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParticipant($this)
                ->count($con);
        }

        return count($this->collEventparticipantss);
    }

    /**
     * Method called to associate a ChildEventparticipants object to this object
     * through the ChildEventparticipants foreign key attribute.
     *
     * @param  ChildEventparticipants $l ChildEventparticipants
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function addEventparticipants(ChildEventparticipants $l)
    {
        if ($this->collEventparticipantss === null) {
            $this->initEventparticipantss();
            $this->collEventparticipantssPartial = true;
        }

        if (!$this->collEventparticipantss->contains($l)) {
            $this->doAddEventparticipants($l);

            if ($this->eventparticipantssScheduledForDeletion and $this->eventparticipantssScheduledForDeletion->contains($l)) {
                $this->eventparticipantssScheduledForDeletion->remove($this->eventparticipantssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildEventparticipants $eventparticipants The ChildEventparticipants object to add.
     */
    protected function doAddEventparticipants(ChildEventparticipants $eventparticipants)
    {
        $this->collEventparticipantss[]= $eventparticipants;
        $eventparticipants->setParticipant($this);
    }

    /**
     * @param  ChildEventparticipants $eventparticipants The ChildEventparticipants object to remove.
     * @return $this|ChildParticipant The current object (for fluent API support)
     */
    public function removeEventparticipants(ChildEventparticipants $eventparticipants)
    {
        if ($this->getEventparticipantss()->contains($eventparticipants)) {
            $pos = $this->collEventparticipantss->search($eventparticipants);
            $this->collEventparticipantss->remove($pos);
            if (null === $this->eventparticipantssScheduledForDeletion) {
                $this->eventparticipantssScheduledForDeletion = clone $this->collEventparticipantss;
                $this->eventparticipantssScheduledForDeletion->clear();
            }
            $this->eventparticipantssScheduledForDeletion[]= clone $eventparticipants;
            $eventparticipants->setParticipant(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participant is new, it will return
     * an empty collection; or if this Participant has previously
     * been saved, it will retrieve related Eventparticipantss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participant.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildEventparticipants[] List of ChildEventparticipants objects
     */
    public function getEventparticipantssJoinEvents(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildEventparticipantsQuery::create(null, $criteria);
        $query->joinWith('Events', $joinBehavior);

        return $this->getEventparticipantss($query, $con);
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
     * If this ChildParticipant is new, it will return
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
                    ->filterByParticipant($this)
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
     * @return $this|ChildParticipant The current object (for fluent API support)
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
            $sportsparticipantsRemoved->setParticipant(null);
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
                ->filterByParticipant($this)
                ->count($con);
        }

        return count($this->collSportsparticipantss);
    }

    /**
     * Method called to associate a ChildSportsparticipants object to this object
     * through the ChildSportsparticipants foreign key attribute.
     *
     * @param  ChildSportsparticipants $l ChildSportsparticipants
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
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
        $sportsparticipants->setParticipant($this);
    }

    /**
     * @param  ChildSportsparticipants $sportsparticipants The ChildSportsparticipants object to remove.
     * @return $this|ChildParticipant The current object (for fluent API support)
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
            $sportsparticipants->setParticipant(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participant is new, it will return
     * an empty collection; or if this Participant has previously
     * been saved, it will retrieve related Sportsparticipantss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participant.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSportsparticipants[] List of ChildSportsparticipants objects
     */
    public function getSportsparticipantssJoinSportsteam(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSportsparticipantsQuery::create(null, $criteria);
        $query->joinWith('Sportsteam', $joinBehavior);

        return $this->getSportsparticipantss($query, $con);
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
     * If this ChildParticipant is new, it will return
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
                    ->filterByParticipant($this)
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
     * @return $this|ChildParticipant The current object (for fluent API support)
     */
    public function setSportsteams(Collection $sportsteams, ConnectionInterface $con = null)
    {
        /** @var ChildSportsteam[] $sportsteamsToDelete */
        $sportsteamsToDelete = $this->getSportsteams(new Criteria(), $con)->diff($sportsteams);


        $this->sportsteamsScheduledForDeletion = $sportsteamsToDelete;

        foreach ($sportsteamsToDelete as $sportsteamRemoved) {
            $sportsteamRemoved->setParticipant(null);
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
                ->filterByParticipant($this)
                ->count($con);
        }

        return count($this->collSportsteams);
    }

    /**
     * Method called to associate a ChildSportsteam object to this object
     * through the ChildSportsteam foreign key attribute.
     *
     * @param  ChildSportsteam $l ChildSportsteam
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
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
        $sportsteam->setParticipant($this);
    }

    /**
     * @param  ChildSportsteam $sportsteam The ChildSportsteam object to remove.
     * @return $this|ChildParticipant The current object (for fluent API support)
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
            $sportsteam->setParticipant(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Participant is new, it will return
     * an empty collection; or if this Participant has previously
     * been saved, it will retrieve related Sportsteams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Participant.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildSportsteam[] List of ChildSportsteam objects
     */
    public function getSportsteamsJoinSports(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildSportsteamQuery::create(null, $criteria);
        $query->joinWith('Sports', $joinBehavior);

        return $this->getSportsteams($query, $con);
    }

    /**
     * Clears out the collUseraccounts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUseraccounts()
     */
    public function clearUseraccounts()
    {
        $this->collUseraccounts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUseraccounts collection loaded partially.
     */
    public function resetPartialUseraccounts($v = true)
    {
        $this->collUseraccountsPartial = $v;
    }

    /**
     * Initializes the collUseraccounts collection.
     *
     * By default this just sets the collUseraccounts collection to an empty array (like clearcollUseraccounts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUseraccounts($overrideExisting = true)
    {
        if (null !== $this->collUseraccounts && !$overrideExisting) {
            return;
        }

        $collectionClassName = UseraccountTableMap::getTableMap()->getCollectionClassName();

        $this->collUseraccounts = new $collectionClassName;
        $this->collUseraccounts->setModel('\Model\Model\Useraccount');
    }

    /**
     * Gets an array of ChildUseraccount objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildParticipant is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUseraccount[] List of ChildUseraccount objects
     * @throws PropelException
     */
    public function getUseraccounts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUseraccountsPartial && !$this->isNew();
        if (null === $this->collUseraccounts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUseraccounts) {
                // return empty collection
                $this->initUseraccounts();
            } else {
                $collUseraccounts = ChildUseraccountQuery::create(null, $criteria)
                    ->filterByParticipant($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUseraccountsPartial && count($collUseraccounts)) {
                        $this->initUseraccounts(false);

                        foreach ($collUseraccounts as $obj) {
                            if (false == $this->collUseraccounts->contains($obj)) {
                                $this->collUseraccounts->append($obj);
                            }
                        }

                        $this->collUseraccountsPartial = true;
                    }

                    return $collUseraccounts;
                }

                if ($partial && $this->collUseraccounts) {
                    foreach ($this->collUseraccounts as $obj) {
                        if ($obj->isNew()) {
                            $collUseraccounts[] = $obj;
                        }
                    }
                }

                $this->collUseraccounts = $collUseraccounts;
                $this->collUseraccountsPartial = false;
            }
        }

        return $this->collUseraccounts;
    }

    /**
     * Sets a collection of ChildUseraccount objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $useraccounts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildParticipant The current object (for fluent API support)
     */
    public function setUseraccounts(Collection $useraccounts, ConnectionInterface $con = null)
    {
        /** @var ChildUseraccount[] $useraccountsToDelete */
        $useraccountsToDelete = $this->getUseraccounts(new Criteria(), $con)->diff($useraccounts);


        $this->useraccountsScheduledForDeletion = $useraccountsToDelete;

        foreach ($useraccountsToDelete as $useraccountRemoved) {
            $useraccountRemoved->setParticipant(null);
        }

        $this->collUseraccounts = null;
        foreach ($useraccounts as $useraccount) {
            $this->addUseraccount($useraccount);
        }

        $this->collUseraccounts = $useraccounts;
        $this->collUseraccountsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Useraccount objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Useraccount objects.
     * @throws PropelException
     */
    public function countUseraccounts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUseraccountsPartial && !$this->isNew();
        if (null === $this->collUseraccounts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUseraccounts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUseraccounts());
            }

            $query = ChildUseraccountQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParticipant($this)
                ->count($con);
        }

        return count($this->collUseraccounts);
    }

    /**
     * Method called to associate a ChildUseraccount object to this object
     * through the ChildUseraccount foreign key attribute.
     *
     * @param  ChildUseraccount $l ChildUseraccount
     * @return $this|\Model\Model\Participant The current object (for fluent API support)
     */
    public function addUseraccount(ChildUseraccount $l)
    {
        if ($this->collUseraccounts === null) {
            $this->initUseraccounts();
            $this->collUseraccountsPartial = true;
        }

        if (!$this->collUseraccounts->contains($l)) {
            $this->doAddUseraccount($l);

            if ($this->useraccountsScheduledForDeletion and $this->useraccountsScheduledForDeletion->contains($l)) {
                $this->useraccountsScheduledForDeletion->remove($this->useraccountsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildUseraccount $useraccount The ChildUseraccount object to add.
     */
    protected function doAddUseraccount(ChildUseraccount $useraccount)
    {
        $this->collUseraccounts[]= $useraccount;
        $useraccount->setParticipant($this);
    }

    /**
     * @param  ChildUseraccount $useraccount The ChildUseraccount object to remove.
     * @return $this|ChildParticipant The current object (for fluent API support)
     */
    public function removeUseraccount(ChildUseraccount $useraccount)
    {
        if ($this->getUseraccounts()->contains($useraccount)) {
            $pos = $this->collUseraccounts->search($useraccount);
            $this->collUseraccounts->remove($pos);
            if (null === $this->useraccountsScheduledForDeletion) {
                $this->useraccountsScheduledForDeletion = clone $this->collUseraccounts;
                $this->useraccountsScheduledForDeletion->clear();
            }
            $this->useraccountsScheduledForDeletion[]= clone $useraccount;
            $useraccount->setParticipant(null);
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
        if (null !== $this->aChallanRelatedByAccomodationchallanid) {
            $this->aChallanRelatedByAccomodationchallanid->removeParticipantRelatedByAccomodationchallanid($this);
        }
        if (null !== $this->aAmbassador) {
            $this->aAmbassador->removeParticipant($this);
        }
        if (null !== $this->aChallanRelatedByRegistrationchallanid) {
            $this->aChallanRelatedByRegistrationchallanid->removeParticipantRelatedByRegistrationchallanid($this);
        }
        $this->participantid = null;
        $this->cnic = null;
        $this->registrationchallanid = null;
        $this->accomodationchallanid = null;
        $this->firstname = null;
        $this->lastname = null;
        $this->gender = null;
        $this->address = null;
        $this->phoneno = null;
        $this->nustregno = null;
        $this->ambassadorid = null;
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
            if ($this->collAmbassadorParticipants) {
                foreach ($this->collAmbassadorParticipants as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collEventparticipantss) {
                foreach ($this->collEventparticipantss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSportsparticipantss) {
                foreach ($this->collSportsparticipantss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSportsteams) {
                foreach ($this->collSportsteams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUseraccounts) {
                foreach ($this->collUseraccounts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collAmbassadorParticipants = null;
        $this->collEventparticipantss = null;
        $this->collSportsparticipantss = null;
        $this->collSportsteams = null;
        $this->collUseraccounts = null;
        $this->aChallanRelatedByAccomodationchallanid = null;
        $this->aAmbassador = null;
        $this->aChallanRelatedByRegistrationchallanid = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ParticipantTableMap::DEFAULT_STRING_FORMAT);
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
