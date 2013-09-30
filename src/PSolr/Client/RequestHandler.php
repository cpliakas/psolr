<?php

namespace PSolr\Client;

class RequestHandler
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $defaultParams;

    /**
     * @param type $name
     * @param type $path
     * @param string $method
     * @param array $defaultParams
     */
    public function __construct($name, $path, $method, array $defaultParams = array())
    {
        $this->name = $name;
        $this->path = $path;
        $this->method = strtoupper($method);
        $this->defaultParams = $defaultParams;
    }

    /**
     * Returns the name of the method that can be invoked from the client.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the path tp the request handler.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Sets the default parameters for this request handler.
     *
     * @param array $params
     *
     * @return \PSolr\Client\RequestHandler
     */
    public function setDefaultParams(array $params)
    {
        $this->defaultParams = $params;
        return $this;
    }

    /**
     * Sets the default parameters for this request handler.
     *
     * @param string $param
     * @param mixed $value
     *
     * @return \PSolr\Client\RequestHandler
     */
    public function setDefaultParam($param, $value)
    {
        $this->defaultParams[$param] = $value;
        return $this;
    }

    /**
     * Returns the request handler's default parameters.
     *
     * @return array
     */
    public function getDefaultParams()
    {
        return $this->defaultParams;
    }

    /**
     * Sets the default parameters for this request handler.
     *
     * @param string $param
     *
     * @return \PSolr\Client\RequestHandler
     */
    public function removeDefaultParam($param)
    {
        unset($this->defaultParams[$param]);
        return $this;
    }
}
