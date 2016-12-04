<?php

namespace Model\Model\Map;

use Model\Model\Useraccount;
use Model\Model\UseraccountQuery;
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
 * This class defines the structure of the 'useraccount' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UseraccountTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Model.Model.Map.UseraccountTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'useraccount';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Model\\Model\\Useraccount';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Model.Model.Useraccount';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 7;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 7;

    /**
     * the column name for the Username field
     */
    const COL_USERNAME = 'useraccount.Username';

    /**
     * the column name for the ParticipantCNIC field
     */
    const COL_PARTICIPANTCNIC = 'useraccount.ParticipantCNIC';

    /**
     * the column name for the Email field
     */
    const COL_EMAIL = 'useraccount.Email';

    /**
     * the column name for the Password field
     */
    const COL_PASSWORD = 'useraccount.Password';

    /**
     * the column name for the AccountStatus field
     */
    const COL_ACCOUNTSTATUS = 'useraccount.AccountStatus';

    /**
     * the column name for the ActivationCode field
     */
    const COL_ACTIVATIONCODE = 'useraccount.ActivationCode';

    /**
     * the column name for the ResetCode field
     */
    const COL_RESETCODE = 'useraccount.ResetCode';

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
        self::TYPE_PHPNAME       => array('Username', 'Participantcnic', 'Email', 'Password', 'Accountstatus', 'Activationcode', 'Resetcode', ),
        self::TYPE_CAMELNAME     => array('username', 'participantcnic', 'email', 'password', 'accountstatus', 'activationcode', 'resetcode', ),
        self::TYPE_COLNAME       => array(UseraccountTableMap::COL_USERNAME, UseraccountTableMap::COL_PARTICIPANTCNIC, UseraccountTableMap::COL_EMAIL, UseraccountTableMap::COL_PASSWORD, UseraccountTableMap::COL_ACCOUNTSTATUS, UseraccountTableMap::COL_ACTIVATIONCODE, UseraccountTableMap::COL_RESETCODE, ),
        self::TYPE_FIELDNAME     => array('Username', 'ParticipantCNIC', 'Email', 'Password', 'AccountStatus', 'ActivationCode', 'ResetCode', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Username' => 0, 'Participantcnic' => 1, 'Email' => 2, 'Password' => 3, 'Accountstatus' => 4, 'Activationcode' => 5, 'Resetcode' => 6, ),
        self::TYPE_CAMELNAME     => array('username' => 0, 'participantcnic' => 1, 'email' => 2, 'password' => 3, 'accountstatus' => 4, 'activationcode' => 5, 'resetcode' => 6, ),
        self::TYPE_COLNAME       => array(UseraccountTableMap::COL_USERNAME => 0, UseraccountTableMap::COL_PARTICIPANTCNIC => 1, UseraccountTableMap::COL_EMAIL => 2, UseraccountTableMap::COL_PASSWORD => 3, UseraccountTableMap::COL_ACCOUNTSTATUS => 4, UseraccountTableMap::COL_ACTIVATIONCODE => 5, UseraccountTableMap::COL_RESETCODE => 6, ),
        self::TYPE_FIELDNAME     => array('Username' => 0, 'ParticipantCNIC' => 1, 'Email' => 2, 'Password' => 3, 'AccountStatus' => 4, 'ActivationCode' => 5, 'ResetCode' => 6, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, )
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
        $this->setName('useraccount');
        $this->setPhpName('Useraccount');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Model\\Model\\Useraccount');
        $this->setPackage('Model.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('Username', 'Username', 'VARCHAR', true, 15, null);
        $this->addForeignKey('ParticipantCNIC', 'Participantcnic', 'VARCHAR', 'participant', 'CNIC', true, 13, null);
        $this->addColumn('Email', 'Email', 'VARCHAR', true, 100, null);
        $this->addColumn('Password', 'Password', 'VARCHAR', true, 50, null);
        $this->addColumn('AccountStatus', 'Accountstatus', 'INTEGER', true, 1, null);
        $this->addColumn('ActivationCode', 'Activationcode', 'VARCHAR', false, 10, null);
        $this->addColumn('ResetCode', 'Resetcode', 'VARCHAR', false, 10, null);
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
), 'CASCADE', 'CASCADE', null, false);
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UseraccountTableMap::CLASS_DEFAULT : UseraccountTableMap::OM_CLASS;
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
     * @return array           (Useraccount object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UseraccountTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UseraccountTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UseraccountTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UseraccountTableMap::OM_CLASS;
            /** @var Useraccount $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UseraccountTableMap::addInstanceToPool($obj, $key);
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
            $key = UseraccountTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UseraccountTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Useraccount $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UseraccountTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UseraccountTableMap::COL_USERNAME);
            $criteria->addSelectColumn(UseraccountTableMap::COL_PARTICIPANTCNIC);
            $criteria->addSelectColumn(UseraccountTableMap::COL_EMAIL);
            $criteria->addSelectColumn(UseraccountTableMap::COL_PASSWORD);
            $criteria->addSelectColumn(UseraccountTableMap::COL_ACCOUNTSTATUS);
            $criteria->addSelectColumn(UseraccountTableMap::COL_ACTIVATIONCODE);
            $criteria->addSelectColumn(UseraccountTableMap::COL_RESETCODE);
        } else {
            $criteria->addSelectColumn($alias . '.Username');
            $criteria->addSelectColumn($alias . '.ParticipantCNIC');
            $criteria->addSelectColumn($alias . '.Email');
            $criteria->addSelectColumn($alias . '.Password');
            $criteria->addSelectColumn($alias . '.AccountStatus');
            $criteria->addSelectColumn($alias . '.ActivationCode');
            $criteria->addSelectColumn($alias . '.ResetCode');
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
        return Propel::getServiceContainer()->getDatabaseMap(UseraccountTableMap::DATABASE_NAME)->getTable(UseraccountTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UseraccountTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UseraccountTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UseraccountTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Useraccount or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Useraccount object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UseraccountTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Model\Model\Useraccount) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UseraccountTableMap::DATABASE_NAME);
            $criteria->add(UseraccountTableMap::COL_USERNAME, (array) $values, Criteria::IN);
        }

        $query = UseraccountQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UseraccountTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UseraccountTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the useraccount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UseraccountQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Useraccount or Criteria object.
     *
     * @param mixed               $criteria Criteria or Useraccount object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseraccountTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Useraccount object
        }


        // Set the correct dbName
        $query = UseraccountQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UseraccountTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UseraccountTableMap::buildTableMap();
