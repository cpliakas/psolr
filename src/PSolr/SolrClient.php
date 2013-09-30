<?php

namespace PSolr;

use Guzzle\Common\Collection;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Url;
use Guzzle\Service\Client;

/**
 * @method array select($solrRequest = array(), $headers = null, array $options = array())
 * @method array ping($solrRequest = array(), $headers = null, array $options = array())
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
            'default_params' => array(
                'wt' => 'json',
                'json.nl' => 'map',
            ),
        );

        $required = array(
            'base_url',
            'base_path',
            'max_query_length',
            'default_params',
        );

        // Instantiate and return the Solr client.
        $config = Collection::fromConfig($config, $defaults, $required);
        $solr = new static($config->get('base_url'), $config);

        // Use URI template expansion in a way that doesn't break Solr.
        $solr->setUriTemplate(new SolrUriTemplate());

        $solr
            ->setRequestHandler(new RequestHandler('select', 'select', 'get'))
            ->setRequestHandler(new RequestHandler('ping', 'admin/ping', 'head'))
        ;

        return $solr;
    }

    /**
     * Helper function to set the default params.
     *
     * @param array $params
     *
     * @return \PSolr\SolrClient
     */
    public function setDefaultParams(array $params)
    {
        $this->getConfig()->set('default_params', $params);
        return $this;
    }

    /**
     * Helper function to set the default params.
     *
     * @return array
     */
    public function getDefaultParams()
    {
        return $this->getConfig('default_params');
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
        $solrRequest->mergeDefaultParams($this, $handler);

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
