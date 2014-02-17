<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/MoreLikeThis
 * @see http://wiki.apache.org/solr/MoreLikeThisHandler
 */
class MoreLikeThis extends Select implements ComponentInterface
{
    /**
     * @var string
     */
    protected $handlerName = 'mlt';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Response';

    /**
     * {@inheritDoc}
     */
    public function preMergeParams(SolrRequest $request) {}

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->mlt();
    }

    /**
     * @param bool $mlt
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#MoreLikeThisComponent
     */
    public function mlt($mlt = true)
    {
        return $this->set('mlt', (bool) $mlt);
    }

    /**
     * @param bool $count
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#MoreLikeThisComponent
     */
    public function setCount($count)
    {
        return $this->set('mlt.count', (int) $count);
    }

    /**
     * @param string|array $fields
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setSimilarityFields($fields)
    {
        return $this->set('mlt.fl', join(',', (array) $fields));
    }

    /**
     * @param int $min
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setMinimumTermFrequency($min)
    {
        return $this->set('mlt.mintf', $min);
    }

    /**
     * @param int $min
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setMinimumDocumentFrequency($min)
    {
        return $this->set('mlt.mindf', $min);
    }

    /**
     * @param int $min
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setMinimumWordLength($min)
    {
        return $this->set('mlt.minwl', $min);
    }

    /**
     * @param int $max
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setMaximumWordLength($max)
    {
        return $this->set('mlt.maxwl', $max);
    }

    /**
     * @param int $max
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setMaximumQueryTerms($max)
    {
        return $this->set('mlt.maxqt', $max);
    }

    /**
     * @param int $max
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setMaximumTokens($max)
    {
        return $this->set('mlt.maxntp', $max);
    }

    /**
     * @param bool $boost
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function boost($boost = true)
    {
        return $this->set('mlt.boost', (bool) $boost);
    }

    /**
     * @param string|array $fields
     *   An associative array of fields to boosts, e.g. array('field' => 2.0);
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThis#Common_Parameters
     */
    public function setQueryFields($fields)
    {
        return $this->set('mlt.qf', $this->buildBoostedFields($fields));
    }

    //
    // Handler params
    //

    /**
     * @param bool $include
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThisHandler#Params
     */
    public function includeMatchedDocuments($include = true)
    {
        return $this->set('mlt.match.include', (bool) $include);
    }

    /**
     * @param int $offset
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThisHandler#Params
     */
    public function setMatchOffset($offset)
    {
        return $this->set('mlt.match.offset', $offset);
    }

    /**
     * @param int $option
     *
     * @return \PSolr\Request\MoreLikeThis
     *
     * @see http://wiki.apache.org/solr/MoreLikeThisHandler#Params
     */
    public function setInterestingTerms($option)
    {
        return $this->set('mlt.interestingTerms', $option);
    }
}
