<?php

namespace PSolr\Request;

/**
 * @see http://wiki.apache.org/solr/UpdateXmlMessages#add.2Freplace_documents
 */
class Add extends SolrRequest
{
    /**
     * @var string
     */
    protected $handlerName = 'update';

    /**
     * @var string
     */
    protected $responseClass = '\PSolr\Response\Response';

    /**
     * @var \PSolr\Request\Document[]
     */
    protected $documents = array();

    /**
     * @var boolean
     */
    protected $overwrite = null;

    /**
     * @var int
     */
    protected $commitWithin = 0;

    /**
     * @param array $params
     */
    public function __construct(array $params = array())
    {
        parent::__construct($params, null);
    }

    /**
     * @param boolean $overwrite
     *
     * @return \PSolr\Request\Add
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22add.22
     */
    public function overwrite($overwrite = true)
    {
        $this->overwrite = $overwrite;
        return $this;
    }

    /**
     * @param int $commitWithin
     *
     * @return \PSolr\Request\Add
     *
     * @see http://wiki.apache.org/solr/UpdateXmlMessages#Optional_attributes_for_.22add.22
     */
    public function commitWithin($commitWithin)
    {
        $this->commitWithin = $commitWithin;
        return $this;
    }

    /**
     * @param \PSolr\Request\Document
     *
     * @return \PSolr\Request\Add
     */
    public function addDocument(Document $document)
    {
        $this->documents[] = $document;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function renderBody()
    {
        $attributes = '';

        if (isset($this->overwrite)) {
            $overwriteValue = $this->overwrite ? 'true' : 'false';
            $attributes .= ' overwrite="' . $overwriteValue . '"';
        }

        if (isset($this->commitWithin)) {
            $attributes .= ' commitWithin="' . (int) $this->commitWithin . '"';
        }

        $xml = '<add' . $attributes . '>';
        foreach ($this->documents as $document) {
            $xml .= $document;
        }
        $xml .= '</add>';

        return self::stripCtrlChars($xml);
    }
}
