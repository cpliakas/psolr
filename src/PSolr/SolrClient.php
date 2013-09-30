<?php

namespace PSolr;

use Guzzle\Common\Collection;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Url;
use Guzzle\Service\Client;

/**
 * @method array luke($solrRequest = array(), $headers = null, array $options = array())
 * @method array mbeans($solrRequest = array(), $headers = null, array $options = array())
 * @method array ping($solrRequest = array(), $headers = null, array $options = array())
 * @method array select($solrRequest = array(), $headers = null, array $options = array())
 * @method array stats($solrRequest = array(), $headers = null, array $options = array())
 * @method array system($solrRequest = array(), $headers = null, array $options = array())
 * @method array update($solrRequest = array(), $headers = null, array $options = array())
 */
class SolrClient extends Client
{
    /**
     * @var \PSolr\RequestHandler[]
     */
    protected $handlers = array();

    /**
     * {@inheritdoc}
     *
     * @return \PSolr\SolrClient
     */
    public static function factory($config = array())
    {
        $defaults = array(
            'base_url' => 'http://localhost:8983',
            'base_path' => '/solr',
            'max_query_length' => 3500,
        );

        $required = array(
            'base_url',
            'base_path',
            'max_query_length',
        );

        // Instantiate and return the Solr client.
        $config = Collection::fromConfig($config, $defaults, $required);
        $solr = new static($config->get('base_url'), $config);

        // Use URI template expansion in a way that doesn't break Solr.
        $solr->setUriTemplate(new SolrUriTemplate());

        // Use JSON whenever possible.
        // @see http://code.google.com/p/solr-php-client/issues/detail?id=6#c1
        $jsonParams = array(
            'wt' => 'json',
            'json.nl' => 'map',
        );

        // Sometimes we have to use XML :-(.
        $xmlParams = array(
            'wt' => 'xml',
        );

        $solr
            ->setRequestHandler(new RequestHandler('luke',   'admin/luke',      'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('mbeans', 'admin/mbeans',    'GET',  $xmlParams + array('stats' => 'true')))
            ->setRequestHandler(new RequestHandler('ping',   'admin/ping',      'HEAD', $jsonParams))
            ->setRequestHandler(new RequestHandler('select', 'select',          'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('stats',  'admin/stats.jsp', 'GET',  $xmlParams))
            ->setRequestHandler(new RequestHandler('system', 'admin/system',    'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('update', 'update',          'POST'))
        ;

        return $solr;
    }

    /**
     * @param string $handlerName
     *
     * @return boolean
     */
    public function hasRequestHandler($handlerName)
    {
        return isset($this->handlers[$handlerName]);
    }

    /**
     * @param \PSolr\RequestHandler $handler
     *
     * @return \PSolr\SolrClient
     */
    public function setRequestHandler(RequestHandler $handler)
    {
        $handlerName = $handler->getName();
        $this->handlers[$handlerName] = $handler;
        return $this;
    }

    /**
     * @param string $handlerName
     *
     * @return \PSolr\RequestHandler
     *
     * @throws \OutOfBoundsException
     */
    public function getRequestHandler($handlerName)
    {
        if (!isset($this->handlers[$handlerName])) {
            throw new \OutOfBoundsException('Request handler not registered: ' . $handlerName);
        }
        return $this->handlers[$handlerName];
    }

    /**
     * @param string $handlerName
     *
     * @return \PSolr\SolrClient
     */
    public function removeRequestHandler($handlerName)
    {
        unset($this->handlers[$handlerName]);
        return $this;
    }

    /**
     * @param string $handlerName
     * @param \PSolr\SolrRequest|array|string $solrRequest
     * @param array|null $headers
     * @param array $options
     *
     * @return array|\SimpleXMLElement
     */
    public function sendRequest($handlerName, $solrRequest = array(), $headers = null, array $options = array())
    {
        $handler = $this->getRequestHandler($handlerName);

        $solrRequest = $this->normalizeSolrRequest($solrRequest);
        $solrRequest->mergeDefaultParams($handler);

        $method = $handler->getMethod();
        $body = $solrRequest->getBody();

        // For GETs and HEADs, the params are the query string. For POSTs
        // without a body, the params are post data. For POSTs with a body, the
        // params are the qstring.
        if ('GET' == $method || 'HEAD' == $method) {
            $options['query'] = (array) $solrRequest;
        } elseif ('POST' == $method) {
            if (null === $body) {
                $body = (array) $solrRequest;
            } else {
                $options['query'] = (array) $solrRequest;
            }
        }

        $uri = $handler->getPath();
        $response = $this->createRequest($method, $uri, $headers, $body, $options)->send();
        return $this->parseResponse($response, $solrRequest);
    }

    /**
     * @param \PSolr\SolrRequest|array|string
     *
     * @return \PSolr\SolrRequest
     */
    public function normalizeSolrRequest($solrRequest)
    {
        if (is_string($solrRequest)) {
            $solrRequest = array('q' => $solrRequest);
        }
        if (!$solrRequest instanceof SolrRequest) {
            $solrRequest = new SolrRequest($solrRequest);
        }
        return $solrRequest;
    }

    /**
     * {@inheritdoc}
     *
     * Prepends the {+base_path} expressions to the URI, converts the GET to a
     * POST if the query string is too long.
     */
    public function createRequest($method = 'GET', $uri = null, $headers = null, $body = null, array $options = array())
    {
        $uri = '{+base_path}/' . ltrim($uri, '/');
        if ('GET' == $method && $this->usePostMethod($uri, $options)) {
            $method = 'POST';
        }
        return parent::createRequest($method, $uri, $headers, $body, $options);
    }

    /**
     * @param string $uri
     * @param array $options
     *
     * @return boolean
     */
    public function usePostMethod($uri, array $options)
    {
        if (isset($options['query'])) {
            $url = Url::factory($this->getBaseUrl())->combine($this->expandTemplate($uri, $options['query']));
            return strlen($url) > $this->getConfig('max_query_length');
        }
        return false;
    }

    /**
     * @param \Guzzle\Http\Message\Response $response
     * @param \PSolr\SolrRequest $solrRequest
     *
     * @return array|\SimpleXMLElement
     */
    public function parseResponse(Response $response, SolrRequest $solrRequest)
    {
        $method = (isset($solrRequest['wt']) && 'json' == $solrRequest['wt']) ? 'json' : 'xml';
        return $response->$method();
    }

    /**
     * Allows request handlers to be called as methods.
     */
    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);
        return call_user_func_array(array($this, 'sendRequest'), $arguments);
    }
}
