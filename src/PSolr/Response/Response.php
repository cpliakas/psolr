<?php

namespace PSolr\Response;

class Response extends \ArrayObject
{
    /**
     * @var array
     */
    protected $params;

    /**
     * @param array $data
     * @param array $params
     */
    public function __construct($data, array $params)
    {
        $this->params = $params;
        parent::__construct($data);
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params();
    }

    /**
     * @return int
     */
    public function QTime()
    {
        return $this['responseHeader']['QTime'];
    }

    /**
     * @return int
     */
    public function status()
    {
        return $this['responseHeader']['status'];
    }
}
