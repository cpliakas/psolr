<?php

namespace PSolr\Response;

class Spellcheck extends Response
{
    /**
     * Iterates over the suggestions
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        $suggestions = $this['spellcheck']['suggestions'][$this->params['q']]['suggestion'];
        return new \ArrayIterator($suggestions);
    }

    /**
     * @return int
     */
    public function numFound()
    {
        return $this['spellcheck']['suggestions'][$this->params['q']]['numFound'];
    }

    /**
     * @return int
     */
    public function startOffset()
    {
        return $this['spellcheck']['suggestions'][$this->params['q']]['startOffset'];
    }

    /**
     * @return int
     */
    public function endOffset()
    {
        return $this['spellcheck']['suggestions'][$this->params['q']]['endOffset'];
    }

    /**
     * @return int
     */
    public function collation()
    {
        return $this['spellcheck']['suggestions']['collation'];
    }

    /**
     * Returns the "collation", or recommendation.
     */
    public function __toString()
    {
        return $this->collation();
    }
}
