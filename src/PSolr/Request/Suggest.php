<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/Suggester
 *
 * @method \PSolr\Response\Suggestions sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Suggest extends Spellcheck
{
    /**
     * @var string
     */
    protected $handlerName = 'suggest';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Suggestions';

    /**
     * {@inheritDoc}
     */
    public function init() {}

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Suggest
     */
    public function setQuery($query)
    {
        return $this->set('q', $query);
    }
}
