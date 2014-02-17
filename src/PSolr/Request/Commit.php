<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#A.22commit.22_and_.22optimize.22
 */
class Commit extends Update
{
    /**
     * @var string
     */
    protected $element = 'commit';

    /**
     * @var bool
     */
    protected $expungeDeletes;

    /**
     * @return string
     */
    public function buildAttributes()
    {
        $attributes  = parent::buildAttributes();
        $attributes .= $this->buildAttribute('expungeDeletes');
        return $attributes;
    }

    /**
     * @param bool $expungeDeletes
     *
     * @return \PSolr\Request\Commit
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22commit.22
     */
    public function expungeDeletes($expungeDeletes = true)
    {
        $this->expungeDeletes = (bool) $expungeDeletes;
        return $this;
    }
}
