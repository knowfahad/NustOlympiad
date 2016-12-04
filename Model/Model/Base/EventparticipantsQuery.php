<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Eventparticipants as ChildEventparticipants;
use Model\Model\EventparticipantsQuery as ChildEventparticipantsQuery;
use Model\Model\Map\EventparticipantsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'eventparticipants' table.
 *
 *
 *
 * @method     ChildEventparticipantsQuery orderByParticipantcnic($order = Criteria::ASC) Order by the ParticipantCNIC column
 * @method     ChildEventparticipantsQuery orderByEventid($order = Criteria::ASC) Order by the EventID column
 * @method     ChildEventparticipantsQuery orderByChallanid($order = Criteria::ASC) Order by the ChallanID column
 * @method     ChildEventparticipantsQuery orderByPaymentstatus($order = Criteria::ASC) Order by the PaymentStatus column
 * @method     ChildEventparticipantsQuery orderByDuedate($order = Criteria::ASC) Order by the DueDate column
 *
 * @method     ChildEventparticipantsQuery groupByParticipantcnic() Group by the ParticipantCNIC column
 * @method     ChildEventparticipantsQuery groupByEventid() Group by the EventID column
 * @method     ChildEventparticipantsQuery groupByChallanid() Group by the ChallanID column
 * @method     ChildEventparticipantsQuery groupByPaymentstatus() Group by the PaymentStatus column
 * @method     ChildEventparticipantsQuery groupByDuedate() Group by the DueDate column
 *
 * @method     ChildEventparticipantsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildEventparticipantsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildEventparticipantsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildEventparticipantsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildEventparticipantsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildEventparticipantsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildEventparticipantsQuery leftJoinParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participant relation
 * @method     ChildEventparticipantsQuery rightJoinParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participant relation
 * @method     ChildEventparticipantsQuery innerJoinParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the Participant relation
 *
 * @method     ChildEventparticipantsQuery joinWithParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participant relation
 *
 * @method     ChildEventparticipantsQuery leftJoinWithParticipant() Adds a LEFT JOIN clause and with to the query using the Participant relation
 * @method     ChildEventparticipantsQuery rightJoinWithParticipant() Adds a RIGHT JOIN clause and with to the query using the Participant relation
 * @method     ChildEventparticipantsQuery innerJoinWithParticipant() Adds a INNER JOIN clause and with to the query using the Participant relation
 *
 * @method     ChildEventparticipantsQuery leftJoinEvents($relationAlias = null) Adds a LEFT JOIN clause to the query using the Events relation
 * @method     ChildEventparticipantsQuery rightJoinEvents($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Events relation
 * @method     ChildEventparticipantsQuery innerJoinEvents($relationAlias = null) Adds a INNER JOIN clause to the query using the Events relation
 *
 * @method     ChildEventparticipantsQuery joinWithEvents($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Events relation
 *
 * @method     ChildEventparticipantsQuery leftJoinWithEvents() Adds a LEFT JOIN clause and with to the query using the Events relation
 * @method     ChildEventparticipantsQuery rightJoinWithEvents() Adds a RIGHT JOIN clause and with to the query using the Events relation
 * @method     ChildEventparticipantsQuery innerJoinWithEvents() Adds a INNER JOIN clause and with to the query using the Events relation
 *
 * @method     \Model\Model\ParticipantQuery|\Model\Model\EventsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildEventparticipants findOne(ConnectionInterface $con = null) Return the first ChildEventparticipants matching the query
 * @method     ChildEventparticipants findOneOrCreate(ConnectionInterface $con = null) Return the first ChildEventparticipants matching the query, or a new ChildEventparticipants object populated from the query conditions when no match is found
 *
 * @method     ChildEventparticipants findOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildEventparticipants filtered by the ParticipantCNIC column
 * @method     ChildEventparticipants findOneByEventid(int $EventID) Return the first ChildEventparticipants filtered by the EventID column
 * @method     ChildEventparticipants findOneByChallanid(string $ChallanID) Return the first ChildEventparticipants filtered by the ChallanID column
 * @method     ChildEventparticipants findOneByPaymentstatus(int $PaymentStatus) Return the first ChildEventparticipants filtered by the PaymentStatus column
 * @method     ChildEventparticipants findOneByDuedate(string $DueDate) Return the first ChildEventparticipants filtered by the DueDate column *

 * @method     ChildEventparticipants requirePk($key, ConnectionInterface $con = null) Return the ChildEventparticipants by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEventparticipants requireOne(ConnectionInterface $con = null) Return the first ChildEventparticipants matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEventparticipants requireOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildEventparticipants filtered by the ParticipantCNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEventparticipants requireOneByEventid(int $EventID) Return the first ChildEventparticipants filtered by the EventID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEventparticipants requireOneByChallanid(string $ChallanID) Return the first ChildEventparticipants filtered by the ChallanID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEventparticipants requireOneByPaymentstatus(int $PaymentStatus) Return the first ChildEventparticipants filtered by the PaymentStatus column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildEventparticipants requireOneByDuedate(string $DueDate) Return the first ChildEventparticipants filtered by the DueDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildEventparticipants[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildEventparticipants objects based on current ModelCriteria
 * @method     ChildEventparticipants[]|ObjectCollection findByParticipantcnic(string $ParticipantCNIC) Return ChildEventparticipants objects filtered by the ParticipantCNIC column
 * @method     ChildEventparticipants[]|ObjectCollection findByEventid(int $EventID) Return ChildEventparticipants objects filtered by the EventID column
 * @method     ChildEventparticipants[]|ObjectCollection findByChallanid(string $ChallanID) Return ChildEventparticipants objects filtered by the ChallanID column
 * @method     ChildEventparticipants[]|ObjectCollection findByPaymentstatus(int $PaymentStatus) Return ChildEventparticipants objects filtered by the PaymentStatus column
 * @method     ChildEventparticipants[]|ObjectCollection findByDuedate(string $DueDate) Return ChildEventparticipants objects filtered by the DueDate column
 * @method     ChildEventparticipants[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class EventparticipantsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\EventparticipantsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Eventparticipants', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildEventparticipantsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildEventparticipantsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildEventparticipantsQuery) {
            return $criteria;
        }
        $query = new ChildEventparticipantsQuery();
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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$ParticipantCNIC, $EventID] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildEventparticipants|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventparticipantsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = EventparticipantsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildEventparticipants A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ParticipantCNIC, EventID, ChallanID, PaymentStatus, DueDate FROM eventparticipants WHERE ParticipantCNIC = :p0 AND EventID = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildEventparticipants $obj */
            $obj = new ChildEventparticipants();
            $obj->hydrate($row);
            EventparticipantsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildEventparticipants|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
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
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(EventparticipantsTableMap::COL_PARTICIPANTCNIC, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(EventparticipantsTableMap::COL_EVENTID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(EventparticipantsTableMap::COL_PARTICIPANTCNIC, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(EventparticipantsTableMap::COL_EVENTID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByParticipantcnic($participantcnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($participantcnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventparticipantsTableMap::COL_PARTICIPANTCNIC, $participantcnic, $comparison);
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
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByEventid($eventid = null, $comparison = null)
    {
        if (is_array($eventid)) {
            $useMinMax = false;
            if (isset($eventid['min'])) {
                $this->addUsingAlias(EventparticipantsTableMap::COL_EVENTID, $eventid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($eventid['max'])) {
                $this->addUsingAlias(EventparticipantsTableMap::COL_EVENTID, $eventid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventparticipantsTableMap::COL_EVENTID, $eventid, $comparison);
    }

    /**
     * Filter the query on the ChallanID column
     *
     * Example usage:
     * <code>
     * $query->filterByChallanid('fooValue');   // WHERE ChallanID = 'fooValue'
     * $query->filterByChallanid('%fooValue%', Criteria::LIKE); // WHERE ChallanID LIKE '%fooValue%'
     * </code>
     *
     * @param     string $challanid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByChallanid($challanid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($challanid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventparticipantsTableMap::COL_CHALLANID, $challanid, $comparison);
    }

    /**
     * Filter the query on the PaymentStatus column
     *
     * Example usage:
     * <code>
     * $query->filterByPaymentstatus(1234); // WHERE PaymentStatus = 1234
     * $query->filterByPaymentstatus(array(12, 34)); // WHERE PaymentStatus IN (12, 34)
     * $query->filterByPaymentstatus(array('min' => 12)); // WHERE PaymentStatus > 12
     * </code>
     *
     * @param     mixed $paymentstatus The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByPaymentstatus($paymentstatus = null, $comparison = null)
    {
        if (is_array($paymentstatus)) {
            $useMinMax = false;
            if (isset($paymentstatus['min'])) {
                $this->addUsingAlias(EventparticipantsTableMap::COL_PAYMENTSTATUS, $paymentstatus['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentstatus['max'])) {
                $this->addUsingAlias(EventparticipantsTableMap::COL_PAYMENTSTATUS, $paymentstatus['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventparticipantsTableMap::COL_PAYMENTSTATUS, $paymentstatus, $comparison);
    }

    /**
     * Filter the query on the DueDate column
     *
     * Example usage:
     * <code>
     * $query->filterByDuedate('2011-03-14'); // WHERE DueDate = '2011-03-14'
     * $query->filterByDuedate('now'); // WHERE DueDate = '2011-03-14'
     * $query->filterByDuedate(array('max' => 'yesterday')); // WHERE DueDate > '2011-03-13'
     * </code>
     *
     * @param     mixed $duedate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByDuedate($duedate = null, $comparison = null)
    {
        if (is_array($duedate)) {
            $useMinMax = false;
            if (isset($duedate['min'])) {
                $this->addUsingAlias(EventparticipantsTableMap::COL_DUEDATE, $duedate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duedate['max'])) {
                $this->addUsingAlias(EventparticipantsTableMap::COL_DUEDATE, $duedate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(EventparticipantsTableMap::COL_DUEDATE, $duedate, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByParticipant($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(EventparticipantsTableMap::COL_PARTICIPANTCNIC, $participant->getCnic(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EventparticipantsTableMap::COL_PARTICIPANTCNIC, $participant->toKeyValue('PrimaryKey', 'Cnic'), $comparison);
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
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Model\Events object
     *
     * @param \Model\Model\Events|ObjectCollection $events The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function filterByEvents($events, $comparison = null)
    {
        if ($events instanceof \Model\Model\Events) {
            return $this
                ->addUsingAlias(EventparticipantsTableMap::COL_EVENTID, $events->getEventid(), $comparison);
        } elseif ($events instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(EventparticipantsTableMap::COL_EVENTID, $events->toKeyValue('PrimaryKey', 'Eventid'), $comparison);
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
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function joinEvents($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useEventsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinEvents($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Events', '\Model\Model\EventsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildEventparticipants $eventparticipants Object to remove from the list of results
     *
     * @return $this|ChildEventparticipantsQuery The current query, for fluid interface
     */
    public function prune($eventparticipants = null)
    {
        if ($eventparticipants) {
            $this->addCond('pruneCond0', $this->getAliasedColName(EventparticipantsTableMap::COL_PARTICIPANTCNIC), $eventparticipants->getParticipantcnic(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(EventparticipantsTableMap::COL_EVENTID), $eventparticipants->getEventid(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the eventparticipants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventparticipantsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            EventparticipantsTableMap::clearInstancePool();
            EventparticipantsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(EventparticipantsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(EventparticipantsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            EventparticipantsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            EventparticipantsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // EventparticipantsQuery
