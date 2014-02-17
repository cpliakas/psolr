<?php

namespace PSolr\Client;

use Guzzle\Common\Collection;
use Guzzle\Http\Message\Response;
use Guzzle\Http\Url;
use Guzzle\Service\Client;

/**
 * @method array luke(   $params = array(), $body = null, $headers = null, array $options = array())
 * @method array mbeans( $params = array(), $body = null, $headers = null, array $options = array())
 * @method array mlt(    $params = array(), $body = null, $headers = null, array $options = array())
 * @method array ping(   $params = array(), $body = null, $headers = null, array $options = array())
 * @method array select( $params = array(), $body = null, $headers = null, array $options = array())
 * @method array spell(  $params = array(), $body = null, $headers = null, array $options = array())
 * @method array stats(  $params = array(), $body = null, $headers = null, array $options = array())
 * @method array suggest($params = array(), $body = null, $headers = null, array $options = array())
 * @method array system( $params = array(), $body = null, $headers = null, array $options = array())
 * @method array update( $params = array(), $body = null, $headers = null, array $options = array())
 */
class SolrClient extends Client
{
    const MAX_QUERY_LENGTH = 3600;

    /**
     * @var \PSolr\Client\RequestHandler[]
     */
    protected $handlers = array();

    /**
     * {@inheritdoc}
     *
     * @return \PSolr\Client\SolrClient
     */
    public static function factory($config = array())
    {
        $defaults = array(
            'base_url' => 'http://localhost:8983',
            'base_path' => '/solr',
            'max_query_length' => self::MAX_QUERY_LENGTH,
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
            'wt'      => 'json',
            'json.nl' => 'map',
        );

        // Sometimes we have to use XML :-(.
        $xmlParams = array(
            'wt' => 'xml',
        );

        $solr
            ->setRequestHandler(new RequestHandler('luke',    'admin/luke',      'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('mbeans',  'admin/mbeans',    'GET',  $xmlParams + array('stats' => 'true')))
            ->setRequestHandler(new RequestHandler('mlt',     'mlt',             'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('ping',    'admin/ping',      'HEAD', $jsonParams))
            ->setRequestHandler(new RequestHandler('select',  'select',          'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('spell',   'spell',           'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('stats',   'admin/stats.jsp', 'GET',  $xmlParams))
            ->setRequestHandler(new RequestHandler('suggest', 'suggest',         'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('system',  'admin/system',    'GET',  $jsonParams))
            ->setRequestHandler(new RequestHandler('update',  'update',          'POST', $jsonParams))
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
     * @param \PSolr\Client\RequestHandler $handler
     *
     * @return \PSolr\Client\SolrClient
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
     * @return \PSolr\Client\RequestHandler
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
     * @return \PSolr\Client\SolrClient
     */
    public function removeRequestHandler($handlerName)
    {
        unset($this->handlers[$handlerName]);
        return $this;
    }

    /**
     * @param string $handlerName
     * @param mixed $params
     * @param string|null $body
     * @param array|null $headers
     * @param array $options
     *
     * @return array|\SimpleXMLElement
     */
    public function sendRequest($handlerName, $params = array(), $body = null, $headers = null, array $options = array())
    {
        $handler = $this->getRequestHandler($handlerName);
        $params = $this->normalizeParams($handler, $params);

        // For GETs and HEADs, the params are the query string. For POSTs
        // without a body, the params are post data. For POSTs with a body, the
        // params are the qstring.
        $method = $handler->getMethod();
        if ('GET' == $method || 'HEAD' == $method) {
            $options['query'] = $params;
        } elseif ('POST' == $method) {
            if (null === $body) {
                $body = $params;
            } else {
                $options['query'] = $params;
            }
        }

        $request = $this->createRequest($method, $handler->getPath(), $headers, $body, $options);
        $response = $request->send();
        return $this->parseResponse($response, $params);
    }

    /**
     * Normalizes and merges default params.
     *
     * @param \PSolr\Client\RequestHandler $handler
     * @param mixed $params
     *
     * @return array
     */
    public function normalizeParams(RequestHandler $handler, $params)
    {
        if (is_string($params)) {
            $params = array('q' => $params);
        } elseif (!is_array($params)) {
            $params = (array) $params;
        }
        return array_merge($handler->getDefaultParams(), $params);
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
            $body = $options['query'];
            unset($options['query']);
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
     * @param array $params
     *
     * @return array|\SimpleXMLElement
     */
    public function parseResponse(Response $response, array $params)
    {
        $method = (isset($params['wt']) && 'json' == $params['wt']) ? 'json' : 'xml';
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
