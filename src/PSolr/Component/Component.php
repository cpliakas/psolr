<?php

namespace Psolr\Component\Component;

class Component extends \ArrayObject
{
    /**
     * @param array $params
     *
     * @return \Psolr\Component\Component
     */
    static public function factory(array $params = array())
    {
        return new static($params);
    }
}
