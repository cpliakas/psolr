<?php

namespace PSolr\Request;

class Update extends SolrRequest
{
    /**
     * @var protected
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
