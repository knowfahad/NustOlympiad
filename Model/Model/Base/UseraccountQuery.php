<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Useraccount as ChildUseraccount;
use Model\Model\UseraccountQuery as ChildUseraccountQuery;
use Model\Model\Map\UseraccountTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'useraccount' table.
 *
 *
 *
 * @method     ChildUseraccountQuery orderByUsername($order = Criteria::ASC) Order by the Username column
 * @method     ChildUseraccountQuery orderByParticipantcnic($order = Criteria::ASC) Order by the ParticipantCNIC column
 * @method     ChildUseraccountQuery orderByEmail($order = Criteria::ASC) Order by the Email column
 * @method     ChildUseraccountQuery orderByPassword($order = Criteria::ASC) Order by the Password column
 * @method     ChildUseraccountQuery orderByAccountstatus($order = Criteria::ASC) Order by the AccountStatus column
 * @method     ChildUseraccountQuery orderByActivationcode($order = Criteria::ASC) Order by the ActivationCode column
 * @method     ChildUseraccountQuery orderByResetcode($order = Criteria::ASC) Order by the ResetCode column
 *
 * @method     ChildUseraccountQuery groupByUsername() Group by the Username column
 * @method     ChildUseraccountQuery groupByParticipantcnic() Group by the ParticipantCNIC column
 * @method     ChildUseraccountQuery groupByEmail() Group by the Email column
 * @method     ChildUseraccountQuery groupByPassword() Group by the Password column
 * @method     ChildUseraccountQuery groupByAccountstatus() Group by the AccountStatus column
 * @method     ChildUseraccountQuery groupByActivationcode() Group by the ActivationCode column
 * @method     ChildUseraccountQuery groupByResetcode() Group by the ResetCode column
 *
 * @method     ChildUseraccountQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUseraccountQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUseraccountQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUseraccountQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUseraccountQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUseraccountQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUseraccountQuery leftJoinParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participant relation
 * @method     ChildUseraccountQuery rightJoinParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participant relation
 * @method     ChildUseraccountQuery innerJoinParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the Participant relation
 *
 * @method     ChildUseraccountQuery joinWithParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participant relation
 *
 * @method     ChildUseraccountQuery leftJoinWithParticipant() Adds a LEFT JOIN clause and with to the query using the Participant relation
 * @method     ChildUseraccountQuery rightJoinWithParticipant() Adds a RIGHT JOIN clause and with to the query using the Participant relation
 * @method     ChildUseraccountQuery innerJoinWithParticipant() Adds a INNER JOIN clause and with to the query using the Participant relation
 *
 * @method     \Model\Model\ParticipantQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUseraccount findOne(ConnectionInterface $con = null) Return the first ChildUseraccount matching the query
 * @method     ChildUseraccount findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUseraccount matching the query, or a new ChildUseraccount object populated from the query conditions when no match is found
 *
 * @method     ChildUseraccount findOneByUsername(string $Username) Return the first ChildUseraccount filtered by the Username column
 * @method     ChildUseraccount findOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildUseraccount filtered by the ParticipantCNIC column
 * @method     ChildUseraccount findOneByEmail(string $Email) Return the first ChildUseraccount filtered by the Email column
 * @method     ChildUseraccount findOneByPassword(string $Password) Return the first ChildUseraccount filtered by the Password column
 * @method     ChildUseraccount findOneByAccountstatus(int $AccountStatus) Return the first ChildUseraccount filtered by the AccountStatus column
 * @method     ChildUseraccount findOneByActivationcode(string $ActivationCode) Return the first ChildUseraccount filtered by the ActivationCode column
 * @method     ChildUseraccount findOneByResetcode(string $ResetCode) Return the first ChildUseraccount filtered by the ResetCode column *

 * @method     ChildUseraccount requirePk($key, ConnectionInterface $con = null) Return the ChildUseraccount by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOne(ConnectionInterface $con = null) Return the first ChildUseraccount matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUseraccount requireOneByUsername(string $Username) Return the first ChildUseraccount filtered by the Username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildUseraccount filtered by the ParticipantCNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOneByEmail(string $Email) Return the first ChildUseraccount filtered by the Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOneByPassword(string $Password) Return the first ChildUseraccount filtered by the Password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOneByAccountstatus(int $AccountStatus) Return the first ChildUseraccount filtered by the AccountStatus column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOneByActivationcode(string $ActivationCode) Return the first ChildUseraccount filtered by the ActivationCode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseraccount requireOneByResetcode(string $ResetCode) Return the first ChildUseraccount filtered by the ResetCode column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUseraccount[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUseraccount objects based on current ModelCriteria
 * @method     ChildUseraccount[]|ObjectCollection findByUsername(string $Username) Return ChildUseraccount objects filtered by the Username column
 * @method     ChildUseraccount[]|ObjectCollection findByParticipantcnic(string $ParticipantCNIC) Return ChildUseraccount objects filtered by the ParticipantCNIC column
 * @method     ChildUseraccount[]|ObjectCollection findByEmail(string $Email) Return ChildUseraccount objects filtered by the Email column
 * @method     ChildUseraccount[]|ObjectCollection findByPassword(string $Password) Return ChildUseraccount objects filtered by the Password column
 * @method     ChildUseraccount[]|ObjectCollection findByAccountstatus(int $AccountStatus) Return ChildUseraccount objects filtered by the AccountStatus column
 * @method     ChildUseraccount[]|ObjectCollection findByActivationcode(string $ActivationCode) Return ChildUseraccount objects filtered by the ActivationCode column
 * @method     ChildUseraccount[]|ObjectCollection findByResetcode(string $ResetCode) Return ChildUseraccount objects filtered by the ResetCode column
 * @method     ChildUseraccount[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UseraccountQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\UseraccountQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Useraccount', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUseraccountQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUseraccountQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUseraccountQuery) {
            return $criteria;
        }
        $query = new ChildUseraccountQuery();
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
     * @return ChildUseraccount|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UseraccountTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UseraccountTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUseraccount A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT Username, ParticipantCNIC, Email, Password, AccountStatus, ActivationCode, ResetCode FROM useraccount WHERE Username = :p0';
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
            /** @var ChildUseraccount $obj */
            $obj = new ChildUseraccount();
            $obj->hydrate($row);
            UseraccountTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUseraccount|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UseraccountTableMap::COL_USERNAME, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UseraccountTableMap::COL_USERNAME, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the Username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE Username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE Username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_USERNAME, $username, $comparison);
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
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByParticipantcnic($participantcnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($participantcnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_PARTICIPANTCNIC, $participantcnic, $comparison);
    }

    /**
     * Filter the query on the Email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE Email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE Email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the Password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE Password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE Password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the AccountStatus column
     *
     * Example usage:
     * <code>
     * $query->filterByAccountstatus(1234); // WHERE AccountStatus = 1234
     * $query->filterByAccountstatus(array(12, 34)); // WHERE AccountStatus IN (12, 34)
     * $query->filterByAccountstatus(array('min' => 12)); // WHERE AccountStatus > 12
     * </code>
     *
     * @param     mixed $accountstatus The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByAccountstatus($accountstatus = null, $comparison = null)
    {
        if (is_array($accountstatus)) {
            $useMinMax = false;
            if (isset($accountstatus['min'])) {
                $this->addUsingAlias(UseraccountTableMap::COL_ACCOUNTSTATUS, $accountstatus['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($accountstatus['max'])) {
                $this->addUsingAlias(UseraccountTableMap::COL_ACCOUNTSTATUS, $accountstatus['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_ACCOUNTSTATUS, $accountstatus, $comparison);
    }

    /**
     * Filter the query on the ActivationCode column
     *
     * Example usage:
     * <code>
     * $query->filterByActivationcode('fooValue');   // WHERE ActivationCode = 'fooValue'
     * $query->filterByActivationcode('%fooValue%', Criteria::LIKE); // WHERE ActivationCode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $activationcode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByActivationcode($activationcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($activationcode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_ACTIVATIONCODE, $activationcode, $comparison);
    }

    /**
     * Filter the query on the ResetCode column
     *
     * Example usage:
     * <code>
     * $query->filterByResetcode('fooValue');   // WHERE ResetCode = 'fooValue'
     * $query->filterByResetcode('%fooValue%', Criteria::LIKE); // WHERE ResetCode LIKE '%fooValue%'
     * </code>
     *
     * @param     string $resetcode The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByResetcode($resetcode = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($resetcode)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseraccountTableMap::COL_RESETCODE, $resetcode, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUseraccountQuery The current query, for fluid interface
     */
    public function filterByParticipant($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(UseraccountTableMap::COL_PARTICIPANTCNIC, $participant->getCnic(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UseraccountTableMap::COL_PARTICIPANTCNIC, $participant->toKeyValue('PrimaryKey', 'Cnic'), $comparison);
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
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildUseraccount $useraccount Object to remove from the list of results
     *
     * @return $this|ChildUseraccountQuery The current query, for fluid interface
     */
    public function prune($useraccount = null)
    {
        if ($useraccount) {
            $this->addUsingAlias(UseraccountTableMap::COL_USERNAME, $useraccount->getUsername(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the useraccount table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseraccountTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UseraccountTableMap::clearInstancePool();
            UseraccountTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UseraccountTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UseraccountTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UseraccountTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UseraccountTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UseraccountQuery
