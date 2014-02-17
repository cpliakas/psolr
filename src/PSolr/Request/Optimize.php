<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#A.22commit.22_and_.22optimize.22
 */
class Optimize extends Update
{
    /**
     * @var string
     */
    protected $element = 'optimize';

    /**
     * @var int
     */
    protected $maxSegments;

    /**
     * @return string
     */
    public function buildAttributes()
    {
        $attributes  = parent::buildAttributes();
        $attributes .= $this->buildAttribute('maxSegments');
        return $attributes;
    }

    /**
     * @param int $maxSegments
     *
     * @return \PSolr\Request\Commit
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22optimize.22
     */
    public function setMaxSegments($maxSegments)
    {
        $this->maxSegments = (int) $maxSegments;
        return $this;
    }
}
