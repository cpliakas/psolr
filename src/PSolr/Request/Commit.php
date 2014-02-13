<?php

namespace PSolr\Request;

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
     */
    public function expungeDeletes($expungeDeletes = true)
    {
        $this->expungeDeletes = (bool) $expungeDeletes;
        return $this;
    }
}
