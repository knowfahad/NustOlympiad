<?php

namespace Model\Model\Map;

use Model\Model\Ambassador;
use Model\Model\AmbassadorQuery;
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
 * This class defines the structure of the 'ambassador' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class AmbassadorTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Model.Map.AmbassadorTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'ambassador';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Model\\Ambassador';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Model.Ambassador';

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
     * the column name for the AmbassadorID field
     */
    const COL_AMBASSADORID = 'ambassador.AmbassadorID';

    /**
     * the column name for the CNIC field
     */
    const COL_CNIC = 'ambassador.CNIC';

    /**
     * the column name for the FirstName field
     */
    const COL_FIRSTNAME = 'ambassador.FirstName';

    /**
     * the column name for the LastName field
     */
    const COL_LASTNAME = 'ambassador.LastName';

    /**
     * the column name for the Email field
     */
    const COL_EMAIL = 'ambassador.Email';

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
        self::TYPE_PHPNAME       => array('Ambassadorid', 'Cnic', 'Firstname', 'Lastname', 'Email', ),
        self::TYPE_CAMELNAME     => array('ambassadorid', 'cnic', 'firstname', 'lastname', 'email', ),
        self::TYPE_COLNAME       => array(AmbassadorTableMap::COL_AMBASSADORID, AmbassadorTableMap::COL_CNIC, AmbassadorTableMap::COL_FIRSTNAME, AmbassadorTableMap::COL_LASTNAME, AmbassadorTableMap::COL_EMAIL, ),
        self::TYPE_FIELDNAME     => array('AmbassadorID', 'CNIC', 'FirstName', 'LastName', 'Email', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Ambassadorid' => 0, 'Cnic' => 1, 'Firstname' => 2, 'Lastname' => 3, 'Email' => 4, ),
        self::TYPE_CAMELNAME     => array('ambassadorid' => 0, 'cnic' => 1, 'firstname' => 2, 'lastname' => 3, 'email' => 4, ),
        self::TYPE_COLNAME       => array(AmbassadorTableMap::COL_AMBASSADORID => 0, AmbassadorTableMap::COL_CNIC => 1, AmbassadorTableMap::COL_FIRSTNAME => 2, AmbassadorTableMap::COL_LASTNAME => 3, AmbassadorTableMap::COL_EMAIL => 4, ),
        self::TYPE_FIELDNAME     => array('AmbassadorID' => 0, 'CNIC' => 1, 'FirstName' => 2, 'LastName' => 3, 'Email' => 4, ),
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
        $this->setName('ambassador');
        $this->setPhpName('Ambassador');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Model\\Ambassador');
        $this->setPackage('Model.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('AmbassadorID', 'Ambassadorid', 'VARCHAR', true, 20, null);
        $this->addColumn('CNIC', 'Cnic', 'VARCHAR', true, 13, null);
        $this->addColumn('FirstName', 'Firstname', 'VARCHAR', true, 25, null);
        $this->addColumn('LastName', 'Lastname', 'VARCHAR', false, 15, null);
        $this->addColumn('Email', 'Email', 'VARCHAR', true, 100, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AmbassadorParticipant', '\\Model\\Model\\AmbassadorParticipant', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':AmbassadorID',
    1 => ':AmbassadorID',
  ),
), 'CASCADE', 'CASCADE', 'AmbassadorParticipants', false);
        $this->addRelation('Participant', '\\Model\\Model\\Participant', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':AmbassadorID',
    1 => ':AmbassadorID',
  ),
), 'SET NULL', 'CASCADE', 'Participants', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to ambassador     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AmbassadorParticipantTableMap::clearInstancePool();
        ParticipantTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Ambassadorid', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? AmbassadorTableMap::CLASS_DEFAULT : AmbassadorTableMap::OM_CLASS;
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
     * @return array           (Ambassador object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = AmbassadorTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = AmbassadorTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + AmbassadorTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = AmbassadorTableMap::OM_CLASS;
            /** @var Ambassador $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            AmbassadorTableMap::addInstanceToPool($obj, $key);
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
            $key = AmbassadorTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = AmbassadorTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Ambassador $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                AmbassadorTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(AmbassadorTableMap::COL_AMBASSADORID);
            $criteria->addSelectColumn(AmbassadorTableMap::COL_CNIC);
            $criteria->addSelectColumn(AmbassadorTableMap::COL_FIRSTNAME);
            $criteria->addSelectColumn(AmbassadorTableMap::COL_LASTNAME);
            $criteria->addSelectColumn(AmbassadorTableMap::COL_EMAIL);
        } else {
            $criteria->addSelectColumn($alias . '.AmbassadorID');
            $criteria->addSelectColumn($alias . '.CNIC');
            $criteria->addSelectColumn($alias . '.FirstName');
            $criteria->addSelectColumn($alias . '.LastName');
            $criteria->addSelectColumn($alias . '.Email');
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
        return Propel::getServiceContainer()->getDatabaseMap(AmbassadorTableMap::DATABASE_NAME)->getTable(AmbassadorTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(AmbassadorTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(AmbassadorTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new AmbassadorTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Ambassador or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Ambassador object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Model\Ambassador) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(AmbassadorTableMap::DATABASE_NAME);
            $criteria->add(AmbassadorTableMap::COL_AMBASSADORID, (array) $values, Criteria::IN);
        }

        $query = AmbassadorQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            AmbassadorTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                AmbassadorTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the ambassador table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return AmbassadorQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Ambassador or Criteria object.
     *
     * @param mixed               $criteria Criteria or Ambassador object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Ambassador object
        }


        // Set the correct dbName
        $query = AmbassadorQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // AmbassadorTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
AmbassadorTableMap::buildTableMap();
