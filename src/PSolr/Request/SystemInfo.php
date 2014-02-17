<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/SystemInformationRequestHandlers#SystemInfoHandler
 *
 * @method \PSolr\Response\SystemInfo sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class SystemInfo extends SolrRequest
{
    /**
     * @var string
     */
    protected $handlerName = 'system';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\SystemInfo';
}
