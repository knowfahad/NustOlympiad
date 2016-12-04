<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Sportsteam as ChildSportsteam;
use Model\Model\SportsteamQuery as ChildSportsteamQuery;
use Model\Model\Map\SportsteamTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sportsteam' table.
 *
 *
 *
 * @method     ChildSportsteamQuery orderByTeamid($order = Criteria::ASC) Order by the TeamID column
 * @method     ChildSportsteamQuery orderBySportid($order = Criteria::ASC) Order by the SportID column
 * @method     ChildSportsteamQuery orderByTeamname($order = Criteria::ASC) Order by the TeamName column
 * @method     ChildSportsteamQuery orderByHeadcnic($order = Criteria::ASC) Order by the HeadCNIC column
 * @method     ChildSportsteamQuery orderByChallanid($order = Criteria::ASC) Order by the ChallanID column
 * @method     ChildSportsteamQuery orderByAmountpayable($order = Criteria::ASC) Order by the AmountPayable column
 * @method     ChildSportsteamQuery orderByDuedata($order = Criteria::ASC) Order by the DueData column
 * @method     ChildSportsteamQuery orderByPaymentstatus($order = Criteria::ASC) Order by the PaymentStatus column
 *
 * @method     ChildSportsteamQuery groupByTeamid() Group by the TeamID column
 * @method     ChildSportsteamQuery groupBySportid() Group by the SportID column
 * @method     ChildSportsteamQuery groupByTeamname() Group by the TeamName column
 * @method     ChildSportsteamQuery groupByHeadcnic() Group by the HeadCNIC column
 * @method     ChildSportsteamQuery groupByChallanid() Group by the ChallanID column
 * @method     ChildSportsteamQuery groupByAmountpayable() Group by the AmountPayable column
 * @method     ChildSportsteamQuery groupByDuedata() Group by the DueData column
 * @method     ChildSportsteamQuery groupByPaymentstatus() Group by the PaymentStatus column
 *
 * @method     ChildSportsteamQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSportsteamQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSportsteamQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSportsteamQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSportsteamQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSportsteamQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSportsteamQuery leftJoinSports($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sports relation
 * @method     ChildSportsteamQuery rightJoinSports($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sports relation
 * @method     ChildSportsteamQuery innerJoinSports($relationAlias = null) Adds a INNER JOIN clause to the query using the Sports relation
 *
 * @method     ChildSportsteamQuery joinWithSports($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sports relation
 *
 * @method     ChildSportsteamQuery leftJoinWithSports() Adds a LEFT JOIN clause and with to the query using the Sports relation
 * @method     ChildSportsteamQuery rightJoinWithSports() Adds a RIGHT JOIN clause and with to the query using the Sports relation
 * @method     ChildSportsteamQuery innerJoinWithSports() Adds a INNER JOIN clause and with to the query using the Sports relation
 *
 * @method     ChildSportsteamQuery leftJoinParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participant relation
 * @method     ChildSportsteamQuery rightJoinParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participant relation
 * @method     ChildSportsteamQuery innerJoinParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the Participant relation
 *
 * @method     ChildSportsteamQuery joinWithParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participant relation
 *
 * @method     ChildSportsteamQuery leftJoinWithParticipant() Adds a LEFT JOIN clause and with to the query using the Participant relation
 * @method     ChildSportsteamQuery rightJoinWithParticipant() Adds a RIGHT JOIN clause and with to the query using the Participant relation
 * @method     ChildSportsteamQuery innerJoinWithParticipant() Adds a INNER JOIN clause and with to the query using the Participant relation
 *
 * @method     ChildSportsteamQuery leftJoinSportsparticipants($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sportsparticipants relation
 * @method     ChildSportsteamQuery rightJoinSportsparticipants($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sportsparticipants relation
 * @method     ChildSportsteamQuery innerJoinSportsparticipants($relationAlias = null) Adds a INNER JOIN clause to the query using the Sportsparticipants relation
 *
 * @method     ChildSportsteamQuery joinWithSportsparticipants($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sportsparticipants relation
 *
 * @method     ChildSportsteamQuery leftJoinWithSportsparticipants() Adds a LEFT JOIN clause and with to the query using the Sportsparticipants relation
 * @method     ChildSportsteamQuery rightJoinWithSportsparticipants() Adds a RIGHT JOIN clause and with to the query using the Sportsparticipants relation
 * @method     ChildSportsteamQuery innerJoinWithSportsparticipants() Adds a INNER JOIN clause and with to the query using the Sportsparticipants relation
 *
 * @method     \Model\Model\SportsQuery|\Model\Model\ParticipantQuery|\Model\Model\SportsparticipantsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSportsteam findOne(ConnectionInterface $con = null) Return the first ChildSportsteam matching the query
 * @method     ChildSportsteam findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSportsteam matching the query, or a new ChildSportsteam object populated from the query conditions when no match is found
 *
 * @method     ChildSportsteam findOneByTeamid(int $TeamID) Return the first ChildSportsteam filtered by the TeamID column
 * @method     ChildSportsteam findOneBySportid(int $SportID) Return the first ChildSportsteam filtered by the SportID column
 * @method     ChildSportsteam findOneByTeamname(string $TeamName) Return the first ChildSportsteam filtered by the TeamName column
 * @method     ChildSportsteam findOneByHeadcnic(string $HeadCNIC) Return the first ChildSportsteam filtered by the HeadCNIC column
 * @method     ChildSportsteam findOneByChallanid(string $ChallanID) Return the first ChildSportsteam filtered by the ChallanID column
 * @method     ChildSportsteam findOneByAmountpayable(int $AmountPayable) Return the first ChildSportsteam filtered by the AmountPayable column
 * @method     ChildSportsteam findOneByDuedata(string $DueData) Return the first ChildSportsteam filtered by the DueData column
 * @method     ChildSportsteam findOneByPaymentstatus(int $PaymentStatus) Return the first ChildSportsteam filtered by the PaymentStatus column *

 * @method     ChildSportsteam requirePk($key, ConnectionInterface $con = null) Return the ChildSportsteam by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOne(ConnectionInterface $con = null) Return the first ChildSportsteam matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSportsteam requireOneByTeamid(int $TeamID) Return the first ChildSportsteam filtered by the TeamID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneBySportid(int $SportID) Return the first ChildSportsteam filtered by the SportID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneByTeamname(string $TeamName) Return the first ChildSportsteam filtered by the TeamName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneByHeadcnic(string $HeadCNIC) Return the first ChildSportsteam filtered by the HeadCNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneByChallanid(string $ChallanID) Return the first ChildSportsteam filtered by the ChallanID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneByAmountpayable(int $AmountPayable) Return the first ChildSportsteam filtered by the AmountPayable column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneByDuedata(string $DueData) Return the first ChildSportsteam filtered by the DueData column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsteam requireOneByPaymentstatus(int $PaymentStatus) Return the first ChildSportsteam filtered by the PaymentStatus column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSportsteam[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSportsteam objects based on current ModelCriteria
 * @method     ChildSportsteam[]|ObjectCollection findByTeamid(int $TeamID) Return ChildSportsteam objects filtered by the TeamID column
 * @method     ChildSportsteam[]|ObjectCollection findBySportid(int $SportID) Return ChildSportsteam objects filtered by the SportID column
 * @method     ChildSportsteam[]|ObjectCollection findByTeamname(string $TeamName) Return ChildSportsteam objects filtered by the TeamName column
 * @method     ChildSportsteam[]|ObjectCollection findByHeadcnic(string $HeadCNIC) Return ChildSportsteam objects filtered by the HeadCNIC column
 * @method     ChildSportsteam[]|ObjectCollection findByChallanid(string $ChallanID) Return ChildSportsteam objects filtered by the ChallanID column
 * @method     ChildSportsteam[]|ObjectCollection findByAmountpayable(int $AmountPayable) Return ChildSportsteam objects filtered by the AmountPayable column
 * @method     ChildSportsteam[]|ObjectCollection findByDuedata(string $DueData) Return ChildSportsteam objects filtered by the DueData column
 * @method     ChildSportsteam[]|ObjectCollection findByPaymentstatus(int $PaymentStatus) Return ChildSportsteam objects filtered by the PaymentStatus column
 * @method     ChildSportsteam[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SportsteamQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\SportsteamQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Sportsteam', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSportsteamQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSportsteamQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSportsteamQuery) {
            return $criteria;
        }
        $query = new ChildSportsteamQuery();
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
     * @return ChildSportsteam|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SportsteamTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SportsteamTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildSportsteam A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT TeamID, SportID, TeamName, HeadCNIC, ChallanID, AmountPayable, DueData, PaymentStatus FROM sportsteam WHERE TeamID = :p0';
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
            /** @var ChildSportsteam $obj */
            $obj = new ChildSportsteam();
            $obj->hydrate($row);
            SportsteamTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildSportsteam|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SportsteamTableMap::COL_TEAMID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SportsteamTableMap::COL_TEAMID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the TeamID column
     *
     * Example usage:
     * <code>
     * $query->filterByTeamid(1234); // WHERE TeamID = 1234
     * $query->filterByTeamid(array(12, 34)); // WHERE TeamID IN (12, 34)
     * $query->filterByTeamid(array('min' => 12)); // WHERE TeamID > 12
     * </code>
     *
     * @param     mixed $teamid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByTeamid($teamid = null, $comparison = null)
    {
        if (is_array($teamid)) {
            $useMinMax = false;
            if (isset($teamid['min'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_TEAMID, $teamid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamid['max'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_TEAMID, $teamid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_TEAMID, $teamid, $comparison);
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterBySportid($sportid = null, $comparison = null)
    {
        if (is_array($sportid)) {
            $useMinMax = false;
            if (isset($sportid['min'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_SPORTID, $sportid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($sportid['max'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_SPORTID, $sportid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_SPORTID, $sportid, $comparison);
    }

    /**
     * Filter the query on the TeamName column
     *
     * Example usage:
     * <code>
     * $query->filterByTeamname('fooValue');   // WHERE TeamName = 'fooValue'
     * $query->filterByTeamname('%fooValue%', Criteria::LIKE); // WHERE TeamName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $teamname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByTeamname($teamname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($teamname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_TEAMNAME, $teamname, $comparison);
    }

    /**
     * Filter the query on the HeadCNIC column
     *
     * Example usage:
     * <code>
     * $query->filterByHeadcnic('fooValue');   // WHERE HeadCNIC = 'fooValue'
     * $query->filterByHeadcnic('%fooValue%', Criteria::LIKE); // WHERE HeadCNIC LIKE '%fooValue%'
     * </code>
     *
     * @param     string $headcnic The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByHeadcnic($headcnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($headcnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_HEADCNIC, $headcnic, $comparison);
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByChallanid($challanid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($challanid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_CHALLANID, $challanid, $comparison);
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByAmountpayable($amountpayable = null, $comparison = null)
    {
        if (is_array($amountpayable)) {
            $useMinMax = false;
            if (isset($amountpayable['min'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_AMOUNTPAYABLE, $amountpayable['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($amountpayable['max'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_AMOUNTPAYABLE, $amountpayable['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_AMOUNTPAYABLE, $amountpayable, $comparison);
    }

    /**
     * Filter the query on the DueData column
     *
     * Example usage:
     * <code>
     * $query->filterByDuedata('2011-03-14'); // WHERE DueData = '2011-03-14'
     * $query->filterByDuedata('now'); // WHERE DueData = '2011-03-14'
     * $query->filterByDuedata(array('max' => 'yesterday')); // WHERE DueData > '2011-03-13'
     * </code>
     *
     * @param     mixed $duedata The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByDuedata($duedata = null, $comparison = null)
    {
        if (is_array($duedata)) {
            $useMinMax = false;
            if (isset($duedata['min'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_DUEDATA, $duedata['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($duedata['max'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_DUEDATA, $duedata['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_DUEDATA, $duedata, $comparison);
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByPaymentstatus($paymentstatus = null, $comparison = null)
    {
        if (is_array($paymentstatus)) {
            $useMinMax = false;
            if (isset($paymentstatus['min'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_PAYMENTSTATUS, $paymentstatus['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($paymentstatus['max'])) {
                $this->addUsingAlias(SportsteamTableMap::COL_PAYMENTSTATUS, $paymentstatus['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsteamTableMap::COL_PAYMENTSTATUS, $paymentstatus, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Sports object
     *
     * @param \Model\Model\Sports|ObjectCollection $sports The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterBySports($sports, $comparison = null)
    {
        if ($sports instanceof \Model\Model\Sports) {
            return $this
                ->addUsingAlias(SportsteamTableMap::COL_SPORTID, $sports->getSportid(), $comparison);
        } elseif ($sports instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SportsteamTableMap::COL_SPORTID, $sports->toKeyValue('PrimaryKey', 'Sportid'), $comparison);
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function joinSports($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useSportsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSports($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sports', '\Model\Model\SportsQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterByParticipant($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(SportsteamTableMap::COL_HEADCNIC, $participant->getCnic(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SportsteamTableMap::COL_HEADCNIC, $participant->toKeyValue('PrimaryKey', 'Cnic'), $comparison);
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
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Model\Sportsparticipants object
     *
     * @param \Model\Model\Sportsparticipants|ObjectCollection $sportsparticipants the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildSportsteamQuery The current query, for fluid interface
     */
    public function filterBySportsparticipants($sportsparticipants, $comparison = null)
    {
        if ($sportsparticipants instanceof \Model\Model\Sportsparticipants) {
            return $this
                ->addUsingAlias(SportsteamTableMap::COL_TEAMID, $sportsparticipants->getTeamid(), $comparison);
        } elseif ($sportsparticipants instanceof ObjectCollection) {
            return $this
                ->useSportsparticipantsQuery()
                ->filterByPrimaryKeys($sportsparticipants->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySportsparticipants() only accepts arguments of type \Model\Model\Sportsparticipants or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sportsparticipants relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function joinSportsparticipants($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sportsparticipants');

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
            $this->addJoinObject($join, 'Sportsparticipants');
        }

        return $this;
    }

    /**
     * Use the Sportsparticipants relation Sportsparticipants object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\SportsparticipantsQuery A secondary query class using the current class as primary query
     */
    public function useSportsparticipantsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSportsparticipants($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sportsparticipants', '\Model\Model\SportsparticipantsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildSportsteam $sportsteam Object to remove from the list of results
     *
     * @return $this|ChildSportsteamQuery The current query, for fluid interface
     */
    public function prune($sportsteam = null)
    {
        if ($sportsteam) {
            $this->addUsingAlias(SportsteamTableMap::COL_TEAMID, $sportsteam->getTeamid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sportsteam table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SportsteamTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SportsteamTableMap::clearInstancePool();
            SportsteamTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SportsteamTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SportsteamTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SportsteamTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SportsteamTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SportsteamQuery
