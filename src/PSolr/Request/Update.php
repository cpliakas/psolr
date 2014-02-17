<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages
 */
class Update extends SolrRequest
{
    /**
     * @var string
     */
    protected $handlerName = 'update';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Response';

    /**
     * @var string
     */
    protected $element = 'commit';

    /**
     * @var bool
     */
    protected $waitFlush;

    /**
     * @var bool
     */
    protected $waitSearcher;

    /**
     * @var bool
     */
    protected $softCommit;

    /**
     * @param bool $waitFlush
     *
     * @return \PSolr\Request\Commit
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22commit.22_and_.22optimize.22
     */
    public function waitFlush($waitFlush = true)
    {
        $this->waitFlush = (bool) $waitFlush;
        return $this;
    }

    /**
     * @param bool $waitSearcher
     *
     * @return \PSolr\Request\Commit
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22commit.22_and_.22optimize.22
     */
    public function waitSearcher($waitSearcher = true)
    {
        $this->waitSearcher = (bool) $waitSearcher;
        return $this;
    }

    /**
     * @param bool $softCommit
     *
     * @return \PSolr\Request\Commit
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22commit.22_and_.22optimize.22
     */
    public function softCommit($softCommit = true)
    {
        $this->softCommit = (bool) $softCommit;
        return $this;
    }

    /**
     * @return string
     */
    public function buildAttributes()
    {
        $attributes  = '';
        $attributes .= $this->buildAttribute('waitFlush');
        $attributes .= $this->buildAttribute('waitSearcher');
        $attributes .= $this->buildAttribute('softCommit');
        return $attributes;
    }

    /**
     * Builds an attribute from a class property if it is set.
     *
     * @param string $property
     *
     * @return string
     */
    public function buildAttribute($property)
    {
        $attribute = '';
        if (isset($this->$property)) {
            $attribute .= ' ' . $property . '="';
            if (is_bool($this->$property)) {
                $attribute .= ($this->$property) ? 'true' : 'false';
            } else {
                $attribute .= SolrRequest::escapeXml($this->$property);
            }
            $attribute .= '"';
        }
        return $attribute;
    }

    /**
     * {@inheritDoc}
     */
    public function renderBody()
    {
        return '<' . $this->element . $this->buildAttributes() . '/>';
    }
}
