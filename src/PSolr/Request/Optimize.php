<?php

namespace PSolr\Request;

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
     */
    public function setMaxSegments($maxSegments)
    {
        $this->maxSegments = (int) $maxSegments;
        return $this;
    }
}
