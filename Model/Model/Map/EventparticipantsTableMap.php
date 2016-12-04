<?php

namespace Model\Model\Map;

use Model\Model\Eventparticipants;
use Model\Model\EventparticipantsQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'eventparticipants' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EventparticipantsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Model.Map.EventparticipantsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'eventparticipants';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Model\\Eventparticipants';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Model.Eventparticipants';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the ParticipantCNIC field
     */
    const COL_PARTICIPANTCNIC = 'eventparticipants.ParticipantCNIC';

    /**
     * the column name for the EventID field
     */
    const COL_EVENTID = 'eventparticipants.EventID';

    /**
     * the column name for the ChallanID field
     */
    const COL_CHALLANID = 'eventparticipants.ChallanID';

    /**
     * the column name for the PaymentStatus field
     */
    const COL_PAYMENTSTATUS = 'eventparticipants.PaymentStatus';

    /**
     * the column name for the DueDate field
     */
    const COL_DUEDATE = 'eventparticipants.DueDate';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Participantcnic', 'Eventid', 'Challanid', 'Paymentstatus', 'Duedate', ),
        self::TYPE_CAMELNAME     => array('participantcnic', 'eventid', 'challanid', 'paymentstatus', 'duedate', ),
        self::TYPE_COLNAME       => array(EventparticipantsTableMap::COL_PARTICIPANTCNIC, EventparticipantsTableMap::COL_EVENTID, EventparticipantsTableMap::COL_CHALLANID, EventparticipantsTableMap::COL_PAYMENTSTATUS, EventparticipantsTableMap::COL_DUEDATE, ),
        self::TYPE_FIELDNAME     => array('ParticipantCNIC', 'EventID', 'ChallanID', 'PaymentStatus', 'DueDate', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Participantcnic' => 0, 'Eventid' => 1, 'Challanid' => 2, 'Paymentstatus' => 3, 'Duedate' => 4, ),
        self::TYPE_CAMELNAME     => array('participantcnic' => 0, 'eventid' => 1, 'challanid' => 2, 'paymentstatus' => 3, 'duedate' => 4, ),
        self::TYPE_COLNAME       => array(EventparticipantsTableMap::COL_PARTICIPANTCNIC => 0, EventparticipantsTableMap::COL_EVENTID => 1, EventparticipantsTableMap::COL_CHALLANID => 2, EventparticipantsTableMap::COL_PAYMENTSTATUS => 3, EventparticipantsTableMap::COL_DUEDATE => 4, ),
        self::TYPE_FIELDNAME     => array('ParticipantCNIC' => 0, 'EventID' => 1, 'ChallanID' => 2, 'PaymentStatus' => 3, 'DueDate' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('eventparticipants');
        $this->setPhpName('Eventparticipants');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Model\\Eventparticipants');
        $this->setPackage('Model.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('ParticipantCNIC', 'Participantcnic', 'VARCHAR' , 'participant', 'CNIC', true, 13, null);
        $this->addForeignPrimaryKey('EventID', 'Eventid', 'INTEGER' , 'events', 'EventID', true, null, null);
        $this->addColumn('ChallanID', 'Challanid', 'VARCHAR', true, 30, null);
        $this->addColumn('PaymentStatus', 'Paymentstatus', 'INTEGER', true, 1, null);
        $this->addColumn('DueDate', 'Duedate', 'DATE', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Participant', '\\Model\\Model\\Participant', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':ParticipantCNIC',
    1 => ':CNIC',
  ),
), null, null, null, false);
        $this->addRelation('Events', '\\Model\\Model\\Events', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':EventID',
    1 => ':EventID',
  ),
), null, 'CASCADE', null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Model\Model\Eventparticipants $obj A \Model\Model\Eventparticipants object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getParticipantcnic() || is_scalar($obj->getParticipantcnic()) || is_callable([$obj->getParticipantcnic(), '__toString']) ? (string) $obj->getParticipantcnic() : $obj->getParticipantcnic()), (null === $obj->getEventid() || is_scalar($obj->getEventid()) || is_callable([$obj->getEventid(), '__toString']) ? (string) $obj->getEventid() : $obj->getEventid())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Model\Model\Eventparticipants object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Model\Model\Eventparticipants) {
                $key = serialize([(null === $value->getParticipantcnic() || is_scalar($value->getParticipantcnic()) || is_callable([$value->getParticipantcnic(), '__toString']) ? (string) $value->getParticipantcnic() : $value->getParticipantcnic()), (null === $value->getEventid() || is_scalar($value->getEventid()) || is_callable([$value->getEventid(), '__toString']) ? (string) $value->getEventid() : $value->getEventid())]);

            } elseif (is_array($value) && count($value) === 2) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Model\Model\Eventparticipants object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)])]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Participantcnic', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('Eventid', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? EventparticipantsTableMap::CLASS_DEFAULT : EventparticipantsTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Eventparticipants object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EventparticipantsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EventparticipantsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventparticipantsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventparticipantsTableMap::OM_CLASS;
            /** @var Eventparticipants $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventparticipantsTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = EventparticipantsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EventparticipantsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Eventparticipants $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EventparticipantsTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(EventparticipantsTableMap::COL_PARTICIPANTCNIC);
            $criteria->addSelectColumn(EventparticipantsTableMap::COL_EVENTID);
            $criteria->addSelectColumn(EventparticipantsTableMap::COL_CHALLANID);
            $criteria->addSelectColumn(EventparticipantsTableMap::COL_PAYMENTSTATUS);
            $criteria->addSelectColumn(EventparticipantsTableMap::COL_DUEDATE);
        } else {
            $criteria->addSelectColumn($alias . '.ParticipantCNIC');
            $criteria->addSelectColumn($alias . '.EventID');
            $criteria->addSelectColumn($alias . '.ChallanID');
            $criteria->addSelectColumn($alias . '.PaymentStatus');
            $criteria->addSelectColumn($alias . '.DueDate');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(EventparticipantsTableMap::DATABASE_NAME)->getTable(EventparticipantsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EventparticipantsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EventparticipantsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EventparticipantsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Eventparticipants or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Eventparticipants object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventparticipantsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Model\Eventparticipants) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventparticipantsTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(EventparticipantsTableMap::COL_PARTICIPANTCNIC, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(EventparticipantsTableMap::COL_EVENTID, $value[1]));
                $criteria->addOr($criterion);
            }
        }

        $query = EventparticipantsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventparticipantsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EventparticipantsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the eventparticipants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EventparticipantsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Eventparticipants or Criteria object.
     *
     * @param mixed               $criteria Criteria or Eventparticipants object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventparticipantsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Eventparticipants object
        }


        // Set the correct dbName
        $query = EventparticipantsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EventparticipantsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EventparticipantsTableMap::buildTableMap();
