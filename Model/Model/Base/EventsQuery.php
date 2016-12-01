<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Events as ChildEvents;
use Model\Model\EventsQuery as ChildEventsQuery;
use Model\Model\Map\EventsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'events' table.
 *
 *
 *
 * @method     ChildEventsQuery orderByEventid($order = Criteria::ASC) Order by the EventID column
 * @method     ChildEventsQuery orderByName($order = Criteria::ASC) Order by the Name column
 * @method     ChildEventsQuery orderByEventfee($order = Criteria::ASC) Order by the EventFee column
 * @method     ChildEventsQuery orderByEventtype($order = Criteria::ASC) Order by the EventType column
 *
 * @method     ChildEventsQuery groupByEventid() Group by the EventID column
 * @method     ChildEventsQuery groupByName() Group by the Name column
 * @method     ChildEventsQuery groupByEventfee() Group by the EventFee column
 * @method     ChildEventsQuery groupByEventtype() Group by the EventType column
 *
 * @method     ChildEventsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEventsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEventsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEventsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEventsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEventsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEventsQuery leftJoinAmbassadorParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmbassadorParticipant relation
 * @method     ChildEventsQuery rightJoinAmbassadorParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmbassadorParticipant relation
 * @method     ChildEventsQuery innerJoinAmbassadorParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the AmbassadorParticipant relation
 *
 * @method     ChildEventsQuery joinWithAmbassadorParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AmbassadorParticipant relation
 *
 * @method     ChildEventsQuery leftJoinWithAmbassadorParticipant() Adds a LEFT JOIN clause and with to the query using the AmbassadorParticipant relation
 * @method     ChildEventsQuery rightJoinWithAmbassadorParticipant() Adds a RIGHT JOIN clause and with to the query using the AmbassadorParticipant relation
 * @method     ChildEventsQuery innerJoinWithAmbassadorParticipant() Adds a INNER JOIN clause and with to the query using the AmbassadorParticipant relation
 *
 * @method     ChildEventsQuery leftJoinEventparticipants($relationAlias = null) Adds a LEFT JOIN clause to the query using the Eventparticipants relation
 * @method     ChildEventsQuery rightJoinEventparticipants($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Eventparticipants relation
 * @method     ChildEventsQuery innerJoinEventparticipants($relationAlias = null) Adds a INNER JOIN clause to the query using the Eventparticipants relation
 *
 * @method     ChildEventsQuery joinWithEventparticipants($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Eventparticipants relation
 *
 * @method     ChildEventsQuery leftJoinWithEventparticipants() Adds a LEFT JOIN clause and with to the query using the Eventparticipants relation
 * @method     ChildEventsQuery rightJoinWithEventparticipants() Adds a RIGHT JOIN clause and with to the query using the Eventparticipants relation
 * @method     ChildEventsQuery innerJoinWithEventparticipants() Adds a INNER JOIN clause and with to the query using the Eventparticipants relation
 *
 * @method     \Model\Model\AmbassadorParticipantQuery|\Model\Model\EventparticipantsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEvents findOne(ConnectionInterface $con = null) Return the first ChildEvents matching the query
 * @method     ChildEvents findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEvents matching the query, or a new ChildEvents object populated from the query conditions when no match is found
 *
 * @method     ChildEvents findOneByEventid(int $EventID) Return the first ChildEvents filtered by the EventID column
 * @method     ChildEvents findOneByName(string $Name) Return the first ChildEvents filtered by the Name column
 * @method     ChildEvents findOneByEventfee(int $EventFee) Return the first ChildEvents filtered by the EventFee column
 * @method     ChildEvents findOneByEventtype(int $EventType) Return the first ChildEvents filtered by the EventType column *

 * @method     ChildEvents requirePk($key, ConnectionInterface $con = null) Return the ChildEvents by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOne(ConnectionInterface $con = null) Return the first ChildEvents matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvents requireOneByEventid(int $EventID) Return the first ChildEvents filtered by the EventID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByName(string $Name) Return the first ChildEvents filtered by the Name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByEventfee(int $EventFee) Return the first ChildEvents filtered by the EventFee column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEvents requireOneByEventtype(int $EventType) Return the first ChildEvents filtered by the EventType column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEvents[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEvents objects based on current ModelCriteria
 * @method     ChildEvents[]|ObjectCollection findByEventid(int $EventID) Return ChildEvents objects filtered by the EventID column
 * @method     ChildEvents[]|ObjectCollection findByName(string $Name) Return ChildEvents objects filtered by the Name column
 * @method     ChildEvents[]|ObjectCollection findByEventfee(int $EventFee) Return ChildEvents objects filtered by the EventFee column
 * @method     ChildEvents[]|ObjectCollection findByEventtype(int $EventType) Return ChildEvents objects filtered by the EventType column
 * @method     ChildEvents[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EventsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\EventsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Events', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEventsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEventsQuery) {
            return $criteria;
        }
        $query = new ChildEventsQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildEvents|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EventsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEvents A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT EventID, Name, EventFee, EventType FROM events WHERE EventID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildEvents $obj */
            $obj = new ChildEvents();
            $obj->hydrate($row);
            EventsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildEvents|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(EventsTableMap::COL_EVENTID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(EventsTableMap::COL_EVENTID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the EventID column
     *
     * Example usage:
     * <code>
     * $query->filterByEventid(1234); // WHERE EventID = 1234
     * $query->filterByEventid(array(12, 34)); // WHERE EventID IN (12, 34)
     * $query->filterByEventid(array('min' => 12)); // WHERE EventID > 12
     * </code>
     *
     * @param     mixed $eventid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByEventid($eventid = null, $comparison = null)
    {
        if (is_array($eventid)) {
            $useMinMax = false;
            if (isset($eventid['min'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENTID, $eventid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventid['max'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENTID, $eventid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_EVENTID, $eventid, $comparison);
    }

    /**
     * Filter the query on the Name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE Name = 'fooValue'
     * $query->filterByName('%fooValue%', Criteria::LIKE); // WHERE Name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the EventFee column
     *
     * Example usage:
     * <code>
     * $query->filterByEventfee(1234); // WHERE EventFee = 1234
     * $query->filterByEventfee(array(12, 34)); // WHERE EventFee IN (12, 34)
     * $query->filterByEventfee(array('min' => 12)); // WHERE EventFee > 12
     * </code>
     *
     * @param     mixed $eventfee The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByEventfee($eventfee = null, $comparison = null)
    {
        if (is_array($eventfee)) {
            $useMinMax = false;
            if (isset($eventfee['min'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENTFEE, $eventfee['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventfee['max'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENTFEE, $eventfee['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_EVENTFEE, $eventfee, $comparison);
    }

    /**
     * Filter the query on the EventType column
     *
     * Example usage:
     * <code>
     * $query->filterByEventtype(1234); // WHERE EventType = 1234
     * $query->filterByEventtype(array(12, 34)); // WHERE EventType IN (12, 34)
     * $query->filterByEventtype(array('min' => 12)); // WHERE EventType > 12
     * </code>
     *
     * @param     mixed $eventtype The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function filterByEventtype($eventtype = null, $comparison = null)
    {
        if (is_array($eventtype)) {
            $useMinMax = false;
            if (isset($eventtype['min'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENTTYPE, $eventtype['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventtype['max'])) {
                $this->addUsingAlias(EventsTableMap::COL_EVENTTYPE, $eventtype['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventsTableMap::COL_EVENTTYPE, $eventtype, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\AmbassadorParticipant object
     *
     * @param \Model\Model\AmbassadorParticipant|ObjectCollection $ambassadorParticipant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventsQuery The current query, for fluid interface
     */
    public function filterByAmbassadorParticipant($ambassadorParticipant, $comparison = null)
    {
        if ($ambassadorParticipant instanceof \Model\Model\AmbassadorParticipant) {
            return $this
                ->addUsingAlias(EventsTableMap::COL_EVENTID, $ambassadorParticipant->getEventid(), $comparison);
        } elseif ($ambassadorParticipant instanceof ObjectCollection) {
            return $this
                ->useAmbassadorParticipantQuery()
                ->filterByPrimaryKeys($ambassadorParticipant->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAmbassadorParticipant() only accepts arguments of type \Model\Model\AmbassadorParticipant or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AmbassadorParticipant relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function joinAmbassadorParticipant($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AmbassadorParticipant');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AmbassadorParticipant');
        }

        return $this;
    }

    /**
     * Use the AmbassadorParticipant relation AmbassadorParticipant object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\AmbassadorParticipantQuery A secondary query class using the current class as primary query
     */
    public function useAmbassadorParticipantQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAmbassadorParticipant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AmbassadorParticipant', '\Model\Model\AmbassadorParticipantQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Eventparticipants object
     *
     * @param \Model\Model\Eventparticipants|ObjectCollection $eventparticipants the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildEventsQuery The current query, for fluid interface
     */
    public function filterByEventparticipants($eventparticipants, $comparison = null)
    {
        if ($eventparticipants instanceof \Model\Model\Eventparticipants) {
            return $this
                ->addUsingAlias(EventsTableMap::COL_EVENTID, $eventparticipants->getEventid(), $comparison);
        } elseif ($eventparticipants instanceof ObjectCollection) {
            return $this
                ->useEventparticipantsQuery()
                ->filterByPrimaryKeys($eventparticipants->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByEventparticipants() only accepts arguments of type \Model\Model\Eventparticipants or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Eventparticipants relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function joinEventparticipants($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Eventparticipants');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Eventparticipants');
        }

        return $this;
    }

    /**
     * Use the Eventparticipants relation Eventparticipants object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\EventparticipantsQuery A secondary query class using the current class as primary query
     */
    public function useEventparticipantsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEventparticipants($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Eventparticipants', '\Model\Model\EventparticipantsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEvents $events Object to remove from the list of results
     *
     * @return $this|ChildEventsQuery The current query, for fluid interface
     */
    public function prune($events = null)
    {
        if ($events) {
            $this->addUsingAlias(EventsTableMap::COL_EVENTID, $events->getEventid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the events table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventsTableMap::clearInstancePool();
            EventsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EventsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EventsQuery
