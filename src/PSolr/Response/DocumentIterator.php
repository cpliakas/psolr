<?php

namespace PSolr\Response;

class DocumentIterator extends \ArrayIterator
{
    public function current()
    {
        return new Document(parent::current());
    }
}
