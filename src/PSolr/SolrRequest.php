<?php

namespace PSolr;

class SolrRequest extends \ArrayObject
{
    /**
     * @var string|null
     */
    protected $body;

    /**
     * @param array $params
     * @param string|null $body
     */
    public function __construct(array $params = array(), $body = null)
    {
        parent::__construct($params);
        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->getArrayCopy();
    }

    /**
     * @param string|null $body
     *
     * @return \PSolr\Request\Request
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param \PSolr\RequestHandler $handler
     */
    public function mergeDefaultParams(RequestHandler $handler)
    {
        $mergedParams = array_merge($handler->getDefaultParams(), (array) $this);
        $this->exchangeArray($mergedParams);
    }
}
