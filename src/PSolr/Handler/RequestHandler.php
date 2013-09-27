<?php

namespace PSolr\Handler;

/**
 * Useful as a generic request handler building factory.
 */
class RequestHandler extends RequestHandlerAbstract
{
    /**
     * @var string
     */
    protected $path;

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
    public function getPath()
    {
        return $this->path;
    }
}
