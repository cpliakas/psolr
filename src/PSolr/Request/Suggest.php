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
     * @var protected
     */
    protected $handlerName = 'suggest';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Suggestions';

    /**
     * {@inheritDoc}
     */
    public function __construct(array $array = array())
    {
        parent::__construct($array);
        unset($this['spellcheck']);
    }

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Suggest
     */
    public function setQuery($query)
    {
        $this['q'] = $query;
        return $this;
    }
}
