<?php

namespace PSolr\Handler;

class Select extends RequestHandlerAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return 'select';
    }

    /**
     * {@inheritdoc}
     *
     * If params are a string, pass them as the keywords.
     */
    public function sendRequest($solrRequest = array(), $headers = null, array $options = array())
    {
        if (is_string($solrRequest)) {
            $solrRequest = array('q' => $solrRequest);
        }
        return parent::sendRequest($solrRequest, $options, $options);
    }
}
