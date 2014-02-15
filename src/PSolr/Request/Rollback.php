<?php

namespace PSolr\Request;

/**
 * @see https://wiki.apache.org/solr/UpdateXmlMessages#A.22rollback.22
 */
class Rollback extends SolrRequest
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
     * {@inheritDoc}
     */
    public function renderBody()
    {
        return '<rollback/>';
    }
}
