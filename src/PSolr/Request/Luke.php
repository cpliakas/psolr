<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/LukeRequestHandler
 *
 * @method \PSolr\Response\Luke sendRequest(\PSolr\Request\SolrClient $solr, $headers = null, array $options = array())
 */
class Luke extends SolrRequest
{
    /**
     * @var string
     */
    protected $handlerName = 'luke';

    /**
     * $var string
     */
    protected $responseClass = '\PSolr\Response\Luke';

    /**
     * @param int $numTerms
     *
     * @return \PSolr\Request\Luke
     *
     * @see http://wiki.apache.org/solr/LukeRequestHandler#numTerms
     */
    public function setNumTerms($numTerms)
    {
        return $this->set('numTerms', $numTerms);
    }

    /**
     * @param string|array $fieldList
     *
     * @return \PSolr\Request\Luke
     *
     * @see http://wiki.apache.org/solr/LukeRequestHandler#fl
     */
    public function setFieldList($fieldList)
    {
        return $this->set('fl', join(',', (array) $fieldList));
    }

    /**
     * @param string $id
     *
     * @return \PSolr\Request\Luke
     *
     * @see http://wiki.apache.org/solr/LukeRequestHandler#id
     */
    public function setId($id)
    {
        return $this->set('id', $id);
    }

    /**
     * @param string $id
     *
     * @return \PSolr\Request\Luke
     *
     * @see http://wiki.apache.org/solr/LukeRequestHandler#docId
     */
    public function setDocumentId($id)
    {
        return $this->set('docId', $id);
    }

    /**
     * @param string $item
     *
     * @return \PSolr\Request\Luke
     *
     * @see http://wiki.apache.org/solr/LukeRequestHandler#show
     */
    public function setShow($item)
    {
        return $this->set('show', $item);
    }

    /**
     * @param bool $report
     *
     * @return \PSolr\Request\Luke
     *
     * @see http://wiki.apache.org/solr/LukeRequestHandler#reportDocCount
     */
    public function reportDocCount($report)
    {
        return $this->set('reportDocCount', $report);
    }
}
