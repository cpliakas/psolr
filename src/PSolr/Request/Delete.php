<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#A.22delete.22_documents_by_ID_and_by_Query
 */
class Delete extends SolrRequest
{
    /**
     * @var string
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
     * {@inheritDoc}
     */
    public function renderBody()
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
}
