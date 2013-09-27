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
     */
    public function sendRequest($params, $headers = null, array $options = array())
    {
        if (is_string($params)) {
            $params = array('q' => $params);
        }
        return parent::sendRequest($params, $options, $options);
    }

    /**
     * {@inheritdoc}
     *
     * Issue GET or POST request depending on url length.
     */
    public function buildRequest(array $params, $headers = null, array $options = array())
    {
        $uri = $this->getPath();
        if ($this->solr->useGetMethod($uri, $params)) {
            $options['query'] = $params;
            $request = $this->solr->get($uri, $headers, $options);
        } else {
            unset($options['query']);
            $request = $this->solr->post($uri, $headers, $params, $options);
        }

        return $request;
    }
}
