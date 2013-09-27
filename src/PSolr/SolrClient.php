<?php

namespace PSolr;

use Guzzle\Common\Collection;
use Guzzle\Http\Url;
use Guzzle\Service\Client;

/**
 * @method array select($params = array(), $headers = null, array $options = array())
 * @method array ping($params = array(), $headers = null, array $options = array())
 */
class SolrClient extends Client
{
    /**
     * @var \PSolr\Handler\RequestHandlerAbstract[]
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
            ->setRequestHandler(new Handler\SelectHandler())
            ->setRequestHandler(new Handler\RequestHandler('admin/ping', 'head', 'ping'))
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
     * {@inheritdoc}
     *
     * Prepends the {+base_path} expressions to the URI.
     */
    public function createRequest($method = 'GET', $uri = null, $headers = null, $body = null, array $options = array())
    {
        $uri = '{+base_path}/' . ltrim($uri, '/');
        return parent::createRequest($method, $uri, $headers, $body, $options);
    }

    /**
     * @param \PSolr\Handler\RequestHandlerAbstract $handler
     *
     * @return \PSolr\SolrClient
     */
    public function setRequestHandler(Handler\RequestHandlerAbstract $handler)
    {
        $handler->setSolrClient($this);
        $handlerName = $handler->getName();
        $this->handlers[$handlerName] = $handler;
        return $this;
    }

    /**
     * @param string $handlerName
     *
     * @return \PSolr\SolrClient
     *
     * @throws
     */
    public function getRequestHandler($handlerName)
    {
        if (!isset($this->handlers[$handlerName])) {
            throw new \OutOfBoundsException('Request handler not registered: ' . $handlerName);
        }
        return $this->handlers[$handlerName];
    }

    /**
     * @param string $name
     *
     * @return \PSolr\SolrClient
     */
    public function removeRequestHandler($name)
    {
        unset($this->handlers[$name]);
        return $this;
    }

    /**
     * @param string $handlerPath
     * @param array $params
     *
     * @return boolean
     */
    public function usePostMethod($handlerPath, array $params)
    {
        $uri = '{+base_path}/' . ltrim($handlerPath, '/');
        $url = Url::factory($this->getBaseUrl())->combine($this->expandTemplate($uri, $params));
        return strlen($url) > $this->getConfig('max_query_length');
    }

    /**
     * @param string $handlerName
     * @param array $params
     * @param array|null $headers
     * @param array $options
     */
    public function sendRequest($handlerName, $params = array(), $headers = null, array $options = array())
    {
        $handler = $this->getRequestHandler($handlerName);
        return $handler->sendRequest($params, $headers, $options);
    }

    /**
     * Alloes request handlers to be called as methods.
     */
    public function __call($name, $arguments)
    {
        array_unshift($arguments, $name);
        return call_user_func_array(array($this, 'sendRequest'), $arguments);
    }
}
