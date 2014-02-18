<?php

namespace PSolr\Response;

class Luke extends Response
{
    /**
     * @return int
     */
    public function numDocs()
    {
        return $this['index']['numDocs'];
    }

    /**
     * @return int
     */
    public function maxDoc()
    {
        return $this['index']['maxDoc'];
    }

    /**
     * @return int
     */
    public function numTerms()
    {
        return $this['index']['numTerms'];
    }

    /**
     * @return double
     */
    public function version()
    {
        return $this['index']['version'];
    }

    /**
     * @return int
     */
    public function segmentCount()
    {
        return $this['index']['segmentCount'];
    }

    /**
     * @return bool
     */
    public function isCurrent()
    {
        return $this['index']['current'];
    }

    /**
     * @return bool
     */
    public function hasDeletions()
    {
        return $this['index']['hasDeletions'];
    }

    /**
     * @return string
     */
    public function directory()
    {
        return $this['index']['directory'];
    }

    /**
     * @return \DateTime
     */
    public function lastModified()
    {
        return new \DateTime($this['index']['lastModified']);
    }
}