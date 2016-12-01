<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Challan as ChildChallan;
use Model\Model\ChallanQuery as ChildChallanQuery;
use Model\Model\Map\ChallanTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'challan' table.
 *
 *
 *
 * @method     ChildChallanQuery orderByChallanid($order = Criteria::ASC) Order by the ChallanID column
 * @method     ChildChallanQuery orderByAmountpayable($order = Criteria::ASC) Order by the AmountPayable column
 * @method     ChildChallanQuery orderByDuedate($order = Criteria::ASC) Order by the DueDate column
 * @method     ChildChallanQuery orderByPaymentstatus($order = Criteria::ASC) Order by the PaymentStatus column
 *
 * @method     ChildChallanQuery groupByChallanid() Group by the ChallanID column
 * @method     ChildChallanQuery groupByAmountpayable() Group by the AmountPayable column
 * @method     ChildChallanQuery groupByDuedate() Group by the DueDate column
 * @method     ChildChallanQuery groupByPaymentstatus() Group by the PaymentStatus column
 *
 * @method     ChildChallanQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildChallanQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildChallanQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildChallanQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildChallanQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildChallanQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildChallanQuery leftJoinParticipantRelatedByAccomodationchallanid($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParticipantRelatedByAccomodationchallanid relation
 * @method     ChildChallanQuery rightJoinParticipantRelatedByAccomodationchallanid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParticipantRelatedByAccomodationchallanid relation
 * @method     ChildChallanQuery innerJoinParticipantRelatedByAccomodationchallanid($relationAlias = null) Adds a INNER JOIN clause to the query using the ParticipantRelatedByAccomodationchallanid relation
 *
 * @method     ChildChallanQuery joinWithParticipantRelatedByAccomodationchallanid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ParticipantRelatedByAccomodationchallanid relation
 *
 * @method     ChildChallanQuery leftJoinWithParticipantRelatedByAccomodationchallanid() Adds a LEFT JOIN clause and with to the query using the ParticipantRelatedByAccomodationchallanid relation
 * @method     ChildChallanQuery rightJoinWithParticipantRelatedByAccomodationchallanid() Adds a RIGHT JOIN clause and with to the query using the ParticipantRelatedByAccomodationchallanid relation
 * @method     ChildChallanQuery innerJoinWithParticipantRelatedByAccomodationchallanid() Adds a INNER JOIN clause and with to the query using the ParticipantRelatedByAccomodationchallanid relation
 *
 * @method     ChildChallanQuery leftJoinParticipantRelatedByRegistrationchallanid($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParticipantRelatedByRegistrationchallanid relation
 * @method     ChildChallanQuery rightJoinParticipantRelatedByRegistrationchallanid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParticipantRelatedByRegistrationchallanid relation
 * @method     ChildChallanQuery innerJoinParticipantRelatedByRegistrationchallanid($relationAlias = null) Adds a INNER JOIN clause to the query using the ParticipantRelatedByRegistrationchallanid relation
 *
 * @method     ChildChallanQuery joinWithParticipantRelatedByRegistrationchallanid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ParticipantRelatedByRegistrationchallanid relation
 *
 * @method     ChildChallanQuery leftJoinWithParticipantRelatedByRegistrationchallanid() Adds a LEFT JOIN clause and with to the query using the ParticipantRelatedByRegistrationchallanid relation
 * @method     ChildChallanQuery rightJoinWithParticipantRelatedByRegistrationchallanid() Adds a RIGHT JOIN clause and with to the query using the ParticipantRelatedByRegistrationchallanid relation
 * @method     ChildChallanQuery innerJoinWithParticipantRelatedByRegistrationchallanid() Adds a INNER JOIN clause and with to the query using the ParticipantRelatedByRegistrationchallanid relation
 *
 * @method     \Model\Model\ParticipantQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildChallan findOne(ConnectionInterface $con = null) Return the first ChildChallan matching the query
 * @method     ChildChallan findOneOrCreate(ConnectionInterface $con = null) Return the first ChildChallan matching the query, or a new ChildChallan object populated from the query conditions when no match is found
 *
 * @method     ChildChallan findOneByChallanid(string $ChallanID) Return the first ChildChallan filtered by the ChallanID column
 * @method     ChildChallan findOneByAmountpayable(int $AmountPayable) Return the first ChildChallan filtered by the AmountPayable column
 * @method     ChildChallan findOneByDuedate(string $DueDate) Return the first ChildChallan filtered by the DueDate column
 * @method     ChildChallan findOneByPaymentstatus(int $PaymentStatus) Return the first ChildChallan filtered by the PaymentStatus column *

 * @method     ChildChallan requirePk($key, ConnectionInterface $con = null) Return the ChildChallan by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChallan requireOne(ConnectionInterface $con = null) Return the first ChildChallan matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildChallan requireOneByChallanid(string $ChallanID) Return the first ChildChallan filtered by the ChallanID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChallan requireOneByAmountpayable(int $AmountPayable) Return the first ChildChallan filtered by the AmountPayable column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChallan requireOneByDuedate(string $DueDate) Return the first ChildChallan filtered by the DueDate column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildChallan requireOneByPaymentstatus(int $PaymentStatus) Return the first ChildChallan filtered by the PaymentStatus column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildChallan[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildChallan objects based on current ModelCriteria
 * @method     ChildChallan[]|ObjectCollection findByChallanid(string $ChallanID) Return ChildChallan objects filtered by the ChallanID column
 * @method     ChildChallan[]|ObjectCollection findByAmountpayable(int $AmountPayable) Return ChildChallan objects filtered by the AmountPayable column
 * @method     ChildChallan[]|ObjectCollection findByDuedate(string $DueDate) Return ChildChallan objects filtered by the DueDate column
 * @method     ChildChallan[]|ObjectCollection findByPaymentstatus(int $PaymentStatus) Return ChildChallan objects filtered by the PaymentStatus column
 * @method     ChildChallan[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ChallanQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\ChallanQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Challan', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildChallanQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildChallanQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildChallanQuery) {
            return $criteria;
        }
        $query = new ChildChallanQuery();
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
     * @return ChildChallan|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ChallanTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ChallanTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildChallan A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ChallanID, AmountPayable, DueDate, PaymentStatus FROM challan WHERE ChallanID = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildChallan $obj */
            $obj = new ChildChallan();
            $obj->hydrate($row);
            ChallanTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildChallan|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ChallanTableMap::COL_CHALLANID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ChallanTableMap::COL_CHALLANID, $keys, Criteria::IN);
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
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function filterByChallanid($challanid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($challanid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChallanTableMap::COL_CHALLANID, $challanid, $comparison);
    }

    /**
     * Filter the query on the AmountPayable column
     *
     * Example usage:
     * <code>
     * $query->filterByAmountpayable(1234); // WHERE AmountPayable = 1234
     * $query->filterByAmountpayable(array(12, 34)); // WHERE AmountPayable IN (12, 34)
     * $query->filterByAmountpayable(array('min' => 12)); // WHERE AmountPayable > 12
     * </code>
     *
     * @param     mixed $amountpayable The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function filterByAmountpayable($amountpayable = null, $comparison = null)
    {
        if (is_array($amountpayable)) {
            $useMinMax = false;
            if (isset($amountpayable['min'])) {
                $this->addUsingAlias(ChallanTableMap::COL_AMOUNTPAYABLE, $amountpayable['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amountpayable['max'])) {
                $this->addUsingAlias(ChallanTableMap::COL_AMOUNTPAYABLE, $amountpayable['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChallanTableMap::COL_AMOUNTPAYABLE, $amountpayable, $comparison);
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
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function filterByDuedate($duedate = null, $comparison = null)
    {
        if (is_array($duedate)) {
            $useMinMax = false;
            if (isset($duedate['min'])) {
                $this->addUsingAlias(ChallanTableMap::COL_DUEDATE, $duedate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duedate['max'])) {
                $this->addUsingAlias(ChallanTableMap::COL_DUEDATE, $duedate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChallanTableMap::COL_DUEDATE, $duedate, $comparison);
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
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function filterByPaymentstatus($paymentstatus = null, $comparison = null)
    {
        if (is_array($paymentstatus)) {
            $useMinMax = false;
            if (isset($paymentstatus['min'])) {
                $this->addUsingAlias(ChallanTableMap::COL_PAYMENTSTATUS, $paymentstatus['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentstatus['max'])) {
                $this->addUsingAlias(ChallanTableMap::COL_PAYMENTSTATUS, $paymentstatus['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChallanTableMap::COL_PAYMENTSTATUS, $paymentstatus, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChallanQuery The current query, for fluid interface
     */
    public function filterByParticipantRelatedByAccomodationchallanid($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(ChallanTableMap::COL_CHALLANID, $participant->getAccomodationchallanid(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            return $this
                ->useParticipantRelatedByAccomodationchallanidQuery()
                ->filterByPrimaryKeys($participant->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParticipantRelatedByAccomodationchallanid() only accepts arguments of type \Model\Model\Participant or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ParticipantRelatedByAccomodationchallanid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function joinParticipantRelatedByAccomodationchallanid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ParticipantRelatedByAccomodationchallanid');

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
            $this->addJoinObject($join, 'ParticipantRelatedByAccomodationchallanid');
        }

        return $this;
    }

    /**
     * Use the ParticipantRelatedByAccomodationchallanid relation Participant object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\ParticipantQuery A secondary query class using the current class as primary query
     */
    public function useParticipantRelatedByAccomodationchallanidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinParticipantRelatedByAccomodationchallanid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ParticipantRelatedByAccomodationchallanid', '\Model\Model\ParticipantQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildChallanQuery The current query, for fluid interface
     */
    public function filterByParticipantRelatedByRegistrationchallanid($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(ChallanTableMap::COL_CHALLANID, $participant->getRegistrationchallanid(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            return $this
                ->useParticipantRelatedByRegistrationchallanidQuery()
                ->filterByPrimaryKeys($participant->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByParticipantRelatedByRegistrationchallanid() only accepts arguments of type \Model\Model\Participant or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ParticipantRelatedByRegistrationchallanid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function joinParticipantRelatedByRegistrationchallanid($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ParticipantRelatedByRegistrationchallanid');

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
            $this->addJoinObject($join, 'ParticipantRelatedByRegistrationchallanid');
        }

        return $this;
    }

    /**
     * Use the ParticipantRelatedByRegistrationchallanid relation Participant object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\ParticipantQuery A secondary query class using the current class as primary query
     */
    public function useParticipantRelatedByRegistrationchallanidQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinParticipantRelatedByRegistrationchallanid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ParticipantRelatedByRegistrationchallanid', '\Model\Model\ParticipantQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildChallan $challan Object to remove from the list of results
     *
     * @return $this|ChildChallanQuery The current query, for fluid interface
     */
    public function prune($challan = null)
    {
        if ($challan) {
            $this->addUsingAlias(ChallanTableMap::COL_CHALLANID, $challan->getChallanid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the challan table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ChallanTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ChallanTableMap::clearInstancePool();
            ChallanTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ChallanTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ChallanTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ChallanTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ChallanTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ChallanQuery
