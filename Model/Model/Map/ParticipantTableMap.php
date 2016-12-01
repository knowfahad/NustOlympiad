<?php

namespace Model\Model\Map;

use Model\Model\Participant;
use Model\Model\ParticipantQuery;
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
 * This class defines the structure of the 'participant' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ParticipantTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Model.Map.ParticipantTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'participant';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Model\\Participant';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Model.Participant';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the ParticipantID field
     */
    const COL_PARTICIPANTID = 'participant.ParticipantID';

    /**
     * the column name for the CNIC field
     */
    const COL_CNIC = 'participant.CNIC';

    /**
     * the column name for the RegistrationChallanID field
     */
    const COL_REGISTRATIONCHALLANID = 'participant.RegistrationChallanID';

    /**
     * the column name for the AccomodationChallanID field
     */
    const COL_ACCOMODATIONCHALLANID = 'participant.AccomodationChallanID';

    /**
     * the column name for the FirstName field
     */
    const COL_FIRSTNAME = 'participant.FirstName';

    /**
     * the column name for the LastName field
     */
    const COL_LASTNAME = 'participant.LastName';

    /**
     * the column name for the Gender field
     */
    const COL_GENDER = 'participant.Gender';

    /**
     * the column name for the Address field
     */
    const COL_ADDRESS = 'participant.Address';

    /**
     * the column name for the PhoneNo field
     */
    const COL_PHONENO = 'participant.PhoneNo';

    /**
     * the column name for the NUSTRegNo field
     */
    const COL_NUSTREGNO = 'participant.NUSTRegNo';

    /**
     * the column name for the AmbassadorID field
     */
    const COL_AMBASSADORID = 'participant.AmbassadorID';

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
        self::TYPE_PHPNAME       => array('Participantid', 'Cnic', 'Registrationchallanid', 'Accomodationchallanid', 'Firstname', 'Lastname', 'Gender', 'Address', 'Phoneno', 'Nustregno', 'Ambassadorid', ),
        self::TYPE_CAMELNAME     => array('participantid', 'cnic', 'registrationchallanid', 'accomodationchallanid', 'firstname', 'lastname', 'gender', 'address', 'phoneno', 'nustregno', 'ambassadorid', ),
        self::TYPE_COLNAME       => array(ParticipantTableMap::COL_PARTICIPANTID, ParticipantTableMap::COL_CNIC, ParticipantTableMap::COL_REGISTRATIONCHALLANID, ParticipantTableMap::COL_ACCOMODATIONCHALLANID, ParticipantTableMap::COL_FIRSTNAME, ParticipantTableMap::COL_LASTNAME, ParticipantTableMap::COL_GENDER, ParticipantTableMap::COL_ADDRESS, ParticipantTableMap::COL_PHONENO, ParticipantTableMap::COL_NUSTREGNO, ParticipantTableMap::COL_AMBASSADORID, ),
        self::TYPE_FIELDNAME     => array('ParticipantID', 'CNIC', 'RegistrationChallanID', 'AccomodationChallanID', 'FirstName', 'LastName', 'Gender', 'Address', 'PhoneNo', 'NUSTRegNo', 'AmbassadorID', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Participantid' => 0, 'Cnic' => 1, 'Registrationchallanid' => 2, 'Accomodationchallanid' => 3, 'Firstname' => 4, 'Lastname' => 5, 'Gender' => 6, 'Address' => 7, 'Phoneno' => 8, 'Nustregno' => 9, 'Ambassadorid' => 10, ),
        self::TYPE_CAMELNAME     => array('participantid' => 0, 'cnic' => 1, 'registrationchallanid' => 2, 'accomodationchallanid' => 3, 'firstname' => 4, 'lastname' => 5, 'gender' => 6, 'address' => 7, 'phoneno' => 8, 'nustregno' => 9, 'ambassadorid' => 10, ),
        self::TYPE_COLNAME       => array(ParticipantTableMap::COL_PARTICIPANTID => 0, ParticipantTableMap::COL_CNIC => 1, ParticipantTableMap::COL_REGISTRATIONCHALLANID => 2, ParticipantTableMap::COL_ACCOMODATIONCHALLANID => 3, ParticipantTableMap::COL_FIRSTNAME => 4, ParticipantTableMap::COL_LASTNAME => 5, ParticipantTableMap::COL_GENDER => 6, ParticipantTableMap::COL_ADDRESS => 7, ParticipantTableMap::COL_PHONENO => 8, ParticipantTableMap::COL_NUSTREGNO => 9, ParticipantTableMap::COL_AMBASSADORID => 10, ),
        self::TYPE_FIELDNAME     => array('ParticipantID' => 0, 'CNIC' => 1, 'RegistrationChallanID' => 2, 'AccomodationChallanID' => 3, 'FirstName' => 4, 'LastName' => 5, 'Gender' => 6, 'Address' => 7, 'PhoneNo' => 8, 'NUSTRegNo' => 9, 'AmbassadorID' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('participant');
        $this->setPhpName('Participant');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Model\\Participant');
        $this->setPackage('Model.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('ParticipantID', 'Participantid', 'INTEGER', true, 10, null);
        $this->addColumn('CNIC', 'Cnic', 'VARCHAR', true, 13, null);
        $this->addForeignKey('RegistrationChallanID', 'Registrationchallanid', 'VARCHAR', 'challan', 'ChallanID', true, 30, null);
        $this->addForeignKey('AccomodationChallanID', 'Accomodationchallanid', 'VARCHAR', 'challan', 'ChallanID', false, 30, null);
        $this->addColumn('FirstName', 'Firstname', 'VARCHAR', true, 25, null);
        $this->addColumn('LastName', 'Lastname', 'VARCHAR', false, 15, null);
        $this->addColumn('Gender', 'Gender', 'VARCHAR', true, 6, 'Male');
        $this->addColumn('Address', 'Address', 'VARCHAR', false, 100, null);
        $this->addColumn('PhoneNo', 'Phoneno', 'VARCHAR', true, 13, null);
        $this->addColumn('NUSTRegNo', 'Nustregno', 'VARCHAR', false, 35, null);
        $this->addForeignKey('AmbassadorID', 'Ambassadorid', 'VARCHAR', 'ambassador', 'AmbassadorID', false, 20, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ChallanRelatedByAccomodationchallanid', '\\Model\\Model\\Challan', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':AccomodationChallanID',
    1 => ':ChallanID',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('Ambassador', '\\Model\\Model\\Ambassador', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':AmbassadorID',
    1 => ':AmbassadorID',
  ),
), 'SET NULL', 'CASCADE', null, false);
        $this->addRelation('ChallanRelatedByRegistrationchallanid', '\\Model\\Model\\Challan', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':RegistrationChallanID',
    1 => ':ChallanID',
  ),
), null, 'CASCADE', null, false);
        $this->addRelation('AmbassadorParticipant', '\\Model\\Model\\AmbassadorParticipant', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ParticipantCNIC',
    1 => ':CNIC',
  ),
), 'CASCADE', 'CASCADE', 'AmbassadorParticipants', false);
        $this->addRelation('Eventparticipants', '\\Model\\Model\\Eventparticipants', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ParticipantCNIC',
    1 => ':CNIC',
  ),
), null, null, 'Eventparticipantss', false);
        $this->addRelation('Sportsparticipants', '\\Model\\Model\\Sportsparticipants', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ParticipantCNIC',
    1 => ':CNIC',
  ),
), 'CASCADE', 'CASCADE', 'Sportsparticipantss', false);
        $this->addRelation('Sportsteam', '\\Model\\Model\\Sportsteam', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':HeadCNIC',
    1 => ':CNIC',
  ),
), 'CASCADE', 'CASCADE', 'Sportsteams', false);
        $this->addRelation('Useraccount', '\\Model\\Model\\Useraccount', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':ParticipantCNIC',
    1 => ':CNIC',
  ),
), 'CASCADE', 'CASCADE', 'Useraccounts', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to participant     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AmbassadorParticipantTableMap::clearInstancePool();
        SportsparticipantsTableMap::clearInstancePool();
        SportsteamTableMap::clearInstancePool();
        UseraccountTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Participantid', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? ParticipantTableMap::CLASS_DEFAULT : ParticipantTableMap::OM_CLASS;
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
     * @return array           (Participant object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ParticipantTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ParticipantTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ParticipantTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ParticipantTableMap::OM_CLASS;
            /** @var Participant $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ParticipantTableMap::addInstanceToPool($obj, $key);
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
            $key = ParticipantTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ParticipantTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Participant $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ParticipantTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ParticipantTableMap::COL_PARTICIPANTID);
            $criteria->addSelectColumn(ParticipantTableMap::COL_CNIC);
            $criteria->addSelectColumn(ParticipantTableMap::COL_REGISTRATIONCHALLANID);
            $criteria->addSelectColumn(ParticipantTableMap::COL_ACCOMODATIONCHALLANID);
            $criteria->addSelectColumn(ParticipantTableMap::COL_FIRSTNAME);
            $criteria->addSelectColumn(ParticipantTableMap::COL_LASTNAME);
            $criteria->addSelectColumn(ParticipantTableMap::COL_GENDER);
            $criteria->addSelectColumn(ParticipantTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(ParticipantTableMap::COL_PHONENO);
            $criteria->addSelectColumn(ParticipantTableMap::COL_NUSTREGNO);
            $criteria->addSelectColumn(ParticipantTableMap::COL_AMBASSADORID);
        } else {
            $criteria->addSelectColumn($alias . '.ParticipantID');
            $criteria->addSelectColumn($alias . '.CNIC');
            $criteria->addSelectColumn($alias . '.RegistrationChallanID');
            $criteria->addSelectColumn($alias . '.AccomodationChallanID');
            $criteria->addSelectColumn($alias . '.FirstName');
            $criteria->addSelectColumn($alias . '.LastName');
            $criteria->addSelectColumn($alias . '.Gender');
            $criteria->addSelectColumn($alias . '.Address');
            $criteria->addSelectColumn($alias . '.PhoneNo');
            $criteria->addSelectColumn($alias . '.NUSTRegNo');
            $criteria->addSelectColumn($alias . '.AmbassadorID');
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
        return Propel::getServiceContainer()->getDatabaseMap(ParticipantTableMap::DATABASE_NAME)->getTable(ParticipantTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ParticipantTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ParticipantTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ParticipantTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Participant or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Participant object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Model\Participant) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ParticipantTableMap::DATABASE_NAME);
            $criteria->add(ParticipantTableMap::COL_PARTICIPANTID, (array) $values, Criteria::IN);
        }

        $query = ParticipantQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ParticipantTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ParticipantTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the participant table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ParticipantQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Participant or Criteria object.
     *
     * @param mixed               $criteria Criteria or Participant object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Participant object
        }

        if ($criteria->containsKey(ParticipantTableMap::COL_PARTICIPANTID) && $criteria->keyContainsValue(ParticipantTableMap::COL_PARTICIPANTID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ParticipantTableMap::COL_PARTICIPANTID.')');
        }


        // Set the correct dbName
        $query = ParticipantQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ParticipantTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ParticipantTableMap::buildTableMap();
