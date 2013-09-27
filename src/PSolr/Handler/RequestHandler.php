<?php

namespace PSolr\Handler;

class RequestHandler extends RequestHandlerAbstract
{
    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $method;

    /**
     * @param string $method
     * @param type $path
     * @param type $name
     */
    public function __construct($path, $method = 'get', $name = null)
    {
        $this->method = $method;
        $this->path = $path;
        if ($name !== null) {
            $this->name = $name;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function buildRequest(array $params, $headers = null, array $options = array())
    {
        $method = $this->getMethod();
        $uri = $this->getPath();

        switch ($method) {
            case 'get':
            case 'head':
                $options['query'] = $params;
                return $this->solr->$method($uri, $headers, $options);

            case 'options':
                return $this->solr->$method($uri, $options);

            default:
                $body = $params ? $params : null;
                return $this->solr->$method($uri, $headers, $params, $options);
        }
    }
}
