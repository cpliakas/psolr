<?php

namespace PSolr\Response;

class SearchResults extends Response
{
    /**
     * @return \PSolr\Response\DocumentIterator
     */
    public function getIterator()
    {
        return new DocumentIterator($this['response']['docs']);
    }

    /**
     * @return int
     */
    public function params()
    {
        return $this['responseHeader']['params'];
    }

    /**
     * @return int
     */
    public function numFound()
    {
        return $this['response']['numFound'];
    }

    /**
     * @return int
     */
    public function startOffset()
    {
        return $this['response']['start'];
    }

    /**
     * @return array
     */
    public function docs()
    {
        return $this['response']['docs'];
    }
}
