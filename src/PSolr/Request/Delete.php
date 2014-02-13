<?php

namespace PSolr\Request;

class Delete extends SolrRequest
{
    /**
     * @var protected
     */
    protected $handlerName = 'update';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Response';

    /**
     * @var array
     */
    protected $ids = array();

    /**
     * @var array
     */
    protected $queries = array();

    /**
     * @param string $id
     *
     * @return \PSolr\Request\Delete
     */
    public function addId($id)
    {
        $this->ids[] = $id;
        return $this;
    }

    /**
     * @param string $query
     */
    public function addQuery($query)
    {
        $this->queries[] = $query;
        return $this;
    }

    /**
     * @return string
     */
    public function asXml()
    {
        $xml = '<delete>';

        foreach ($this->ids as $id) {
            $xml .= '<id>' . SolrRequest::escapeXml($id) . '</id>';
        }

        foreach ($this->queries as $query) {
            $xml .= '<query>' . SolrRequest::escapeXml($query) . '</query>';
        }

        $xml .= '</delete>';
        return SolrRequest::stripCtrlChars($xml);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->asXml();
    }
}
