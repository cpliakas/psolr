<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/Suggester
 *
 * @method \PSolr\Response\Spellcheck sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Suggest extends SolrRequest
{
    /**
     * @var protected
     */
    protected $handlerName = 'suggest';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Spellcheck';

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Suggest
     *
     * @see http://wiki.apache.org/solr/Suggester
     */
    public function setQuery($query)
    {
        $this['q'] = $query;
        return $this;
    }
}
