<?php

namespace PSolr\Request;

/**
 * @see https://wiki.apache.org/solr/SpellCheckComponent
 *
 * @method \PSolr\Response\Spellcheck sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Spellcheck extends SolrRequest implements ComponentInterface
{
    /**
     * @var protected
     */
    protected $handlerName = 'spell';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Spellcheck';

    /**
     * {@inheritDoc}
     *
     * Sets the query that is used in the base query.
     */
    public function preMergeParams(SolrRequest $request)
    {
        if (isset($request['q']) && !isset($this['hl.q'])) {
            $this['hl.q'] = $request['q'];
        }
    }

    /**
     * {@inheritDoc}
     */
    public function __construct(array $array = array())
    {
        parent::__construct($array);
        $this->spellcheck();
    }

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Suggest
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#q_OR_spellcheck.q
     */
    public function setQuery($query)
    {
        $this['q'] = $query;
        return $this;
    }

    /**
     * @param bool $spellcheck
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck
     */
    public function spellcheck($spellcheck = true)
    {
        $this['spellcheck'] = $spellcheck ? 'true' : 'false';
        return $this;
    }

    /**
     * @param bool $build
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.build
     */
    public function build($build = true)
    {
        $this['spellcheck.build'] = $build ? 'true' : 'false';
        return $this;
    }

    /**
     * @param bool $reload
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.reload
     */
    public function reload($reload = true)
    {
        $this['spellcheck.reload'] = $reload ? 'true' : 'false';
        return $this;
    }

    /**
     * @param string $dictionary
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.dictionary
     */
    public function setDictionary($dictionary)
    {
        $this['spellcheck.dictionary'] = $dictionary;
        return $this;
    }

    /**
     * @param int $count
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.count
     */
    public function setCount($count)
    {
        $this['spellcheck.count'] = $count;
        return $this;
    }

    /**
     * @param int $count
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.alternativeTermCount
     */
    public function setAlternativeTermCount($count)
    {
        $this['spellcheck.alternativeTermCount'] = $count;
        return $this;
    }

    /**
     * @param bool $onlyMorePopular
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.onlyMorePopular
     */
    public function onlyMorePopular($onlyMorePopular = true)
    {
        $this['spellcheck.onlyMorePopular'] = $onlyMorePopular ? 'true' : 'false';
        return $this;
    }

    /**
     * @param int $maxResults
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.maxResultsForSuggest
     */
    public function setMaxResultsForSuggest($maxResults)
    {
        $this['spellcheck.maxResultsForSuggest'] = $maxResults;
        return $this;
    }

    /**
     * @param bool $collate
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collate
     */
    public function collate($collate = true)
    {
        $this['spellcheck.collate'] = $collate ? 'true' : 'false';
        return $this;
    }

    /**
     * @param int $maxCollations
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.maxCollations
     */
    public function setMaxCollations($maxCollations)
    {
        $this['spellcheck.maxCollations'] = $maxCollations;
        return $this;
    }

    /**
     * @param int $maxTries
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.maxCollationTries
     */
    public function setMaxCollationTries($maxTries)
    {
        $this['spellcheck.maxCollationTries'] = $maxTries;
        return $this;
    }

    /**
     * @param string $param
     * @param string $value
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collateParam.XX
     */
    public function setCollateParam($param, $value)
    {
        $this['spellcheck.collateParam.' . $param] = $value;
        return $this;
    }

    /**
     * @param bool $collate
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collateExtendedResults
     */
    public function collateExtendedResults($collate = true)
    {
        $this['spellcheck.collateExtendedResults'] = $collate ? 'true' : 'false';
        return $this;
    }

    /**
     * @param int $maxDocs
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collateMaxCollectDocs
     */
    public function setCollateMaxCollectDocs($maxDocs)
    {
        $this['spellcheck.collateMaxCollectDocs'] = $maxDocs;
        return $this;
    }

    /**
     * @param float $accuracy
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck.accuracy
     */
    public function setAccuracy($accuracy)
    {
        $this['spellcheck.accuracy'] = $accuracy;
        return $this;
    }

    /**
     * @param string $dictionary
     * @param string $key
     * @param string $value
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see https://wiki.apache.org/solr/SpellCheckComponent#spellcheck..3CDICT_NAME.3E.key
     */
    public function setDictionaryParam($dictionary, $key, $value)
    {
        $this['spellcheck.' . $dictionary . '.' . $key] = $value;
        return $this;
    }
}
