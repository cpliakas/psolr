<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/SimpleFacetParameters
 */
class Facet extends SolrRequest implements ComponentInterface
{
    // Values for facet.sort
    const SORT_COUNT = 'count';
    const SORT_INDEX = 'index';

    // Values for facet.method
    const METHOD_ENUMERATE               = 'enum';
    const METHOD_FIELD_CACHE             = 'fc';
    const METHOD_FIELD_CACHE_PER_SEGMENT = 'fcs';

    // Values for facet.date.other, facet.range.other
    const COUNT_BEFORE  = 'before';
    const COUNT_AFTER   = 'after';
    const COUNT_BETWEEN = 'between';
    const COUNT_NONE    = 'none';
    const COUNT_ALL     = 'all';

    // Values for facet.date.include, facet.range.include
    const INCLUDE_LOWER  = 'lower';
    const INCLUDE_UPPER  = 'upper';
    const INCLUDE_EDGE   = 'edge';
    const INCLUDE_OUTER  = 'outer';
    const INCLUDE_ALL    = 'all';

    /**
     * {@inheritDoc}
     */
    public function preMergeParams(SolrRequest $request) {}

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->facet();
    }

    /**
     * Helper function that builds a facet param based on whether it is global
     * or per-field. If the field is null, the param is global.
     *
     * @param string $facetParam
     * @param string|null $field
     *
     * @return string
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#Parameters
     */
    public function buildParam($facetParam, $field)
    {
        $param = '';

        // Parameter is per-field
        if ($field !== null) {
            $param .= 'f.' . $field . '.';
        }

        $param .= $facetParam;
        return $param;
    }

    /**
     * @param bool $facet
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet
     */
    public function facet($facet = true)
    {
        return $this->set('facet', (bool) $facet);
    }

    /**
     * @param string $query
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.query_:_Arbitrary_Query_Faceting
     */
    public function addQuery($query)
    {
        return $this->add('facet.query', $query);
    }

    /**
     * @param string $field
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.field
     */
    public function addField($field)
    {
        return $this->add('facet.field', $field);
    }

    /**
     * @param string $prefix
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.prefix
     */
    public function setPrefix($prefix, $field = null)
    {
        $param = $this->buildParam('facet.prefix', $field);
        return $this->set($param, $prefix);
    }

    /**
     * @param string $sort
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.sort
     */
    public function setSort($sort, $field = null)
    {
        $param = $this->buildParam('facet.sort', $field);
        return $this->set($param, $sort);
    }

    /**
     * @param int $limit
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.limit
     */
    public function setLimit($limit, $field = null)
    {
        $param = $this->buildParam('facet.limit', $field);
        return $this->set($param, $limit);
    }

    /**
     * @param int $offset
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.offset
     */
    public function setOffset($offset, $field = null)
    {
        $param = $this->buildParam('facet.offset', $field);
        return $this->set($param, $offset);
    }

    /**
     * @param int $mincount
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.mincount
     */
    public function setMincount($mincount, $field = null)
    {
        $param = $this->buildParam('facet.mincount', $field);
        return $this->set($param, $mincount);
    }

    /**
     * @param bool $missing
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.missing
     */
    public function setMissing($missing, $field = null)
    {
        $param = $this->buildParam('facet.missing', $field);
        return $this->set($param, (bool) $missing);
    }

    /**
     * @param string $method
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.method
     */
    public function setMethod($method, $field = null)
    {
        $param = $this->buildParam('facet.method', $field);
        return $this->set($param, $method);
    }

    /**
     * @param int $min
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.enum.cache.minDf
     */
    public function setMinimumDocumentFrequency($min, $field = null)
    {
        $param = $this->buildParam('facet.enum.cache.minDf', $field);
        return $this->set($param, $min);
    }

    /**
     * @param int $threads
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.threads
     */
    public function setThreads($threads, $field = null)
    {
        $param = $this->buildParam('facet.threads', $field);
        return $this->set($param, $threads);
    }

    /**
     * @param string $field
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date
     */
    public function addDateField($field)
    {
        return $this->add('facet.date', $field);
    }

    /**
     * @param string $start
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date.start
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setDateStart($start, $field = null)
    {
        $param = $this->buildParam('facet.date.start', $field);
        return $this->set($param, $start);
    }

    /**
     * @param string $end
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date.end
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setDateEnd($end, $field = null)
    {
        $param = $this->buildParam('facet.date.end', $field);
        return $this->set($param, $end);
    }

    /**
     * @param string $gap
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date.gap
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setDateGap($gap, $field = null)
    {
        $param = $this->buildParam('facet.date.gap', $field);
        return $this->set($param, $gap);
    }

    /**
     * @param bool $hardend
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date.hardend
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setDateHardened($hardend, $field = null)
    {
        $param = $this->buildParam('facet.date.hardend', $field);
        return $this->set($param, (bool) $hardend);
    }

    /**
     * @param string $other
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date.other
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setDateOther($other, $field = null)
    {
        $param = $this->buildParam('facet.date.other', $field);
        return $this->set($param, $other);
    }

    /**
     * @param string $include
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.date.include
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setDateInclude($include, $field = null)
    {
        $param = $this->buildParam('facet.date.include', $field);
        return $this->set($param, $include);
    }

    /**
     * @param string $field
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range
     */
    public function addRangeField($field)
    {
        return $this->add('facet.range', $field);
    }

    /**
     * @param string $start
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range.start
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setRangeStart($start, $field = null)
    {
        $param = $this->buildParam('facet.range.start', $field);
        return $this->set($param, $start);
    }

    /**
     * @param string $end
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range.end
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setRangeEnd($end, $field = null)
    {
        $param = $this->buildParam('facet.range.end', $field);
        return $this->set($param, $end);
    }

    /**
     * @param string $gap
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range.gap
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setRangeGap($gap, $field = null)
    {
        $param = $this->buildParam('facet.range.gap', $field);
        return $this->set($param, $gap);
    }

    /**
     * @param bool $hardend
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range.hardend
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setRangeHardened($hardend, $field = null)
    {
        $param = $this->buildParam('facet.range.hardend', $field);
        return $this->set($param, (bool) $hardend);
    }

    /**
     * @param string $other
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range.other
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setRangeOther($other, $field = null)
    {
        $param = $this->buildParam('facet.range.other', $field);
        return $this->set($param, $other);
    }

    /**
     * @param string $include
     * @param string|null $field
     *
     * @return \PSolr\Request\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.range.include
     * @see http://lucene.apache.org/solr/4_0_0/solr-core/org/apache/solr/util/DateMathParser.html
     */
    public function setRangeInclude($include, $field = null)
    {
        $param = $this->buildParam('facet.range.include', $field);
        return $this->set($param, $include);
    }

    /**
     * @param string|array $fields
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.pivot
     */
    public function addPivot($fields)
    {
        return $this->add('facet.pivot', join(',', (array) $fields));
    }

    /**
     * @param int $min
     *
     * @return \Psolr\Component\Facet
     *
     * @see http://wiki.apache.org/solr/SimpleFacetParameters#facet.pivot.mincount
     */
    public function setPivotMincount($min)
    {
        return $this->add('facet.mincount', $min);
    }
}
