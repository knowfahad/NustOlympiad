<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Ambassador as ChildAmbassador;
use Model\Model\AmbassadorQuery as ChildAmbassadorQuery;
use Model\Model\Map\AmbassadorTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'ambassador' table.
 *
 *
 *
 * @method     ChildAmbassadorQuery orderByAmbassadorid($order = Criteria::ASC) Order by the AmbassadorID column
 * @method     ChildAmbassadorQuery orderByCnic($order = Criteria::ASC) Order by the CNIC column
 * @method     ChildAmbassadorQuery orderByFirstname($order = Criteria::ASC) Order by the FirstName column
 * @method     ChildAmbassadorQuery orderByLastname($order = Criteria::ASC) Order by the LastName column
 * @method     ChildAmbassadorQuery orderByEmail($order = Criteria::ASC) Order by the Email column
 *
 * @method     ChildAmbassadorQuery groupByAmbassadorid() Group by the AmbassadorID column
 * @method     ChildAmbassadorQuery groupByCnic() Group by the CNIC column
 * @method     ChildAmbassadorQuery groupByFirstname() Group by the FirstName column
 * @method     ChildAmbassadorQuery groupByLastname() Group by the LastName column
 * @method     ChildAmbassadorQuery groupByEmail() Group by the Email column
 *
 * @method     ChildAmbassadorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildAmbassadorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildAmbassadorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildAmbassadorQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildAmbassadorQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildAmbassadorQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildAmbassadorQuery leftJoinAmbassadorParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the AmbassadorParticipant relation
 * @method     ChildAmbassadorQuery rightJoinAmbassadorParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AmbassadorParticipant relation
 * @method     ChildAmbassadorQuery innerJoinAmbassadorParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the AmbassadorParticipant relation
 *
 * @method     ChildAmbassadorQuery joinWithAmbassadorParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the AmbassadorParticipant relation
 *
 * @method     ChildAmbassadorQuery leftJoinWithAmbassadorParticipant() Adds a LEFT JOIN clause and with to the query using the AmbassadorParticipant relation
 * @method     ChildAmbassadorQuery rightJoinWithAmbassadorParticipant() Adds a RIGHT JOIN clause and with to the query using the AmbassadorParticipant relation
 * @method     ChildAmbassadorQuery innerJoinWithAmbassadorParticipant() Adds a INNER JOIN clause and with to the query using the AmbassadorParticipant relation
 *
 * @method     ChildAmbassadorQuery leftJoinParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participant relation
 * @method     ChildAmbassadorQuery rightJoinParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participant relation
 * @method     ChildAmbassadorQuery innerJoinParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the Participant relation
 *
 * @method     ChildAmbassadorQuery joinWithParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participant relation
 *
 * @method     ChildAmbassadorQuery leftJoinWithParticipant() Adds a LEFT JOIN clause and with to the query using the Participant relation
 * @method     ChildAmbassadorQuery rightJoinWithParticipant() Adds a RIGHT JOIN clause and with to the query using the Participant relation
 * @method     ChildAmbassadorQuery innerJoinWithParticipant() Adds a INNER JOIN clause and with to the query using the Participant relation
 *
 * @method     \Model\Model\AmbassadorParticipantQuery|\Model\Model\ParticipantQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildAmbassador findOne(ConnectionInterface $con = null) Return the first ChildAmbassador matching the query
 * @method     ChildAmbassador findOneOrCreate(ConnectionInterface $con = null) Return the first ChildAmbassador matching the query, or a new ChildAmbassador object populated from the query conditions when no match is found
 *
 * @method     ChildAmbassador findOneByAmbassadorid(string $AmbassadorID) Return the first ChildAmbassador filtered by the AmbassadorID column
 * @method     ChildAmbassador findOneByCnic(string $CNIC) Return the first ChildAmbassador filtered by the CNIC column
 * @method     ChildAmbassador findOneByFirstname(string $FirstName) Return the first ChildAmbassador filtered by the FirstName column
 * @method     ChildAmbassador findOneByLastname(string $LastName) Return the first ChildAmbassador filtered by the LastName column
 * @method     ChildAmbassador findOneByEmail(string $Email) Return the first ChildAmbassador filtered by the Email column *

 * @method     ChildAmbassador requirePk($key, ConnectionInterface $con = null) Return the ChildAmbassador by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassador requireOne(ConnectionInterface $con = null) Return the first ChildAmbassador matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAmbassador requireOneByAmbassadorid(string $AmbassadorID) Return the first ChildAmbassador filtered by the AmbassadorID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassador requireOneByCnic(string $CNIC) Return the first ChildAmbassador filtered by the CNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassador requireOneByFirstname(string $FirstName) Return the first ChildAmbassador filtered by the FirstName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassador requireOneByLastname(string $LastName) Return the first ChildAmbassador filtered by the LastName column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildAmbassador requireOneByEmail(string $Email) Return the first ChildAmbassador filtered by the Email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildAmbassador[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildAmbassador objects based on current ModelCriteria
 * @method     ChildAmbassador[]|ObjectCollection findByAmbassadorid(string $AmbassadorID) Return ChildAmbassador objects filtered by the AmbassadorID column
 * @method     ChildAmbassador[]|ObjectCollection findByCnic(string $CNIC) Return ChildAmbassador objects filtered by the CNIC column
 * @method     ChildAmbassador[]|ObjectCollection findByFirstname(string $FirstName) Return ChildAmbassador objects filtered by the FirstName column
 * @method     ChildAmbassador[]|ObjectCollection findByLastname(string $LastName) Return ChildAmbassador objects filtered by the LastName column
 * @method     ChildAmbassador[]|ObjectCollection findByEmail(string $Email) Return ChildAmbassador objects filtered by the Email column
 * @method     ChildAmbassador[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class AmbassadorQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\AmbassadorQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Ambassador', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildAmbassadorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildAmbassadorQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildAmbassadorQuery) {
            return $criteria;
        }
        $query = new ChildAmbassadorQuery();
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
     * @return ChildAmbassador|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = AmbassadorTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildAmbassador A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT AmbassadorID, CNIC, FirstName, LastName, Email FROM ambassador WHERE AmbassadorID = :p0';
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
            /** @var ChildAmbassador $obj */
            $obj = new ChildAmbassador();
            $obj->hydrate($row);
            AmbassadorTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildAmbassador|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AmbassadorTableMap::COL_AMBASSADORID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AmbassadorTableMap::COL_AMBASSADORID, $keys, Criteria::IN);
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByAmbassadorid($ambassadorid = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($ambassadorid)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorTableMap::COL_AMBASSADORID, $ambassadorid, $comparison);
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByCnic($cnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorTableMap::COL_CNIC, $cnic, $comparison);
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorTableMap::COL_FIRSTNAME, $firstname, $comparison);
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorTableMap::COL_LASTNAME, $lastname, $comparison);
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AmbassadorTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\AmbassadorParticipant object
     *
     * @param \Model\Model\AmbassadorParticipant|ObjectCollection $ambassadorParticipant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByAmbassadorParticipant($ambassadorParticipant, $comparison = null)
    {
        if ($ambassadorParticipant instanceof \Model\Model\AmbassadorParticipant) {
            return $this
                ->addUsingAlias(AmbassadorTableMap::COL_AMBASSADORID, $ambassadorParticipant->getAmbassadorid(), $comparison);
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildAmbassadorQuery The current query, for fluid interface
     */
    public function filterByParticipant($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(AmbassadorTableMap::COL_AMBASSADORID, $participant->getAmbassadorid(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            return $this
                ->useParticipantQuery()
                ->filterByPrimaryKeys($participant->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function joinParticipant($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useParticipantQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinParticipant($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Participant', '\Model\Model\ParticipantQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildAmbassador $ambassador Object to remove from the list of results
     *
     * @return $this|ChildAmbassadorQuery The current query, for fluid interface
     */
    public function prune($ambassador = null)
    {
        if ($ambassador) {
            $this->addUsingAlias(AmbassadorTableMap::COL_AMBASSADORID, $ambassador->getAmbassadorid(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the ambassador table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            AmbassadorTableMap::clearInstancePool();
            AmbassadorTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(AmbassadorTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(AmbassadorTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            AmbassadorTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            AmbassadorTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // AmbassadorQuery
