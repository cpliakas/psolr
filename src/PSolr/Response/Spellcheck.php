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
        return new \ArrayIterator($this->suggestions());
    }

    /**
     * @return array
     */
    public function suggestions()
    {
        if (isset($this['spellcheck']['suggestions'][$this->params['q']]['suggestion'])) {
            return $this['spellcheck']['suggestions'][$this->params['q']]['suggestion'];
        } else {
            return array();
        }
    }

    /**
     * @return int
     */
    public function numFound()
    {
        if (isset($this['spellcheck']['suggestions'][$this->params['q']]['numFound'])) {
            return $this['spellcheck']['suggestions'][$this->params['q']]['numFound'];
        } else {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function startOffset()
    {
        if (isset($this['spellcheck']['suggestions'][$this->params['q']]['startOffset'])) {
            return $this['spellcheck']['suggestions'][$this->params['q']]['startOffset'];
        } else {
            return 0;
        }
    }

    /**
     * @return int
     */
    public function endOffset()
    {
        if (isset($this['spellcheck']['suggestions'][$this->params['q']]['endOffset'])) {
            return $this['spellcheck']['suggestions'][$this->params['q']]['endOffset'];
        } else {
            return 0;
        }
    }

    /**
     * @return string
     */
    public function collation()
    {
        if (isset($this['spellcheck']['suggestions']['collation'])) {
            return $this['spellcheck']['suggestions']['collation'];
        } else {
            return '';
        }
    }

    /**
     * Returns the "collation", or recommendation.
     */
    public function __toString()
    {
        return $this->collation();
    }
}
