<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\AmbassadorParticipant as ChildAmbassadorParticipant;
use Model\Model\AmbassadorParticipantQuery as ChildAmbassadorParticipantQuery;
use Model\Model\Map\AmbassadorParticipantTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ambassador_participant' table.
 *
 *
 *
 * @method     ChildAmbassadorParticipantQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildAmbassadorParticipantQuery orderByParticipantcnic($order = Criteria::ASC) Order by the ParticipantCNIC column
 * @method     ChildAmbassadorParticipantQuery orderByAmbassadorid($order = Criteria::ASC) Order by the AmbassadorID column
 * @method     ChildAmbassadorParticipantQuery orderByEventid($order = Criteria::ASC) Order by the EventID column
 * @method     ChildAmbassadorParticipantQuery orderBySportid($order = Criteria::ASC) Order by the SportID column
 *
 * @method     ChildAmbassadorParticipantQuery groupById() Group by the id column
 * @method     ChildAmbassadorParticipantQuery groupByParticipantcnic() Group by the ParticipantCNIC column
 * @method     ChildAmbassadorParticipantQuery groupByAmbassadorid() Group by the AmbassadorID column
 * @method     ChildAmbassadorParticipantQuery groupByEventid() Group by the EventID column
 * @method     ChildAmbassadorParticipantQuery groupBySportid() Group by the SportID column
 *
 * @method     ChildAmbassadorParticipantQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmbassadorParticipantQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmbassadorParticipantQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAmbassadorParticipantQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAmbassadorParticipantQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildAmbassadorParticipantQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildAmbassadorParticipantQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildAmbassadorParticipantQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildAmbassadorParticipantQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildAmbassadorParticipantQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participant relation
 * @method     ChildAmbassadorParticipantQuery rightJoinParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participant relation
 * @method     ChildAmbassadorParticipantQuery innerJoinParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the Participant relation
 *
 * @method     ChildAmbassadorParticipantQuery joinWithParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participant relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinWithParticipant() Adds a LEFT JOIN clause and with to the query using the Participant relation
 * @method     ChildAmbassadorParticipantQuery rightJoinWithParticipant() Adds a RIGHT JOIN clause and with to the query using the Participant relation
 * @method     ChildAmbassadorParticipantQuery innerJoinWithParticipant() Adds a INNER JOIN clause and with to the query using the Participant relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinAmbassador($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ambassador relation
 * @method     ChildAmbassadorParticipantQuery rightJoinAmbassador($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ambassador relation
 * @method     ChildAmbassadorParticipantQuery innerJoinAmbassador($relationAlias = null) Adds a INNER JOIN clause to the query using the Ambassador relation
 *
 * @method     ChildAmbassadorParticipantQuery joinWithAmbassador($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ambassador relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinWithAmbassador() Adds a LEFT JOIN clause and with to the query using the Ambassador relation
 * @method     ChildAmbassadorParticipantQuery rightJoinWithAmbassador() Adds a RIGHT JOIN clause and with to the query using the Ambassador relation
 * @method     ChildAmbassadorParticipantQuery innerJoinWithAmbassador() Adds a INNER JOIN clause and with to the query using the Ambassador relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinSports($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sports relation
 * @method     ChildAmbassadorParticipantQuery rightJoinSports($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sports relation
 * @method     ChildAmbassadorParticipantQuery innerJoinSports($relationAlias = null) Adds a INNER JOIN clause to the query using the Sports relation
 *
 * @method     ChildAmbassadorParticipantQuery joinWithSports($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sports relation
 *
 * @method     ChildAmbassadorParticipantQuery leftJoinWithSports() Adds a LEFT JOIN clause and with to the query using the Sports relation
 * @method     ChildAmbassadorParticipantQuery rightJoinWithSports() Adds a RIGHT JOIN clause and with to the query using the Sports relation
 * @method     ChildAmbassadorParticipantQuery innerJoinWithSports() Adds a INNER JOIN clause and with to the query using the Sports relation
 *
 * @method     \Model\Model\EventsQuery|\Model\Model\ParticipantQuery|\Model\Model\AmbassadorQuery|\Model\Model\SportsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAmbassadorParticipant findOne(ConnectionInterface $con = null) Return the first ChildAmbassadorParticipant matching the query
 * @method     ChildAmbassadorParticipant findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmbassadorParticipant matching the query, or a new ChildAmbassadorParticipant object populated from the query conditions when no match is found
 *
 * @method     ChildAmbassadorParticipant findOneById(int $id) Return the first ChildAmbassadorParticipant filtered by the id column
 * @method     ChildAmbassadorParticipant findOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildAmbassadorParticipant filtered by the ParticipantCNIC column
 * @method     ChildAmbassadorParticipant findOneByAmbassadorid(string $AmbassadorID) Return the first ChildAmbassadorParticipant filtered by the AmbassadorID column
 * @method     ChildAmbassadorParticipant findOneByEventid(int $EventID) Return the first ChildAmbassadorParticipant filtered by the EventID column
 * @method     ChildAmbassadorParticipant findOneBySportid(int $SportID) Return the first ChildAmbassadorParticipant filtered by the SportID column *

 * @method     ChildAmbassadorParticipant requirePk($key, ConnectionInterface $con = null) Return the ChildAmbassadorParticipant by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassadorParticipant requireOne(ConnectionInterface $con = null) Return the first ChildAmbassadorParticipant matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAmbassadorParticipant requireOneById(int $id) Return the first ChildAmbassadorParticipant filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassadorParticipant requireOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildAmbassadorParticipant filtered by the ParticipantCNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassadorParticipant requireOneByAmbassadorid(string $AmbassadorID) Return the first ChildAmbassadorParticipant filtered by the AmbassadorID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassadorParticipant requireOneByEventid(int $EventID) Return the first ChildAmbassadorParticipant filtered by the EventID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassadorParticipant requireOneBySportid(int $SportID) Return the first ChildAmbassadorParticipant filtered by the SportID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAmbassadorParticipant[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAmbassadorParticipant objects based on current ModelCriteria
 * @method     ChildAmbassadorParticipant[]|ObjectCollection findById(int $id) Return ChildAmbassadorParticipant objects filtered by the id column
 * @method     ChildAmbassadorParticipant[]|ObjectCollection findByParticipantcnic(string $ParticipantCNIC) Return ChildAmbassadorParticipant objects filtered by the ParticipantCNIC column
 * @method     ChildAmbassadorParticipant[]|ObjectCollection findByAmbassadorid(string $AmbassadorID) Return ChildAmbassadorParticipant objects filtered by the AmbassadorID column
 * @method     ChildAmbassadorParticipant[]|ObjectCollection findByEventid(int $EventID) Return ChildAmbassadorParticipant objects filtered by the EventID column
 * @method     ChildAmbassadorParticipant[]|ObjectCollection findBySportid(int $SportID) Return ChildAmbassadorParticipant objects filtered by the SportID column
 * @method     ChildAmbassadorParticipant[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AmbassadorParticipantQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\AmbassadorParticipantQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\AmbassadorParticipant', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmbassadorParticipantQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmbassadorParticipantQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAmbassadorParticipantQuery) {
            return $criteria;
        }
        $query = new ChildAmbassadorParticipantQuery();
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
     * @return ChildAmbassadorParticipant|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmbassadorParticipantTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AmbassadorParticipantTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAmbassadorParticipant A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, ParticipantCNIC, AmbassadorID, EventID, SportID FROM ambassador_participant WHERE id = :p0';
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
            /** @var ChildAmbassadorParticipant $obj */
            $obj = new ChildAmbassadorParticipant();
            $obj->hydrate($row);
            AmbassadorParticipantTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAmbassadorParticipant|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(AmbassadorParticipantTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(AmbassadorParticipantTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the ParticipantCNIC column
     *
     * Example usage:
     * <code>
     * $query->filterByParticipantcnic('fooValue');   // WHERE ParticipantCNIC = 'fooValue'
     * $query->filterByParticipantcnic('%fooValue%', Criteria::LIKE); // WHERE ParticipantCNIC LIKE '%fooValue%'
     * </code>
     *
     * @param     string $participantcnic The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByParticipantcnic($participantcnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($participantcnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_PARTICIPANTCNIC, $participantcnic, $comparison);
    }

    /**
     * Filter the query on the AmbassadorID column
     *
     * Example usage:
     * <code>
     * $query->filterByAmbassadorid('fooValue');   // WHERE AmbassadorID = 'fooValue'
     * $query->filterByAmbassadorid('%fooValue%', Criteria::LIKE); // WHERE AmbassadorID LIKE '%fooValue%'
     * </code>
     *
     * @param     string $ambassadorid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByAmbassadorid($ambassadorid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ambassadorid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_AMBASSADORID, $ambassadorid, $comparison);
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
     * @see       filterByEvents()
     *
     * @param     mixed $eventid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByEventid($eventid = null, $comparison = null)
    {
        if (is_array($eventid)) {
            $useMinMax = false;
            if (isset($eventid['min'])) {
                $this->addUsingAlias(AmbassadorParticipantTableMap::COL_EVENTID, $eventid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventid['max'])) {
                $this->addUsingAlias(AmbassadorParticipantTableMap::COL_EVENTID, $eventid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_EVENTID, $eventid, $comparison);
    }

    /**
     * Filter the query on the SportID column
     *
     * Example usage:
     * <code>
     * $query->filterBySportid(1234); // WHERE SportID = 1234
     * $query->filterBySportid(array(12, 34)); // WHERE SportID IN (12, 34)
     * $query->filterBySportid(array('min' => 12)); // WHERE SportID > 12
     * </code>
     *
     * @see       filterBySports()
     *
     * @param     mixed $sportid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterBySportid($sportid = null, $comparison = null)
    {
        if (is_array($sportid)) {
            $useMinMax = false;
            if (isset($sportid['min'])) {
                $this->addUsingAlias(AmbassadorParticipantTableMap::COL_SPORTID, $sportid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sportid['max'])) {
                $this->addUsingAlias(AmbassadorParticipantTableMap::COL_SPORTID, $sportid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorParticipantTableMap::COL_SPORTID, $sportid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Events object
     *
     * @param \Model\Model\Events|ObjectCollection $events The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \Model\Model\Events) {
            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_EVENTID, $events->getEventid(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_EVENTID, $events->toKeyValue('PrimaryKey', 'Eventid'), $comparison);
        } else {
            throw new PropelException('filterByEvents() only accepts arguments of type \Model\Model\Events or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Events relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function joinEvents($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Events');

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
            $this->addJoinObject($join, 'Events');
        }

        return $this;
    }

    /**
     * Use the Events relation Events object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\EventsQuery A secondary query class using the current class as primary query
     */
    public function useEventsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinEvents($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Events', '\Model\Model\EventsQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByParticipant($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_PARTICIPANTCNIC, $participant->getCnic(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_PARTICIPANTCNIC, $participant->toKeyValue('PrimaryKey', 'Cnic'), $comparison);
        } else {
            throw new PropelException('filterByParticipant() only accepts arguments of type \Model\Model\Participant or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Participant relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function joinParticipant($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Participant');

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
            $this->addJoinObject($join, 'Participant');
        }

        return $this;
    }

    /**
     * Use the Participant relation Participant object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\ParticipantQuery A secondary query class using the current class as primary query
     */
    public function useParticipantQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParticipant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Participant', '\Model\Model\ParticipantQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Ambassador object
     *
     * @param \Model\Model\Ambassador|ObjectCollection $ambassador The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterByAmbassador($ambassador, $comparison = null)
    {
        if ($ambassador instanceof \Model\Model\Ambassador) {
            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_AMBASSADORID, $ambassador->getAmbassadorid(), $comparison);
        } elseif ($ambassador instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_AMBASSADORID, $ambassador->toKeyValue('PrimaryKey', 'Ambassadorid'), $comparison);
        } else {
            throw new PropelException('filterByAmbassador() only accepts arguments of type \Model\Model\Ambassador or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Ambassador relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function joinAmbassador($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Ambassador');

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
            $this->addJoinObject($join, 'Ambassador');
        }

        return $this;
    }

    /**
     * Use the Ambassador relation Ambassador object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\AmbassadorQuery A secondary query class using the current class as primary query
     */
    public function useAmbassadorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAmbassador($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ambassador', '\Model\Model\AmbassadorQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Sports object
     *
     * @param \Model\Model\Sports|ObjectCollection $sports The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function filterBySports($sports, $comparison = null)
    {
        if ($sports instanceof \Model\Model\Sports) {
            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_SPORTID, $sports->getSportid(), $comparison);
        } elseif ($sports instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AmbassadorParticipantTableMap::COL_SPORTID, $sports->toKeyValue('PrimaryKey', 'Sportid'), $comparison);
        } else {
            throw new PropelException('filterBySports() only accepts arguments of type \Model\Model\Sports or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sports relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function joinSports($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sports');

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
            $this->addJoinObject($join, 'Sports');
        }

        return $this;
    }

    /**
     * Use the Sports relation Sports object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\SportsQuery A secondary query class using the current class as primary query
     */
    public function useSportsQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinSports($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sports', '\Model\Model\SportsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmbassadorParticipant $ambassadorParticipant Object to remove from the list of results
     *
     * @return $this|ChildAmbassadorParticipantQuery The current query, for fluid interface
     */
    public function prune($ambassadorParticipant = null)
    {
        if ($ambassadorParticipant) {
            $this->addUsingAlias(AmbassadorParticipantTableMap::COL_ID, $ambassadorParticipant->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ambassador_participant table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorParticipantTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AmbassadorParticipantTableMap::clearInstancePool();
            AmbassadorParticipantTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorParticipantTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmbassadorParticipantTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AmbassadorParticipantTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AmbassadorParticipantTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AmbassadorParticipantQuery
