<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#A.22rollback.22
 */
class Rollback extends SolrRequest
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
     * {@inheritDoc}
     */
    public function renderBody()
    {
        return '<rollback/>';
    }
}
