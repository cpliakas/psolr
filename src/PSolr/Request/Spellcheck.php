<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/SpellCheckComponent
 *
 * @method \PSolr\Response\Spellcheck sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Spellcheck extends SolrRequest implements ComponentInterface
{
    /**
     * @var string
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
            $this['spellcheck.q'] = $request['q'];
        }
    }

    /**
     * {@inheritDoc}
     *
     * Enables spell checking.
     */
    public function init()
    {
        $this->spellcheck();
    }

    /**
     * @param string $query
     *
     * @return \PSolr\Request\Suggest
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#q_OR_spellcheck.q
     */
    public function setQuery($query)
    {
        return $this->set('spellcheck.q', $query);
    }

    /**
     * @param bool $spellcheck
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck
     */
    public function spellcheck($spellcheck = true)
    {
        return $this->set('spellcheck', $spellcheck);
    }

    /**
     * @param bool $build
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.build
     */
    public function build($build = true)
    {
        return $this->set('spellcheck.build', $build);
    }

    /**
     * @param bool $reload
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.reload
     */
    public function reload($reload = true)
    {
        return $this->set('spellcheck.reload', $reload);
    }

    /**
     * @param string $dictionary
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.dictionary
     */
    public function setDictionary($dictionary)
    {
        return $this->set('spellcheck.dictionary', $dictionary);
    }

    /**
     * @param int $count
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.count
     */
    public function setCount($count)
    {
        return $this->set('spellcheck.dictionary', $count);
    }

    /**
     * @param int $count
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.alternativeTermCount
     */
    public function setAlternativeTermCount($count)
    {
        return $this->set('spellcheck.alternativeTermCount', $count);
    }

    /**
     * @param bool $onlyMorePopular
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.onlyMorePopular
     */
    public function onlyMorePopular($onlyMorePopular = true)
    {
        return $this->set('spellcheck.onlyMorePopular', $onlyMorePopular);
    }

    /**
     * @param int $maxResults
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.maxResultsForSuggest
     */
    public function setMaxResultsForSuggest($maxResults)
    {
        return $this->set('spellcheck.maxResultsForSuggest', $maxResults);
    }

    /**
     * @param bool $collate
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collate
     */
    public function collate($collate = true)
    {
        return $this->set('spellcheck.collate', $collate);
    }

    /**
     * @param int $maxCollations
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.maxCollations
     */
    public function setMaxCollations($maxCollations)
    {
        return $this->set('spellcheck.maxCollations', $maxCollations);
    }

    /**
     * @param int $maxTries
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.maxCollationTries
     */
    public function setMaxCollationTries($maxTries)
    {
        return $this->set('spellcheck.maxCollationTries', $maxTries);
    }

    /**
     * @param string $param
     * @param string $value
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collateParam.XX
     */
    public function setCollateParam($param, $value)
    {
        return $this->set('spellcheck.collateParam.' . $param, $value);
    }

    /**
     * @param bool $collate
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collateExtendedResults
     */
    public function collateExtendedResults($collate = true)
    {
        return $this->set('spellcheck.collateExtendedResults', $collate);
    }

    /**
     * @param int $maxDocs
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.collateMaxCollectDocs
     */
    public function setCollateMaxCollectDocs($maxDocs)
    {
        return $this->set('spellcheck.collateMaxCollectDocs', $maxDocs);
    }

    /**
     * @param float $accuracy
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck.accuracy
     */
    public function setAccuracy($accuracy)
    {
        return $this->set('spellcheck.accuracy', $accuracy);
    }

    /**
     * @param string $dictionary
     * @param string $key
     * @param string $value
     *
     * @return \Psolr\Component\Spellcheck
     *
     * @see http://wiki.apache.org/solr/SpellCheckComponent#spellcheck..3CDICT_NAME.3E.key
     */
    public function setDictionaryParam($dictionary, $key, $value)
    {
        return $this->set('spellcheck.' . $dictionary . '.' . $key, $value);
    }
}
