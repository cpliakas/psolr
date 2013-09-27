<?php

namespace PSolr\Handler;

class SelectHandler extends RequestHandlerAbstract
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
    public function sendRequest($params = array(), $headers = null, array $options = array())
    {
        if (is_string($params)) {
            $params = array('q' => $params);
        }
        return parent::sendRequest($params, $options, $options);
    }
}
