<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/CommonQueryParameters
 *
 * @method \PSolr\Response\SearchResults sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Select extends SolrRequest
{
    const OPERATOR_AND = 'AND';
    const OPERATOR_OR  = 'OR';

    /**
     * @var string
     */
    protected $handlerName = 'select';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\SearchResults';

    /**
     * Helper function that turns associative arrays into query fields.
     *
     * @param string|array $fields
     *
     * @see https://wiki.apache.org/solr/DisMaxQParserPlugin#qf_.28Query_Fields.29
     */
    public function buildQueryFields($fields)
    {
        // Assume strings are pre-formatted.
        if (is_string($fields)) {
            return $fields;
        }

        $processed = array();
        foreach ($fields as $field => $boost) {
            $processed = $field . '^' . $boost;
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
}
