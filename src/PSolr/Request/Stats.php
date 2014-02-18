<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/StatsComponent
 */
class Stats extends SolrRequest implements ComponentInterface
{
    /**
     * {@inheritDoc}
     */
    public function preMergeParams(SolrRequest $request) {}

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->stats();
    }

    /**
     * @param bool $stats
     *
     * @return \PSolr\Request\Stats
     *
     * @see http://wiki.apache.org/solr/StatsComponent
     */
    public function stats($stats = true)
    {
        return $this->set('stats', (bool) $stats);
    }

    /**
     * @param string $field
     *
     * @return \PSolr\Request\Stats
     *
     * @see http://wiki.apache.org/solr/StatsComponent
     */
    public function addField($field)
    {
        return $this->add('stats.field', $field);
    }

    /**
     * @param string $facet
     *
     * @return \PSolr\Request\Stats
     *
     * @see http://wiki.apache.org/solr/StatsComponent
     */
    public function addFacet($facet)
    {
        return $this->add('stats.facet', $facet);
    }
}
