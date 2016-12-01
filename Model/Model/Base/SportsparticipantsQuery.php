<?php

namespace Model\Model\Base;

use \Exception;
use \PDO;
use Model\Model\Sportsparticipants as ChildSportsparticipants;
use Model\Model\SportsparticipantsQuery as ChildSportsparticipantsQuery;
use Model\Model\Map\SportsparticipantsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'sportsparticipants' table.
 *
 *
 *
 * @method     ChildSportsparticipantsQuery orderByTeamid($order = Criteria::ASC) Order by the TeamID column
 * @method     ChildSportsparticipantsQuery orderByParticipantcnic($order = Criteria::ASC) Order by the ParticipantCNIC column
 *
 * @method     ChildSportsparticipantsQuery groupByTeamid() Group by the TeamID column
 * @method     ChildSportsparticipantsQuery groupByParticipantcnic() Group by the ParticipantCNIC column
 *
 * @method     ChildSportsparticipantsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildSportsparticipantsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildSportsparticipantsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildSportsparticipantsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildSportsparticipantsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildSportsparticipantsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildSportsparticipantsQuery leftJoinSportsteam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Sportsteam relation
 * @method     ChildSportsparticipantsQuery rightJoinSportsteam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Sportsteam relation
 * @method     ChildSportsparticipantsQuery innerJoinSportsteam($relationAlias = null) Adds a INNER JOIN clause to the query using the Sportsteam relation
 *
 * @method     ChildSportsparticipantsQuery joinWithSportsteam($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Sportsteam relation
 *
 * @method     ChildSportsparticipantsQuery leftJoinWithSportsteam() Adds a LEFT JOIN clause and with to the query using the Sportsteam relation
 * @method     ChildSportsparticipantsQuery rightJoinWithSportsteam() Adds a RIGHT JOIN clause and with to the query using the Sportsteam relation
 * @method     ChildSportsparticipantsQuery innerJoinWithSportsteam() Adds a INNER JOIN clause and with to the query using the Sportsteam relation
 *
 * @method     ChildSportsparticipantsQuery leftJoinParticipant($relationAlias = null) Adds a LEFT JOIN clause to the query using the Participant relation
 * @method     ChildSportsparticipantsQuery rightJoinParticipant($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Participant relation
 * @method     ChildSportsparticipantsQuery innerJoinParticipant($relationAlias = null) Adds a INNER JOIN clause to the query using the Participant relation
 *
 * @method     ChildSportsparticipantsQuery joinWithParticipant($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Participant relation
 *
 * @method     ChildSportsparticipantsQuery leftJoinWithParticipant() Adds a LEFT JOIN clause and with to the query using the Participant relation
 * @method     ChildSportsparticipantsQuery rightJoinWithParticipant() Adds a RIGHT JOIN clause and with to the query using the Participant relation
 * @method     ChildSportsparticipantsQuery innerJoinWithParticipant() Adds a INNER JOIN clause and with to the query using the Participant relation
 *
 * @method     \Model\Model\SportsteamQuery|\Model\Model\ParticipantQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildSportsparticipants findOne(ConnectionInterface $con = null) Return the first ChildSportsparticipants matching the query
 * @method     ChildSportsparticipants findOneOrCreate(ConnectionInterface $con = null) Return the first ChildSportsparticipants matching the query, or a new ChildSportsparticipants object populated from the query conditions when no match is found
 *
 * @method     ChildSportsparticipants findOneByTeamid(int $TeamID) Return the first ChildSportsparticipants filtered by the TeamID column
 * @method     ChildSportsparticipants findOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildSportsparticipants filtered by the ParticipantCNIC column *

 * @method     ChildSportsparticipants requirePk($key, ConnectionInterface $con = null) Return the ChildSportsparticipants by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsparticipants requireOne(ConnectionInterface $con = null) Return the first ChildSportsparticipants matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSportsparticipants requireOneByTeamid(int $TeamID) Return the first ChildSportsparticipants filtered by the TeamID column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildSportsparticipants requireOneByParticipantcnic(string $ParticipantCNIC) Return the first ChildSportsparticipants filtered by the ParticipantCNIC column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildSportsparticipants[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildSportsparticipants objects based on current ModelCriteria
 * @method     ChildSportsparticipants[]|ObjectCollection findByTeamid(int $TeamID) Return ChildSportsparticipants objects filtered by the TeamID column
 * @method     ChildSportsparticipants[]|ObjectCollection findByParticipantcnic(string $ParticipantCNIC) Return ChildSportsparticipants objects filtered by the ParticipantCNIC column
 * @method     ChildSportsparticipants[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class SportsparticipantsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Model\Model\Base\SportsparticipantsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Model\\Model\\Sportsparticipants', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildSportsparticipantsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildSportsparticipantsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildSportsparticipantsQuery) {
            return $criteria;
        }
        $query = new ChildSportsparticipantsQuery();
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
     * @param array[$TeamID, $ParticipantCNIC] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildSportsparticipants|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(SportsparticipantsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = SportsparticipantsTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
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
     * @return ChildSportsparticipants A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT TeamID, ParticipantCNIC FROM sportsparticipants WHERE TeamID = :p0 AND ParticipantCNIC = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildSportsparticipants $obj */
            $obj = new ChildSportsparticipants();
            $obj->hydrate($row);
            SportsparticipantsTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
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
     * @return ChildSportsparticipants|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SportsparticipantsTableMap::COL_TEAMID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SportsparticipantsTableMap::COL_PARTICIPANTCNIC, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SportsparticipantsTableMap::COL_TEAMID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SportsparticipantsTableMap::COL_PARTICIPANTCNIC, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
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
     * @see       filterBySportsteam()
     *
     * @param     mixed $teamid The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function filterByTeamid($teamid = null, $comparison = null)
    {
        if (is_array($teamid)) {
            $useMinMax = false;
            if (isset($teamid['min'])) {
                $this->addUsingAlias(SportsparticipantsTableMap::COL_TEAMID, $teamid['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($teamid['max'])) {
                $this->addUsingAlias(SportsparticipantsTableMap::COL_TEAMID, $teamid['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsparticipantsTableMap::COL_TEAMID, $teamid, $comparison);
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
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function filterByParticipantcnic($participantcnic = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($participantcnic)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SportsparticipantsTableMap::COL_PARTICIPANTCNIC, $participantcnic, $comparison);
    }

    /**
     * Filter the query by a related \Model\Model\Sportsteam object
     *
     * @param \Model\Model\Sportsteam|ObjectCollection $sportsteam The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function filterBySportsteam($sportsteam, $comparison = null)
    {
        if ($sportsteam instanceof \Model\Model\Sportsteam) {
            return $this
                ->addUsingAlias(SportsparticipantsTableMap::COL_TEAMID, $sportsteam->getTeamid(), $comparison);
        } elseif ($sportsteam instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SportsparticipantsTableMap::COL_TEAMID, $sportsteam->toKeyValue('PrimaryKey', 'Teamid'), $comparison);
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
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
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
     * Filter the query by a related \Model\Model\Participant object
     *
     * @param \Model\Model\Participant|ObjectCollection $participant The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function filterByParticipant($participant, $comparison = null)
    {
        if ($participant instanceof \Model\Model\Participant) {
            return $this
                ->addUsingAlias(SportsparticipantsTableMap::COL_PARTICIPANTCNIC, $participant->getCnic(), $comparison);
        } elseif ($participant instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SportsparticipantsTableMap::COL_PARTICIPANTCNIC, $participant->toKeyValue('PrimaryKey', 'Cnic'), $comparison);
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
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
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
     * @param   ChildSportsparticipants $sportsparticipants Object to remove from the list of results
     *
     * @return $this|ChildSportsparticipantsQuery The current query, for fluid interface
     */
    public function prune($sportsparticipants = null)
    {
        if ($sportsparticipants) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SportsparticipantsTableMap::COL_TEAMID), $sportsparticipants->getTeamid(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SportsparticipantsTableMap::COL_PARTICIPANTCNIC), $sportsparticipants->getParticipantcnic(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the sportsparticipants table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SportsparticipantsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SportsparticipantsTableMap::clearInstancePool();
            SportsparticipantsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(SportsparticipantsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(SportsparticipantsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            SportsparticipantsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            SportsparticipantsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // SportsparticipantsQuery
