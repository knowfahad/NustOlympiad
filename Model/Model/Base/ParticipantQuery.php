<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Participant as ChildParticipant;
use Model\Model\ParticipantQuery as ChildParticipantQuery;
use Model\Model\Map\ParticipantTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'participant' table.
 *
 *
 *
 * @method     ChildParticipantQuery orderByParticipantid($order = Criteria::ASC) Order by the ParticipantID column
 * @method     ChildParticipantQuery orderByCnic($order = Criteria::ASC) Order by the CNIC column
 * @method     ChildParticipantQuery orderByRegistrationchallanid($order = Criteria::ASC) Order by the RegistrationChallanID column
 * @method     ChildParticipantQuery orderByAccomodationchallanid($order = Criteria::ASC) Order by the AccomodationChallanID column
 * @method     ChildParticipantQuery orderByFirstname($order = Criteria::ASC) Order by the FirstName column
 * @method     ChildParticipantQuery orderByLastname($order = Criteria::ASC) Order by the LastName column
 * @method     ChildParticipantQuery orderByGender($order = Criteria::ASC) Order by the Gender column
 * @method     ChildParticipantQuery orderByAddress($order = Criteria::ASC) Order by the Address column
 * @method     ChildParticipantQuery orderByPhoneno($order = Criteria::ASC) Order by the PhoneNo column
 * @method     ChildParticipantQuery orderByNustregno($order = Criteria::ASC) Order by the NUSTRegNo column
 * @method     ChildParticipantQuery orderByAmbassadorid($order = Criteria::ASC) Order by the AmbassadorID column
 *
 * @method     ChildParticipantQuery groupByParticipantid() Group by the ParticipantID column
 * @method     ChildParticipantQuery groupByCnic() Group by the CNIC column
 * @method     ChildParticipantQuery groupByRegistrationchallanid() Group by the RegistrationChallanID column
 * @method     ChildParticipantQuery groupByAccomodationchallanid() Group by the AccomodationChallanID column
 * @method     ChildParticipantQuery groupByFirstname() Group by the FirstName column
 * @method     ChildParticipantQuery groupByLastname() Group by the LastName column
 * @method     ChildParticipantQuery groupByGender() Group by the Gender column
 * @method     ChildParticipantQuery groupByAddress() Group by the Address column
 * @method     ChildParticipantQuery groupByPhoneno() Group by the PhoneNo column
 * @method     ChildParticipantQuery groupByNustregno() Group by the NUSTRegNo column
 * @method     ChildParticipantQuery groupByAmbassadorid() Group by the AmbassadorID column
 *
 * @method     ChildParticipantQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildParticipantQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildParticipantQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildParticipantQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildParticipantQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildParticipantQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildParticipantQuery leftJoinChallanRelatedByAccomodationchallanid($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChallanRelatedByAccomodationchallanid relation
 * @method     ChildParticipantQuery rightJoinChallanRelatedByAccomodationchallanid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChallanRelatedByAccomodationchallanid relation
 * @method     ChildParticipantQuery innerJoinChallanRelatedByAccomodationchallanid($relationAlias = null) Adds a INNER JOIN clause to the query using the ChallanRelatedByAccomodationchallanid relation
 *
 * @method     ChildParticipantQuery joinWithChallanRelatedByAccomodationchallanid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ChallanRelatedByAccomodationchallanid relation
 *
 * @method     ChildParticipantQuery leftJoinWithChallanRelatedByAccomodationchallanid() Adds a LEFT JOIN clause and with to the query using the ChallanRelatedByAccomodationchallanid relation
 * @method     ChildParticipantQuery rightJoinWithChallanRelatedByAccomodationchallanid() Adds a RIGHT JOIN clause and with to the query using the ChallanRelatedByAccomodationchallanid relation
 * @method     ChildParticipantQuery innerJoinWithChallanRelatedByAccomodationchallanid() Adds a INNER JOIN clause and with to the query using the ChallanRelatedByAccomodationchallanid relation
 *
 * @method     ChildParticipantQuery leftJoinAmbassador($relationAlias = null) Adds a LEFT JOIN clause to the query using the Ambassador relation
 * @method     ChildParticipantQuery rightJoinAmbassador($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Ambassador relation
 * @method     ChildParticipantQuery innerJoinAmbassador($relationAlias = null) Adds a INNER JOIN clause to the query using the Ambassador relation
 *
 * @method     ChildParticipantQuery joinWithAmbassador($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Ambassador relation
 *
 * @method     ChildParticipantQuery leftJoinWithAmbassador() Adds a LEFT JOIN clause and with to the query using the Ambassador relation
 * @method     ChildParticipantQuery rightJoinWithAmbassador() Adds a RIGHT JOIN clause and with to the query using the Ambassador relation
 * @method     ChildParticipantQuery innerJoinWithAmbassador() Adds a INNER JOIN clause and with to the query using the Ambassador relation
 *
 * @method     ChildParticipantQuery leftJoinChallanRelatedByRegistrationchallanid($relationAlias = null) Adds a LEFT JOIN clause to the query using the ChallanRelatedByRegistrationchallanid relation
 * @method     ChildParticipantQuery rightJoinChallanRelatedByRegistrationchallanid($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ChallanRelatedByRegistrationchallanid relation
 * @method     ChildParticipantQuery innerJoinChallanRelatedByRegistrationchallanid($relationAlias = null) Adds a INNER JOIN clause to the query using the ChallanRelatedByRegistrationchallanid relation
 *
 * @method     ChildParticipantQuery joinWithChallanRelatedByRegistrationchallanid($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ChallanRelatedByRegistrationchallanid relation
 *
 * @method     ChildParticipantQuery leftJoinWithChallanRelatedByRegistrationchallanid() Adds a LEFT JOIN clause and with to the query using the ChallanRelatedByRegistrationchallanid relation
 * @method     ChildParticipantQuery rightJoinWithChallanRelatedByRegistrationchallanid() Adds a RIGHT JOIN clause and with to the query using the ChallanRelatedByRegistrationchallanid relation
 * @method     ChildParticipantQuery innerJoinWithChallanRelatedByRegistrationchallanid() Adds a INNER JOIN clause and with to the query using the ChallanRelatedByRegistrationchallanid relation
 *
 * @method     ChildParticipantQuery leftJoinAmbassadorParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmbassadorParticipant relation
 * @method     ChildParticipantQuery rightJoinAmbassadorParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmbassadorParticipant relation
 * @method     ChildParticipantQuery innerJoinAmbassadorParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the AmbassadorParticipant relation
 *
 * @method     ChildParticipantQuery joinWithAmbassadorParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AmbassadorParticipant relation
 *
 * @method     ChildParticipantQuery leftJoinWithAmbassadorParticipant() Adds a LEFT JOIN clause and with to the query using the AmbassadorParticipant relation
 * @method     ChildParticipantQuery rightJoinWithAmbassadorParticipant() Adds a RIGHT JOIN clause and with to the query using the AmbassadorParticipant relation
 * @method     ChildParticipantQuery innerJoinWithAmbassadorParticipant() Adds a INNER JOIN clause and with to the query using the AmbassadorParticipant relation
 *
 * @method     ChildParticipantQuery leftJoinEventparticipants($relationAlias = null) Adds a LEFT JOIN clause to the query using the Eventparticipants relation
 * @method     ChildParticipantQuery rightJoinEventparticipants($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Eventparticipants relation
 * @method     ChildParticipantQuery innerJoinEventparticipants($relationAlias = null) Adds a INNER JOIN clause to the query using the Eventparticipants relation
 *
 * @method     ChildParticipantQuery joinWithEventparticipants($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Eventparticipants relation
 *
 * @method     ChildParticipantQuery leftJoinWithEventparticipants() Adds a LEFT JOIN clause and with to the query using the Eventparticipants relation
 * @method     ChildParticipantQuery rightJoinWithEventparticipants() Adds a RIGHT JOIN clause and with to the query using the Eventparticipants relation
 * @method     ChildParticipantQuery innerJoinWithEventparticipants() Adds a INNER JOIN clause and with to the query using the Eventparticipants relation
 *
 * @method     ChildParticipantQuery leftJoinSportsparticipants($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sportsparticipants relation
 * @method     ChildParticipantQuery rightJoinSportsparticipants($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sportsparticipants relation
 * @method     ChildParticipantQuery innerJoinSportsparticipants($relationAlias = null) Adds a INNER JOIN clause to the query using the Sportsparticipants relation
 *
 * @method     ChildParticipantQuery joinWithSportsparticipants($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sportsparticipants relation
 *
 * @method     ChildParticipantQuery leftJoinWithSportsparticipants() Adds a LEFT JOIN clause and with to the query using the Sportsparticipants relation
 * @method     ChildParticipantQuery rightJoinWithSportsparticipants() Adds a RIGHT JOIN clause and with to the query using the Sportsparticipants relation
 * @method     ChildParticipantQuery innerJoinWithSportsparticipants() Adds a INNER JOIN clause and with to the query using the Sportsparticipants relation
 *
 * @method     ChildParticipantQuery leftJoinSportsteam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sportsteam relation
 * @method     ChildParticipantQuery rightJoinSportsteam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sportsteam relation
 * @method     ChildParticipantQuery innerJoinSportsteam($relationAlias = null) Adds a INNER JOIN clause to the query using the Sportsteam relation
 *
 * @method     ChildParticipantQuery joinWithSportsteam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sportsteam relation
 *
 * @method     ChildParticipantQuery leftJoinWithSportsteam() Adds a LEFT JOIN clause and with to the query using the Sportsteam relation
 * @method     ChildParticipantQuery rightJoinWithSportsteam() Adds a RIGHT JOIN clause and with to the query using the Sportsteam relation
 * @method     ChildParticipantQuery innerJoinWithSportsteam() Adds a INNER JOIN clause and with to the query using the Sportsteam relation
 *
 * @method     ChildParticipantQuery leftJoinUseraccount($relationAlias = null) Adds a LEFT JOIN clause to the query using the Useraccount relation
 * @method     ChildParticipantQuery rightJoinUseraccount($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Useraccount relation
 * @method     ChildParticipantQuery innerJoinUseraccount($relationAlias = null) Adds a INNER JOIN clause to the query using the Useraccount relation
 *
 * @method     ChildParticipantQuery joinWithUseraccount($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Useraccount relation
 *
 * @method     ChildParticipantQuery leftJoinWithUseraccount() Adds a LEFT JOIN clause and with to the query using the Useraccount relation
 * @method     ChildParticipantQuery rightJoinWithUseraccount() Adds a RIGHT JOIN clause and with to the query using the Useraccount relation
 * @method     ChildParticipantQuery innerJoinWithUseraccount() Adds a INNER JOIN clause and with to the query using the Useraccount relation
 *
 * @method     \Model\Model\ChallanQuery|\Model\Model\AmbassadorQuery|\Model\Model\AmbassadorParticipantQuery|\Model\Model\EventparticipantsQuery|\Model\Model\SportsparticipantsQuery|\Model\Model\SportsteamQuery|\Model\Model\UseraccountQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildParticipant findOne(ConnectionInterface $con = null) Return the first ChildParticipant matching the query
 * @method     ChildParticipant findOneOrCreate(ConnectionInterface $con = null) Return the first ChildParticipant matching the query, or a new ChildParticipant object populated from the query conditions when no match is found
 *
 * @method     ChildParticipant findOneByParticipantid(int $ParticipantID) Return the first ChildParticipant filtered by the ParticipantID column
 * @method     ChildParticipant findOneByCnic(string $CNIC) Return the first ChildParticipant filtered by the CNIC column
 * @method     ChildParticipant findOneByRegistrationchallanid(string $RegistrationChallanID) Return the first ChildParticipant filtered by the RegistrationChallanID column
 * @method     ChildParticipant findOneByAccomodationchallanid(string $AccomodationChallanID) Return the first ChildParticipant filtered by the AccomodationChallanID column
 * @method     ChildParticipant findOneByFirstname(string $FirstName) Return the first ChildParticipant filtered by the FirstName column
 * @method     ChildParticipant findOneByLastname(string $LastName) Return the first ChildParticipant filtered by the LastName column
 * @method     ChildParticipant findOneByGender(string $Gender) Return the first ChildParticipant filtered by the Gender column
 * @method     ChildParticipant findOneByAddress(string $Address) Return the first ChildParticipant filtered by the Address column
 * @method     ChildParticipant findOneByPhoneno(string $PhoneNo) Return the first ChildParticipant filtered by the PhoneNo column
 * @method     ChildParticipant findOneByNustregno(string $NUSTRegNo) Return the first ChildParticipant filtered by the NUSTRegNo column
 * @method     ChildParticipant findOneByAmbassadorid(string $AmbassadorID) Return the first ChildParticipant filtered by the AmbassadorID column *

 * @method     ChildParticipant requirePk($key, ConnectionInterface $con = null) Return the ChildParticipant by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOne(ConnectionInterface $con = null) Return the first ChildParticipant matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipant requireOneByParticipantid(int $ParticipantID) Return the first ChildParticipant filtered by the ParticipantID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByCnic(string $CNIC) Return the first ChildParticipant filtered by the CNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByRegistrationchallanid(string $RegistrationChallanID) Return the first ChildParticipant filtered by the RegistrationChallanID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByAccomodationchallanid(string $AccomodationChallanID) Return the first ChildParticipant filtered by the AccomodationChallanID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByFirstname(string $FirstName) Return the first ChildParticipant filtered by the FirstName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByLastname(string $LastName) Return the first ChildParticipant filtered by the LastName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByGender(string $Gender) Return the first ChildParticipant filtered by the Gender column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByAddress(string $Address) Return the first ChildParticipant filtered by the Address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByPhoneno(string $PhoneNo) Return the first ChildParticipant filtered by the PhoneNo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByNustregno(string $NUSTRegNo) Return the first ChildParticipant filtered by the NUSTRegNo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildParticipant requireOneByAmbassadorid(string $AmbassadorID) Return the first ChildParticipant filtered by the AmbassadorID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildParticipant[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildParticipant objects based on current ModelCriteria
 * @method     ChildParticipant[]|ObjectCollection findByParticipantid(int $ParticipantID) Return ChildParticipant objects filtered by the ParticipantID column
 * @method     ChildParticipant[]|ObjectCollection findByCnic(string $CNIC) Return ChildParticipant objects filtered by the CNIC column
 * @method     ChildParticipant[]|ObjectCollection findByRegistrationchallanid(string $RegistrationChallanID) Return ChildParticipant objects filtered by the RegistrationChallanID column
 * @method     ChildParticipant[]|ObjectCollection findByAccomodationchallanid(string $AccomodationChallanID) Return ChildParticipant objects filtered by the AccomodationChallanID column
 * @method     ChildParticipant[]|ObjectCollection findByFirstname(string $FirstName) Return ChildParticipant objects filtered by the FirstName column
 * @method     ChildParticipant[]|ObjectCollection findByLastname(string $LastName) Return ChildParticipant objects filtered by the LastName column
 * @method     ChildParticipant[]|ObjectCollection findByGender(string $Gender) Return ChildParticipant objects filtered by the Gender column
 * @method     ChildParticipant[]|ObjectCollection findByAddress(string $Address) Return ChildParticipant objects filtered by the Address column
 * @method     ChildParticipant[]|ObjectCollection findByPhoneno(string $PhoneNo) Return ChildParticipant objects filtered by the PhoneNo column
 * @method     ChildParticipant[]|ObjectCollection findByNustregno(string $NUSTRegNo) Return ChildParticipant objects filtered by the NUSTRegNo column
 * @method     ChildParticipant[]|ObjectCollection findByAmbassadorid(string $AmbassadorID) Return ChildParticipant objects filtered by the AmbassadorID column
 * @method     ChildParticipant[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ParticipantQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\ParticipantQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Participant', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildParticipantQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildParticipantQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildParticipantQuery) {
            return $criteria;
        }
        $query = new ChildParticipantQuery();
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
     * @return ChildParticipant|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ParticipantTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ParticipantTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildParticipant A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT ParticipantID, CNIC, RegistrationChallanID, AccomodationChallanID, FirstName, LastName, Gender, Address, PhoneNo, NUSTRegNo, AmbassadorID FROM participant WHERE ParticipantID = :p0';
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
            /** @var ChildParticipant $obj */
            $obj = new ChildParticipant();
            $obj->hydrate($row);
            ParticipantTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildParticipant|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ParticipantTableMap::COL_PARTICIPANTID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ParticipantTableMap::COL_PARTICIPANTID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the ParticipantID column
     *
     * Example usage:
     * <code>
     * $query->filterByParticipantid(1234); // WHERE ParticipantID = 1234
     * $query->filterByParticipantid(array(12, 34)); // WHERE ParticipantID IN (12, 34)
     * $query->filterByParticipantid(array('min' => 12)); // WHERE ParticipantID > 12
     * </code>
     *
     * @param     mixed $participantid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByParticipantid($participantid = null, $comparison = null)
    {
        if (is_array($participantid)) {
            $useMinMax = false;
            if (isset($participantid['min'])) {
                $this->addUsingAlias(ParticipantTableMap::COL_PARTICIPANTID, $participantid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($participantid['max'])) {
                $this->addUsingAlias(ParticipantTableMap::COL_PARTICIPANTID, $participantid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_PARTICIPANTID, $participantid, $comparison);
    }

    /**
     * Filter the query on the CNIC column
     *
     * Example usage:
     * <code>
     * $query->filterByCnic('fooValue');   // WHERE CNIC = 'fooValue'
     * $query->filterByCnic('%fooValue%', Criteria::LIKE); // WHERE CNIC LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cnic The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByCnic($cnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_CNIC, $cnic, $comparison);
    }

    /**
     * Filter the query on the RegistrationChallanID column
     *
     * Example usage:
     * <code>
     * $query->filterByRegistrationchallanid('fooValue');   // WHERE RegistrationChallanID = 'fooValue'
     * $query->filterByRegistrationchallanid('%fooValue%', Criteria::LIKE); // WHERE RegistrationChallanID LIKE '%fooValue%'
     * </code>
     *
     * @param     string $registrationchallanid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByRegistrationchallanid($registrationchallanid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($registrationchallanid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_REGISTRATIONCHALLANID, $registrationchallanid, $comparison);
    }

    /**
     * Filter the query on the AccomodationChallanID column
     *
     * Example usage:
     * <code>
     * $query->filterByAccomodationchallanid('fooValue');   // WHERE AccomodationChallanID = 'fooValue'
     * $query->filterByAccomodationchallanid('%fooValue%', Criteria::LIKE); // WHERE AccomodationChallanID LIKE '%fooValue%'
     * </code>
     *
     * @param     string $accomodationchallanid The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByAccomodationchallanid($accomodationchallanid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($accomodationchallanid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_ACCOMODATIONCHALLANID, $accomodationchallanid, $comparison);
    }

    /**
     * Filter the query on the FirstName column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE FirstName = 'fooValue'
     * $query->filterByFirstname('%fooValue%', Criteria::LIKE); // WHERE FirstName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the LastName column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE LastName = 'fooValue'
     * $query->filterByLastname('%fooValue%', Criteria::LIKE); // WHERE LastName LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the Gender column
     *
     * Example usage:
     * <code>
     * $query->filterByGender('fooValue');   // WHERE Gender = 'fooValue'
     * $query->filterByGender('%fooValue%', Criteria::LIKE); // WHERE Gender LIKE '%fooValue%'
     * </code>
     *
     * @param     string $gender The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByGender($gender = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($gender)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_GENDER, $gender, $comparison);
    }

    /**
     * Filter the query on the Address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE Address = 'fooValue'
     * $query->filterByAddress('%fooValue%', Criteria::LIKE); // WHERE Address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the PhoneNo column
     *
     * Example usage:
     * <code>
     * $query->filterByPhoneno('fooValue');   // WHERE PhoneNo = 'fooValue'
     * $query->filterByPhoneno('%fooValue%', Criteria::LIKE); // WHERE PhoneNo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phoneno The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByPhoneno($phoneno = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phoneno)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_PHONENO, $phoneno, $comparison);
    }

    /**
     * Filter the query on the NUSTRegNo column
     *
     * Example usage:
     * <code>
     * $query->filterByNustregno('fooValue');   // WHERE NUSTRegNo = 'fooValue'
     * $query->filterByNustregno('%fooValue%', Criteria::LIKE); // WHERE NUSTRegNo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nustregno The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByNustregno($nustregno = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nustregno)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_NUSTREGNO, $nustregno, $comparison);
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
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByAmbassadorid($ambassadorid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ambassadorid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ParticipantTableMap::COL_AMBASSADORID, $ambassadorid, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Challan object
     *
     * @param \Model\Model\Challan|ObjectCollection $challan The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByChallanRelatedByAccomodationchallanid($challan, $comparison = null)
    {
        if ($challan instanceof \Model\Model\Challan) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_ACCOMODATIONCHALLANID, $challan->getChallanid(), $comparison);
        } elseif ($challan instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipantTableMap::COL_ACCOMODATIONCHALLANID, $challan->toKeyValue('PrimaryKey', 'Challanid'), $comparison);
        } else {
            throw new PropelException('filterByChallanRelatedByAccomodationchallanid() only accepts arguments of type \Model\Model\Challan or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChallanRelatedByAccomodationchallanid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function joinChallanRelatedByAccomodationchallanid($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChallanRelatedByAccomodationchallanid');

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
            $this->addJoinObject($join, 'ChallanRelatedByAccomodationchallanid');
        }

        return $this;
    }

    /**
     * Use the ChallanRelatedByAccomodationchallanid relation Challan object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\ChallanQuery A secondary query class using the current class as primary query
     */
    public function useChallanRelatedByAccomodationchallanidQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinChallanRelatedByAccomodationchallanid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChallanRelatedByAccomodationchallanid', '\Model\Model\ChallanQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Ambassador object
     *
     * @param \Model\Model\Ambassador|ObjectCollection $ambassador The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByAmbassador($ambassador, $comparison = null)
    {
        if ($ambassador instanceof \Model\Model\Ambassador) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_AMBASSADORID, $ambassador->getAmbassadorid(), $comparison);
        } elseif ($ambassador instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipantTableMap::COL_AMBASSADORID, $ambassador->toKeyValue('PrimaryKey', 'Ambassadorid'), $comparison);
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
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function joinAmbassador($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAmbassadorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAmbassador($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Ambassador', '\Model\Model\AmbassadorQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Challan object
     *
     * @param \Model\Model\Challan|ObjectCollection $challan The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByChallanRelatedByRegistrationchallanid($challan, $comparison = null)
    {
        if ($challan instanceof \Model\Model\Challan) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_REGISTRATIONCHALLANID, $challan->getChallanid(), $comparison);
        } elseif ($challan instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ParticipantTableMap::COL_REGISTRATIONCHALLANID, $challan->toKeyValue('PrimaryKey', 'Challanid'), $comparison);
        } else {
            throw new PropelException('filterByChallanRelatedByRegistrationchallanid() only accepts arguments of type \Model\Model\Challan or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ChallanRelatedByRegistrationchallanid relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function joinChallanRelatedByRegistrationchallanid($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ChallanRelatedByRegistrationchallanid');

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
            $this->addJoinObject($join, 'ChallanRelatedByRegistrationchallanid');
        }

        return $this;
    }

    /**
     * Use the ChallanRelatedByRegistrationchallanid relation Challan object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\ChallanQuery A secondary query class using the current class as primary query
     */
    public function useChallanRelatedByRegistrationchallanidQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChallanRelatedByRegistrationchallanid($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ChallanRelatedByRegistrationchallanid', '\Model\Model\ChallanQuery');
    }

    /**
     * Filter the query by a related \Model\Model\AmbassadorParticipant object
     *
     * @param \Model\Model\AmbassadorParticipant|ObjectCollection $ambassadorParticipant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByAmbassadorParticipant($ambassadorParticipant, $comparison = null)
    {
        if ($ambassadorParticipant instanceof \Model\Model\AmbassadorParticipant) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_CNIC, $ambassadorParticipant->getParticipantcnic(), $comparison);
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
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function joinAmbassadorParticipant($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAmbassadorParticipantQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByEventparticipants($eventparticipants, $comparison = null)
    {
        if ($eventparticipants instanceof \Model\Model\Eventparticipants) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_CNIC, $eventparticipants->getParticipantcnic(), $comparison);
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
     * @return $this|ChildParticipantQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Model\Sportsparticipants object
     *
     * @param \Model\Model\Sportsparticipants|ObjectCollection $sportsparticipants the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterBySportsparticipants($sportsparticipants, $comparison = null)
    {
        if ($sportsparticipants instanceof \Model\Model\Sportsparticipants) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_CNIC, $sportsparticipants->getParticipantcnic(), $comparison);
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
     * @return $this|ChildParticipantQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Model\Sportsteam object
     *
     * @param \Model\Model\Sportsteam|ObjectCollection $sportsteam the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterBySportsteam($sportsteam, $comparison = null)
    {
        if ($sportsteam instanceof \Model\Model\Sportsteam) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_CNIC, $sportsteam->getHeadcnic(), $comparison);
        } elseif ($sportsteam instanceof ObjectCollection) {
            return $this
                ->useSportsteamQuery()
                ->filterByPrimaryKeys($sportsteam->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySportsteam() only accepts arguments of type \Model\Model\Sportsteam or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Sportsteam relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function joinSportsteam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Sportsteam');

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
            $this->addJoinObject($join, 'Sportsteam');
        }

        return $this;
    }

    /**
     * Use the Sportsteam relation Sportsteam object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\SportsteamQuery A secondary query class using the current class as primary query
     */
    public function useSportsteamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSportsteam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Sportsteam', '\Model\Model\SportsteamQuery');
    }

    /**
     * Filter the query by a related \Model\Model\Useraccount object
     *
     * @param \Model\Model\Useraccount|ObjectCollection $useraccount the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildParticipantQuery The current query, for fluid interface
     */
    public function filterByUseraccount($useraccount, $comparison = null)
    {
        if ($useraccount instanceof \Model\Model\Useraccount) {
            return $this
                ->addUsingAlias(ParticipantTableMap::COL_CNIC, $useraccount->getParticipantcnic(), $comparison);
        } elseif ($useraccount instanceof ObjectCollection) {
            return $this
                ->useUseraccountQuery()
                ->filterByPrimaryKeys($useraccount->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUseraccount() only accepts arguments of type \Model\Model\Useraccount or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Useraccount relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function joinUseraccount($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Useraccount');

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
            $this->addJoinObject($join, 'Useraccount');
        }

        return $this;
    }

    /**
     * Use the Useraccount relation Useraccount object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Model\Model\UseraccountQuery A secondary query class using the current class as primary query
     */
    public function useUseraccountQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUseraccount($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Useraccount', '\Model\Model\UseraccountQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildParticipant $participant Object to remove from the list of results
     *
     * @return $this|ChildParticipantQuery The current query, for fluid interface
     */
    public function prune($participant = null)
    {
        if ($participant) {
            $this->addUsingAlias(ParticipantTableMap::COL_PARTICIPANTID, $participant->getParticipantid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the participant table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ParticipantTableMap::clearInstancePool();
            ParticipantTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ParticipantTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ParticipantTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ParticipantTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ParticipantTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ParticipantQuery
