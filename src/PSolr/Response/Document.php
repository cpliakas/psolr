<?php

namespace PSolr\Response;

class Document extends \ArrayObject
{
    /**
     * @param mixed $array
     */
    public function __construct($array)
    {
        parent::__construct($array, \ArrayObject::ARRAY_AS_PROPS);
    }
}
