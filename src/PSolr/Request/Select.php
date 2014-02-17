<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/CommonQueryParameters
 * @see http://wiki.apache.org/solr/ExtendedDisMax
 *
 * @method \PSolr\Response\SearchResults sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Select extends SolrRequest
{
    const OPERATOR_AND = 'AND';
    const OPERATOR_OR  = 'OR';

    const DEFTYPE_EDISMAX = 'edismax';

    /**
     * @var string
     */
    protected $handlerName = 'select';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\SearchResults';

    /**
     * Helper function that turns associative arrays into boosted fields.
     *
     * - array('field' => 10.0) = "field^10.0".
     * - array('field' => array(2, 10.0) = "field~2^10.0"
     *
     * @param string|array $fields
     *
     * @see https://wiki.apache.org/solr/DisMaxQParserPlugin#qf_.28Query_Fields.29
     *
     * @todo Rethink this.
     */
    public function buildBoostedFields($fields)
    {
        // Assume strings are pre-formatted.
        if (is_string($fields)) {
            return $fields;
        }

        $processed = array();
        foreach ($fields as $fieldName => $boost) {
            if (!is_array($boost)) {
                $processed[] = $fieldName . '^' . $boost;
            } else {
                $field = $fieldName . '~' . $boost[0];
                if (isset($boost[1])) {
                    $field .= '^' . $boost[1];
                }
                $processed[] = $field;
            }
        }
        return join(',', $processed);
    }

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#q
     */
    public function setQuery($query)
    {
        return $this->set('q', $query);
    }

    /**
     * @param string $sort
     *
     * @return \PSolr\Request\Select
     *
     * @todo Component\Sort.php
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#sort
     */
    public function setSort($sort)
    {
        return $this->set('sort', $sort);
    }

    /**
     * @param int $rows
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#start
     */
    public function setStart($start)
    {
        return $this->set('start', $start);
    }

    /**
     * @param int $rows
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#rows
     */
    public function setRows($rows)
    {
        return $this->set('rows', $rows);
    }

    /**
     * @param int $pageDoc
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#pageDoc_and_pageScore
     */
    public function setPageDoc($pageDoc)
    {
        return $this->set('pageDoc', $pageDoc);
    }

    /**
     * @param float $pageScore
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#pageDoc_and_pageScore
     */
    public function setPageScore($pageScore)
    {
        return $this->set('pageScore', $pageScore);
    }

    /**
     * @param string $fq
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#fq
     */
    public function addFilterQuery($filterQuery)
    {
        return $this->add('fq', $filterQuery);
    }

    /**
     * @param string|array $fieldList
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#fl
     */
    public function setFieldList($fieldList)
    {
        return $this->set('fl', join(',', (array) $fieldList));
    }

    /**
     * @param string $defType
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#defType
     */
    public function setDefType($defType)
    {
        return $this->set('defType', $defType);
    }

    /**
     * @param int $timeAllowed
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#timeAllowed
     */
    public function setTimeAllowed($timeAllowed)
    {
        return $this->set('timeAllowed', $timeAllowed);
    }

    /**
     * @param boolean $omitHeader
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/CommonQueryParameters#omitHeader
     */
    public function omitHeader($omitHeader)
    {
        return $this->set('omitHeader', $omitHeader);
    }

    /**
     * @param string $operator
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/SearchHandler#q.op
     */
    public function setDefaultOperator($operator)
    {
        return $this->set('q.op', $operator);
    }

    /**
     * @param string $field
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/SearchHandler#df
     */
    public function setDefaultField($field)
    {
        return $this->set('df', $field);
    }

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#q.alt
     */
    public function setAlternateQuery($query)
    {
        return $this->set('q.alt', $query);
    }

    /**
     * @param string|array $fields
     *   An associative array of fields to boosts, e.g. array('field' => 2.0);
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#qf_.28Query_Fields.29
     */
    public function setQueryFields($fields)
    {
        return $this->set('qf', $this->buildBoostedFields($fields));
    }

    /**
     * @param string $mm
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#mm_.28Minimum_.27Should.27_Match.29
     */
    public function setMinimumShouldMatch($mm)
    {
        return $this->set('mm', $mm);
    }

    /**
     * @param string $slop
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#qs_.28Query_Phrase_Slop.29
     */
    public function setQueryPhraseSlop($slop)
    {
        return $this->set('qs', $slop);
    }

    /**
     * @param string|array $fields
     *   An associative array of fields to boosts, e.g. array('field' => 2.0).
     *   Pass an array of values to add slop, e.g. array('field', array(2, 10.0)
     *   will render "field~2^10".
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#pf_.28Phrase_Fields.29
     */
    public function setPhraseFields($fields)
    {
        return $this->set('pf', $this->buildBoostedFields($fields));
    }

    /**
     * @param float $slop
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#ps_.28Phrase_Slop.29
     */
    public function setPhraseSlop($slop)
    {
        return $this->set('ps', $slop);
    }

    /**
     * @param string|array $fields
     *   An associative array of fields to boosts, e.g. array('field' => 2.0).
     *   Pass an array of values to add slop, e.g. array('field', array(2, 10.0)
     *   will render "field~2^10".
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#pf2_.28Phrase_bigram_fields.29
     */
    public function setPhraseBigramFields($fields)
    {
        return $this->set('pf2', $this->buildBoostedFields($fields));
    }

    /**
     * @param float $slop
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#ps2_.28Phrase_bigram_slop.29
     */
    public function setPhraseBigramSlop($slop)
    {
        return $this->set('ps2', $slop);
    }

    /**
     * @param string|array $fields
     *   An associative array of fields to boosts, e.g. array('field' => 2.0).
     *   Pass an array of values to add slop, e.g. array('field', array(2, 10.0)
     *   will render "field~2^10".
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#pf3_.28Phrase_trigram_fields.29
     */
    public function setPhraseTrigramFields($fields)
    {
        return $this->set('pf3', $this->buildBoostedFields($fields));
    }

    /**
     * @param float $slop
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#ps3_.28Phrase_trigram_slop.29
     */
    public function setPhraseTrigramSlop($slop)
    {
        return $this->set('ps3', $slop);
    }

    /**
     * @param float $tieBreaker
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#tie_.28Tie_breaker.29
     */
    public function setTieBreaker($tieBreaker)
    {
        return $this->set('tie', $tieBreaker);
    }

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#bq_.28Boost_Query.29
     */
    public function setBoostQuery($query)
    {
        return $this->set('bq', $tieBreaker);
    }

    /**
     * @param string $function
     * @param bool $multiplicative
     *   Defaults to false (additive), pass true for multiplicitive.
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#bf_.28Boost_Function.2C_additive.29
     * @see http://wiki.apache.org/solr/ExtendedDisMax#boost_.28Boost_Function.2C_multiplicative.29
     * @see http://wiki.apache.org/solr/FunctionQuery
     */
    public function addBoostFunction($function, $multiplicative = false)
    {
        $param = $multiplicative ? 'boost' : 'bf';
        return $this->add($param, $function);
    }

    /**
     * @param string|array $fields
     *
     * @return \PSolr\Request\Select
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#uf_.28User_Fields.29
     */
    public function setUserFields($fields)
    {
        return $this->set('uf', join(' ', (array) $fields));
    }

    /**
     * @param bool $interpret
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/ExtendedDisMax#lowercaseOperators
     */
    public function interpretLowercaseOperators($interpret = true)
    {
        return $this->set('lowercaseOperators', (bool) $interpret);
    }
}
